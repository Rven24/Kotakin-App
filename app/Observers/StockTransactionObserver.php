<?php

namespace App\Observers;

use App\Models\StockTransaction;
use Exception;

class StockTransactionObserver
{
    public function creating(StockTransaction $stockTransaction): void
    {
        // Cegah transaksi pengeluaran jika stok tidak cukup
        if ($stockTransaction->type === 'out') {
            $item =$stockTransaction->item;
            if ($item->stock <$stockTransaction->quantity) {
                throw new Exception("Stok tidak mencukupi! Sisa stok {$item->name} saat ini hanya {$item->stock}.");
            }
        }
    }

    public function created(StockTransaction $stockTransaction): void
    {
        $item =$stockTransaction->item;

        if ($stockTransaction->type === 'in') {
            $item->increment('stock',$stockTransaction->quantity);
        } elseif ($stockTransaction->type === 'out') {
            $item->decrement('stock',$stockTransaction->quantity);
        } elseif ($stockTransaction->type === 'adjustment') {
            // Penyesuaian stok langsung ke angka fisik
            $item->update(['stock' =>$stockTransaction->quantity]);
        }
    }
}