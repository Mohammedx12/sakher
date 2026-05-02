require('dotenv').config();
const express = require('express');
const cors = require('cors');
const path = require('path');
const rateLimit = require('express-rate-limit');
const db = require('./db');

const app = express();
const PORT = process.env.PORT || 3001;
const ADMIN_TOKEN = process.env.ADMIN_TOKEN || 'change-me';
const CORS_ORIGIN = process.env.CORS_ORIGIN || '*';

app.set('trust proxy', 1);
app.use(cors({ origin: CORS_ORIGIN }));
app.use(express.json({ limit: '64kb' }));
app.use(express.urlencoded({ extended: true }));

// Serve frontend statically (so a single Node process can host the whole site)
app.use(express.static(path.join(__dirname, '..', 'frontend')));

// ========== Validation helpers ==========
const sanitize = (v, max = 200) => typeof v === 'string' ? v.trim().slice(0, max) : '';
const validatePhone = (p) => /^[0-9+\s]{8,15}$/.test(p);
const validateEmail = (e) => !e || /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e);

// ========== Rate limit on writes ==========
const writeLimiter = rateLimit({
  windowMs: 15 * 60 * 1000,
  max: 20,
  message: { error: 'Too many requests. Please try again later.' }
});

// ========== Admin auth ==========
const requireAdmin = (req, res, next) => {
  const token = req.headers['x-admin-token'] || req.query.token;
  if (token !== ADMIN_TOKEN) return res.status(401).json({ error: 'Unauthorized' });
  next();
};

// ========== Routes ==========
app.get('/api/health', (req, res) => {
  res.json({ ok: true, time: new Date().toISOString() });
});

// Public: products catalog
app.get('/api/products', (req, res) => {
  const rows = db.prepare('SELECT * FROM products WHERE active = 1 ORDER BY id').all();
  res.json(rows.map(r => ({
    ...r,
    savings: r.market_price ? +(r.market_price - r.our_price).toFixed(2) : 0,
    savings_pct: r.market_price ? Math.round(((r.market_price - r.our_price) / r.market_price) * 100) : 0
  })));
});

// Public: tier packages
app.get('/api/tiers', (req, res) => {
  const rows = db.prepare('SELECT * FROM tiers ORDER BY price_per_person').all();
  res.json(rows.map(r => ({
    code: r.code,
    name_ar: r.name_ar,
    price_per_person: r.price_per_person,
    min_people: r.min_people,
    features: JSON.parse(r.features || '[]')
  })));
});

// Public: submit a lead
app.post('/api/leads', writeLimiter, (req, res) => {
  try {
    const name = sanitize(req.body.name);
    const phone = sanitize(req.body.phone, 20);
    const email = sanitize(req.body.email, 120).toLowerCase();
    const company = sanitize(req.body.company);
    const service = sanitize(req.body.service, 30);
    const tier = sanitize(req.body.tier, 20);
    const peopleNum = parseInt(req.body.people, 10);
    const people = Number.isFinite(peopleNum) && peopleNum > 0 ? peopleNum : null;
    const notes = sanitize(req.body.notes, 500);

    if (!name || name.length < 2) return res.status(400).json({ error: 'الاسم مطلوب' });
    if (!validatePhone(phone)) return res.status(400).json({ error: 'رقم الجوال غير صحيح' });
    if (!validateEmail(email)) return res.status(400).json({ error: 'البريد الإلكتروني غير صحيح' });
    if (!['catering', 'coffee_break', 'both'].includes(service)) {
      return res.status(400).json({ error: 'نوع الخدمة غير صحيح' });
    }
    if (tier && !['', 'bronze', 'silver', 'gold'].includes(tier)) {
      return res.status(400).json({ error: 'الباقة غير صحيحة' });
    }

    const result = db.prepare(`
      INSERT INTO leads (name, phone, email, company, service, tier, people, notes, ip, user_agent)
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    `).run(
      name, phone, email || null, company || null, service,
      tier || null, people, notes || null,
      req.ip, sanitize(req.headers['user-agent'] || '', 250)
    );

    // Notification stub — wire to email/WhatsApp/Slack later
    const newId = Number(result.lastInsertRowid);
    console.log(`[LEAD #${newId}] ${name} | ${phone} | service=${service} tier=${tier || '-'}`);

    res.status(201).json({ ok: true, id: newId });
  } catch (err) {
    console.error('POST /api/leads', err);
    res.status(500).json({ error: 'Server error' });
  }
});

// ========== Admin endpoints ==========
app.get('/api/admin/leads', requireAdmin, (req, res) => {
  const limit = Math.min(parseInt(req.query.limit, 10) || 100, 500);
  const status = sanitize(req.query.status, 20);
  let rows;
  if (status) {
    rows = db.prepare('SELECT * FROM leads WHERE status = ? ORDER BY created_at DESC LIMIT ?').all(status, limit);
  } else {
    rows = db.prepare('SELECT * FROM leads ORDER BY created_at DESC LIMIT ?').all(limit);
  }
  res.json({ count: rows.length, leads: rows });
});

app.patch('/api/admin/leads/:id', requireAdmin, (req, res) => {
  const id = parseInt(req.params.id, 10);
  const status = sanitize(req.body.status, 20);
  if (!['new', 'contacted', 'closed', 'lost'].includes(status)) {
    return res.status(400).json({ error: 'Invalid status' });
  }
  const r = db.prepare('UPDATE leads SET status = ? WHERE id = ?').run(status, id);
  if (r.changes === 0) return res.status(404).json({ error: 'Not found' });
  res.json({ ok: true });
});

app.get('/api/admin/stats', requireAdmin, (req, res) => {
  const total = Number(db.prepare('SELECT COUNT(*) AS c FROM leads').get().c);
  const byStatus = db.prepare('SELECT status, COUNT(*) AS c FROM leads GROUP BY status').all()
    .map(r => ({ status: r.status, c: Number(r.c) }));
  const byService = db.prepare('SELECT service, COUNT(*) AS c FROM leads GROUP BY service').all()
    .map(r => ({ service: r.service, c: Number(r.c) }));
  const last7 = Number(db.prepare(`SELECT COUNT(*) AS c FROM leads WHERE created_at >= datetime('now', '-7 days')`).get().c);
  res.json({ total, last7, byStatus, byService });
});

// 404 for unknown API routes
app.use('/api', (req, res) => res.status(404).json({ error: 'Not found' }));

app.listen(PORT, () => {
  console.log(`Sakher API running at http://localhost:${PORT}`);
  console.log(`Frontend served from /frontend at the same port`);
  console.log(`Admin dashboard: http://localhost:${PORT}/admin.html`);
});
