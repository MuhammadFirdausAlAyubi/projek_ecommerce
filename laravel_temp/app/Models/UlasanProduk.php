<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UlasanProduk extends Model
{
    protected $table = 'ulasan_produk';

    protected $primaryKey = 'id_ulasan';

    protected $fillable = [
        'id_produk',
        'id_user',
        'id_detail_pesanan',
        'rating',
        'komentar',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
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

      public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'id_user',
            'id_user'
        );
    }

    public function detailPesanan(): BelongsTo
    {
        return $this->belongsTo(
            DetailPesanan::class,
            'id_detail_pesanan',
            'id_detail_pesanan'
        );
    }
}