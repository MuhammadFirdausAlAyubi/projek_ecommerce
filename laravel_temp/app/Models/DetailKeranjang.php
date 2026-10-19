<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailKeranjang extends Model
{
    protected $table = 'detail_keranjang';

    protected $primaryKey = 'id_detail_keranjang';

    public $timestamps = false;

    protected $fillable = [
        'id_keranjang',
        'id_produk',
        'id_varian',
        'jumlah',
        'tanggal_ditambahkan',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'integer',
            'tanggal_ditambahkan' => 'datetime',
        ];
    }

    public function keranjang(): BelongsTo
    {
        return $this->belongsTo(
            Keranjang::class,
            'id_keranjang',
            'id_keranjang'
        );
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(
            Produk::class,
            'id_produk',
            'id_produk'
        );
    }

    public function varian(): BelongsTo
    {
        return $this->belongsTo(
            VarianProduk::class,
            'id_varian',
            'id_varian'
        );
    }
}