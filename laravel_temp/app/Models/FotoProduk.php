<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoProduk extends Model
{
    protected $table = 'foto_produk';

    protected $primaryKey = 'id_foto_produk';

    protected $fillable = [
        'id_produk',
        'gambar',
        'urutan',
    ];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(
            Produk::class,
            'id_produk',
            'id_produk'
        );
    }
}