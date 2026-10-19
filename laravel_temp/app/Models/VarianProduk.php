<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VarianProduk extends Model
{
    protected $table = 'varian_produk';

    protected $primaryKey = 'id_varian';

    protected $fillable = [
        'id_produk',
        'nama_varian',
        'warna',
        'kapasitas',
        'harga',
        'jumlah_stok',
        'gambar',
        'status_varian',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
            'jumlah_stok' => 'integer',
            'status_varian' => 'boolean',
        ];
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(
            Produk::class,
            'id_produk',
            'id_produk'
        );
    }
}