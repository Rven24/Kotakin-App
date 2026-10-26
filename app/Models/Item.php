<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

class Item extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function transactions()
    {
        return $this->hasMany(StockTransaction::class);
    }

    // Helper untuk Generate QR Code dari SKU
    public function getQrCodeUriAttribute(): string
    {
        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'eccLevel'   => QRCode::ECC_L,
        ]);

        return (new QRCode($options))->render($this->sku);
    }
}