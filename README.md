# Kotakin — Modern Warehouse Inventory Management System

**Kotakin** adalah sistem manajemen inventaris gudang berbasis Laravel 13 dan Filament v5 dengan antarmuka monokrom yang cepat, efisien, serta dilengkapi proteksi stok anti-minus otomatis, hak akses bertingkat, dasbor analitik real-time, dan generator QR Code SKU instan.

---

## 🌟 Key Features

- **Role-Based Access Control**:
  - **Admin**: Akses penuh ke Filament Admin Panel (`/admin`) untuk mengelola master data, memantau *analytics*, dan mencatat transaksi stok.
  - **Karyawan**: Akses terbatas ke Katalog Publik (`/`) untuk mengecek stok real-time, posisi rak, dan melihat QR Code tanpa akses ke dasbor admin.
- **Observer-Based Stock Protection**: Validasi otomatis *anti-stok minus* saat transaksi pengeluaran (`out`) dan penyesuaian stok (`adjustment`).
- **Real-time Analytics & Alert Widgets**: Dasbor admin dilengkapi statistik nilai aset gudang serta *Low Stock Alert Widget* untuk barang yang butuh *restock*.
- **Instant QR Code SKU**: Otomatis membuat QR Code berdasarkan SKU barang dan kode rak untuk memudahkan pencetakan label fisik.
- **Ultra-Minimalist Monochrome UX**: Antarmuka katalog publik yang ringkas dan responsif dengan fitur *Quick Modal Detail* berbasis Alpine.js.

---

## 🛠️ Tech Stack

| Component | Technology |
|---|---|
| **Framework** | Laravel 13 |
| **Admin Panel** | Filament v5 |
| **Database** | SQLite |
| **Frontend** | Blade, Tailwind CSS, Alpine.js |
| **QR Engine** | Chillerlan PHP-QRCode |

---

## 🚀 Getting Started

### Prerequisites
- PHP >= 8.3
- Composer
- SQLite Extension enabled

### Installation

1. **Clone Repository**
   git clone https://github.com/Rven24/Kotakin-App.git
   cd Kotakin-App

2. **Install Dependencies**
   composer install

3. **Environment Setup**
   cp .env.example .env
   php artisan key:generate

4. **Database Setup & Seeder**
   touch database/database.sqlite
   php artisan migrate --seed

5. **Run Application**
   php artisan serve

Akses aplikasi di browser melalui `http://127.0.0.1:8000`

---

## 🔐 Default Credentials

| Role | Email | Password | Redirect Path |
|---|---|---|---|
| **Admin** | admin@kotakin.com | password123 | `/admin` |
| **Karyawan** | budi@kotakin.com | password123 | `/` |

---

## 🗄️ Database Manual Seeding (SQLite)

Jika ingin menambahkan akun karyawan secara manual melalui CLI atau DB Browser for SQLite:

INSERT INTO users (name, email, password, role, created_at, updated_at) 
VALUES (
    'Budi Karyawan', 
    'budi@kotakin.com', 
    '$2y$12$eA4l0hS6L8.w3.bK/qZ4x.aN.F0S8U2lV9.5z3G5.K8G1L8N1Xm2W', 
    'karyawan', 
    DATETIME('now'), 
    DATETIME('now')
);