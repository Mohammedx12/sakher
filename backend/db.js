const { DatabaseSync } = require('node:sqlite');
const path = require('path');

const db = new DatabaseSync(path.join(__dirname, 'sakher.db'));
db.exec('PRAGMA journal_mode = WAL');

db.exec(`
CREATE TABLE IF NOT EXISTS leads (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name TEXT NOT NULL,
  phone TEXT NOT NULL,
  email TEXT,
  company TEXT,
  service TEXT NOT NULL,
  tier TEXT,
  people INTEGER,
  notes TEXT,
  status TEXT DEFAULT 'new',
  ip TEXT,
  user_agent TEXT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name_ar TEXT NOT NULL,
  description_ar TEXT,
  category TEXT,
  our_price REAL NOT NULL,
  market_price REAL,
  unit TEXT,
  active INTEGER DEFAULT 1
);

CREATE TABLE IF NOT EXISTS tiers (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  code TEXT UNIQUE NOT NULL,
  name_ar TEXT NOT NULL,
  price_per_person REAL NOT NULL,
  min_people INTEGER DEFAULT 30,
  features TEXT
);
`);

// Seed products if empty
const productCount = Number(db.prepare('SELECT COUNT(*) AS c FROM products').get().c);
if (productCount === 0) {
  const insert = db.prepare(`
    INSERT INTO products (name_ar, description_ar, category, our_price, market_price, unit)
    VALUES (?, ?, ?, ?, ?, ?)
  `);
  const rows = [
    ['نسكافيه كلاسيك', '190 جرام، الحجم الكبير', 'مشروبات ساخنة', 24.24, 35.95, 'علبة'],
    ['مبيض القهوة', '170 جرام، الحجم الكبير', 'مشروبات ساخنة', 6.32, 11.95, 'علبة'],
    ['شاي ليبتون', 'كرتون 100 كيس', 'مشروبات ساخنة', 11.55, 17.81, 'كرتون'],
    ['كرتون ماء نوفا', '330مل، 40 قارورة', 'مياه', 18.56, 24.46, 'كرتون'],
    ['قهوة كيف المسافر', 'بطعم الهيل، 10 دلال', 'مشروبات ساخنة', 48.95, 55.00, 'كرتون'],
    ['سكر أظرف أندرينا', 'كرتون 100 ظرف', 'إضافات', 6.16, 10.96, 'كرتون']
  ];
  db.exec('BEGIN');
  for (const r of rows) insert.run(...r);
  db.exec('COMMIT');
}

// Seed tiers if empty
const tierCount = Number(db.prepare('SELECT COUNT(*) AS c FROM tiers').get().c);
if (tierCount === 0) {
  const insertT = db.prepare(`
    INSERT INTO tiers (code, name_ar, price_per_person, min_people, features)
    VALUES (?, ?, ?, ?, ?)
  `);
  insertT.run('bronze', 'الفئة البرونزية', 85, 30, JSON.stringify([
    'ميني ساندويتش (لبنة، تونة، تيركي)',
    'ميني كلوب ساندويتش',
    'دجاج مسخن رول + لحم مفروم بخبز البيتا',
    'كروسان جبن، سينامون، بنانا كيك، ميني أوبرا',
    'فواكه طازجة في كاسات صغار',
    'قهوة أمريكانو، شاي متنوع، مياه'
  ]));
  insertT.run('silver', 'الفئة الفضية', 125, 30, JSON.stringify([
    'كل عناصر الفئة البرونزية',
    'ميني شاورما تركية + سبرينق رول خضار',
    'ساندوتش الجبن المشوي بالزعتر',
    'مافن (شوكلت، فانيلا)',
    'عصير برتقال طازج + جهاز قهوة (كابتشينو ولاتيه)',
    'مشروب سعودي شامبين + مياه زجاجية'
  ]));
  insertT.run('gold', 'الفئة الذهبية', 155, 30, JSON.stringify([
    'كروك مدام الفرنسي + ميلانو مكسيكي',
    'لفائف حلومي بيستو وطماطم مجففة',
    'ميني بيتزا زيتون نباتية + ميني شاورما',
    'كاسترد دانيش، ريد فلفت سويس رول، ماربل كيك',
    'ميني دونات + كوكيز الفانيليا + شوفان التفاح',
    'أعواد فواكه + عصير بطيخ + عصير تفاح وجزر'
  ]));
}

module.exports = db;
