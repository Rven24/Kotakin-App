<?php

namespace App\Filament\Widgets;

use App\Models\Item;
use App\Models\StockTransaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalItems = Item::count();
        $totalAssetValue = Item::selectRaw('SUM(stock * price) as total')->value('total') ?? 0;
        $lowStockItems = Item::whereColumn('stock', '<=', 'min_stock')->count();

        return [
            Stat::make('Total Jenis Barang', $totalItems . ' SKU')
                ->description('Jumlah item terdaftar')
                ->color('info'),

            Stat::make('Estimasi Nilai Aset', 'Rp ' . number_format($totalAssetValue, 0, ',', '.'))
                ->description('Total akumulasi harga x stok')
                ->color('success'),

            Stat::make('Stok Menipis (Alert)', $lowStockItems . ' Barang')
                ->description('Perlu restock secepatnya')
                ->color($lowStockItems > 0 ? 'danger' : 'gray'),
        ];
    }
}