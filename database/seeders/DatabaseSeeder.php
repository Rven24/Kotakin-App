<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Location;
use App\Models\Item;
use App\Models\StockTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User Admin Default (Jika belum ada)
        $user = User::firstOrCreate(
            ['email' => 'admin@kotakin.com'],
            [
                'name' => 'Admin Kotakin',
                'password' => bcrypt('admin'),
                'role' => 'admin',
            ]
        );

        // 2. Data Kategori
        $categories = [
            ['name' => 'Elektronik & Perangkat', 'slug' => 'elektronik-perangkat', 'description' => 'Peralatan elektronik dan perangkat pendukung gudang.'],
            ['name' => 'Suku Cadang & Komponen', 'slug' => 'suku-cadang-komponen', 'description' => 'Sparepart mesin, kabel, dan komponen perkakas.'],
            ['name' => 'Peralatan Kantor', 'slug' => 'peralatan-kantor', 'description' => 'Alat tulis kantor, kertas, dan perlengkapan administrasi.'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // 3. Data Lokasi / Rak Gudang
        $locations = [
            ['name' => 'Rak Utama A1', 'code' => 'RAK-A1', 'description' => 'Barang cepat cair (Fast-moving items).'],
            ['name' => 'Rak Komponen B2', 'code' => 'RAK-B2', 'description' => 'Suku cadang kecil dan perangkat elektronik.'],
            ['name' => 'Area Penyimpanan C', 'code' => 'ZONE-C', 'description' => 'Penyimpanan stok barang berukuran besar.'],
        ];

        foreach ($locations as $loc) {
            Location::create($loc);
        }

        // 4. Data Barang (Items)
        $items = [
            [
                'category_id' => 1,
                'location_id' => 1,
                'sku' => 'ITM-BARCODE-01',
                'name' => 'Barcode Scanner Wireless',
                'stock' => 15,
                'min_stock' => 5,
                'unit' => 'unit',
                'price' => 450000,
            ],
            [
                'category_id' => 1,
                'location_id' => 2,
                'sku' => 'ITM-PRINTER-02',
                'name' => 'Thermal Label Printer',
                'stock' => 8,
                'min_stock' => 3,
                'unit' => 'unit',
                'price' => 1250000,
            ],
            [
                'category_id' => 2,
                'location_id' => 2,
                'sku' => 'SP-KABEL-LAN-50M',
                'name' => 'Kabel UTP Cat6 50 Meter',
                'stock' => 3,
                'min_stock' => 5, // Stok di bawah minimum (pemicu alert stok menipis)
                'unit' => 'roll',
                'price' => 350000,
            ],
            [
                'category_id' => 3,
                'location_id' => 3,
                'sku' => 'ATK-KERTAS-A4',
                'name' => 'Kertas HVS A4 80gsm',
                'stock' => 50,
                'min_stock' => 10,
                'unit' => 'rim',
                'price' => 55000,
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }

        // 5. Sample Histori Transaksi Stok
        StockTransaction::create([
            'item_id' => 1,
            'user_id' => $user->id,
            'type' => 'in',
            'quantity' => 15,
            'notes' => 'Penerimaan barang awal dari supplier.',
        ]);

        StockTransaction::create([
            'item_id' => 3,
            'user_id' => $user->id,
            'type' => 'out',
            'quantity' => 2,
            'notes' => 'Pengambilan kabel untuk area operasional.',
        ]);
    }
}