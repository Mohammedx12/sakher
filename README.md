# صخر للضيافة والتموين — Full-stack Website

موقع لشركة صخر للضيافة والتموين في الرياض، مع واجهة عربية RTL ولوحة إدارة لاستقبال طلبات العملاء.

## Stack

- **Frontend:** Static HTML/CSS/JS (single-page landing + admin page) — Arabic RTL, El Messiri + IBM Plex Sans Arabic
- **Backend:** Node.js + Express, SQLite via `better-sqlite3`, rate limiting, simple admin token auth

## Project Structure

```
sakher/
├── frontend/
│   ├── index.html       # Landing page (with lead-capture modal)
│   └── admin.html       # Admin dashboard (token-protected)
├── backend/
│   ├── server.js        # Express server + API routes
│   ├── db.js            # SQLite schema + seed data
│   ├── package.json
│   ├── .env.example
│   └── .gitignore
└── README.md
```

## Quick Start

### 1. Install backend dependencies

```bash
cd backend
npm install
```

### 2. Configure environment

```bash
cp .env.example .env
# Edit .env and set ADMIN_TOKEN to a strong secret
```

### 3. Run the server

```bash
npm start
# or with auto-reload:
npm run dev
```

The server runs on `http://localhost:3001` and serves both the API **and** the frontend (`frontend/` is served statically).

- Landing page: <http://localhost:3001/>
- Admin dashboard: <http://localhost:3001/admin.html>

## API Endpoints

### Public

| Method | Path | Purpose |
|--------|------|---------|
| `GET`  | `/api/health` | Health check |
| `GET`  | `/api/products` | Catalog with our price + market price + savings |
| `GET`  | `/api/tiers` | Bronze / Silver / Gold packages with features |
| `POST` | `/api/leads` | Submit a lead from the website form (rate-limited) |

**`POST /api/leads` body:**

```json
{
  "name": "string (required, ≥2 chars)",
  "phone": "string (required, 8–15 digits)",
  "email": "string (optional)",
  "company": "string (optional)",
  "service": "catering | coffee_break | both (required)",
  "tier": "bronze | silver | gold (optional)",
  "people": "number (optional, ≥1)",
  "notes": "string (optional, max 500)"
}
```

### Admin (require `X-Admin-Token` header)

| Method | Path | Purpose |
|--------|------|---------|
| `GET`   | `/api/admin/stats` | Totals, last 7 days, by status, by service |
| `GET`   | `/api/admin/leads?status=new` | List leads (optional filter) |
| `PATCH` | `/api/admin/leads/:id` | Update status (`new` / `contacted` / `closed` / `lost`) |

## Deployment Notes

- **Single-process hosting:** the Express server already serves the static frontend, so deploying to any Node host (Render, Railway, Fly.io, a VPS) is enough.
- **Reverse proxy:** if behind nginx, point all traffic to the Node port — the static files and `/api/*` are on the same origin.
- **Production hardening:**
  - Set a strong `ADMIN_TOKEN`
  - Restrict `CORS_ORIGIN` to your domain
  - Put behind HTTPS
  - Add a real notification channel (email / WhatsApp / Slack) where the `console.log` is in `POST /api/leads`
- **Backups:** `sakher.db` is a single SQLite file; copy it on a schedule.

## Customizing

- **Brand tokens** live as CSS variables in the `<style>` block at the top of `frontend/index.html` (`--wood`, `--cream`, `--tan`, etc.)
- **Tier prices & products** are seeded in `backend/db.js` on first run. To change later, edit the `tiers` / `products` tables directly or extend the admin to manage them.
- **WhatsApp number** is hardcoded as `966535563801` in the frontend — search-and-replace if it changes.
