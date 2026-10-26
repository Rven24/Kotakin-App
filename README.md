# Kotakin — Modern Warehouse Inventory Management System

**Kotakin** adalah sistem manajemen inventaris gudang yang dirancang untuk efisiensi tinggi, antarmuka minimalis monokrom, dan keamanan mutasi stok secara *real-time*. Dibangun menggunakan ekosistem **Laravel 13**, **Filament v5**, **Tailwind CSS**, dan **Alpine.js** dengan database **SQLite**.

---

### Key Features

* **Role-Based Access Control**:
  * **Admin**: Akses penuh ke Filament Admin Panel (`/admin`) untuk mengelola master data, memantau *analytics*, dan transaksi stok.
  * **Karyawan**: Akses terbatas ke Katalog Publik (`/`) untuk cek stok real-time, lokasi rak, dan QR Code tanpa hak akses ke dasbor admin.
* **Observer-Based Stock Protection**: Logika validasi *anti-stok minus* otomatis saat terjadi transaksi pengeluaran (`out`), serta dukungan transaksi penyesuaian (`adjustment`).
* **Real-time Analytics & Alert Widgets**: Dasbor admin dilengkapi statistik total nilai aset gudang serta *Low Stock Alert Widget* untuk barang yang butuh *restock* cepat.
* **Instant QR Code SKU**: Otomatis generate QR Code untuk setiap SKU barang dan kode rak agar mempermudah proses pemindaian (*scanning*) dan cetak label fisik.
* **Ultra-Minimalist Monochrome UX**: Antarmuka katalog publik yang bersih, cepat, dan responsif dengan fitur *Quick Modal Detail* berbasis Alpine.js.

---

### Tech Stack

| Component | Technology |
|---|---|
| **Framework** | Laravel 13 |
| **Admin Panel** | Filament v5 |
| **Database** | SQLite |
| **Frontend** | Blade, Tailwind CSS, Alpine.js |
| **QR Engine** | Chillerlan PHP-QRCode |

---

### Getting Started

#### Prerequisites
* PHP >= 8.3
* Composer
* SQLite Extension enabled

#### Installation

1. **Clone repository**
   git clone https://github.com/Rven24/Kotakin-App.git
   cd kotakin

2. **Install dependencies**
   composer install

3. **Environment Setup**
   cp .env.example .env
   php artisan key:generate

4. **Database & Seeder**
   touch database/database.sqlite
   php artisan migrate --seed

5. **Run Application**
   php artisan serve

Akses aplikasi melalui `http://127.0.0.1:8000`

---

### Default Credentials

| Role | Email | Password | Redirect |
|---|---|---|---|
| **Admin** | admin@kotakin.com | password123 | `/admin` |
| **Karyawan** | budi@kotakin.com | password123 | `/` |

---

### Database Manual Seeding (SQLite)

Jika ingin menambahkan user karyawan secara manual via SQL CLI / DB Browser for SQLite:

INSERT INTO users (name, email, password, role, created_at, updated_at) 
VALUES (
    'Budi Karyawan', 
    'budi@kotakin.com', 
    '$2y$12$eA4l0hS6L8.w3.bK/qZ4x.aN.F0S8U2lV9.5z3G5.K8G1L8N1Xm2W', 
    'karyawan', 
    DATETIME('now'), 
    DATETIME('now')
);