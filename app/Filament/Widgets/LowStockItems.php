<?php

namespace App\Filament\Widgets;

use App\Models\Item;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LowStockItems extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';

    protected static ?string $heading = 'Peringatan Stok Menipis (Butuh Restock)';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Item::query()->whereColumn('stock', '<=', 'min_stock')
            )
            ->columns([
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->fontFamily('mono'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Barang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location.name')
                    ->label('Lokasi Rak'),
                Tables\Columns\TextColumn::make('stock')
                    ->label('Sisa Stok')
                    ->badge()
                    ->color('danger'),
                Tables\Columns\TextColumn::make('min_stock')
                    ->label('Batas Min.'),
                Tables\Columns\TextColumn::make('unit')
                    ->label('Satuan'),
            ]);
    }
}