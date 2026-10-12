<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturProduk extends Model
{
    protected $table = 'retur_produk';
    protected $primaryKey = 'id_retur';
    public $timestamps = false;

    protected $fillable = [
        'id_detail_pesanan', 'tanggal_retur', 'jumlah_retur',
        'alasan', 'status_retur', 'keputusan_admin',
    ];

    protected function casts(): array
    {
        return ['tanggal_retur' => 'datetime'];
    }

    public function detailPesanan(): BelongsTo
    {
        return $this->belongsTo(
            DetailPesanan::class, 'id_detail_pesanan', 'id_detail_pesanan'
        );
    }
}
