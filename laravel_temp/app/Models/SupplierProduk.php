<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierProduk extends Model
{
    protected $table = 'supplier_produk';
    protected $primaryKey = 'id_supplier_produk';
    public $timestamps = false;

    protected $fillable = [
        'id_supplier', 'id_produk', 'harga_beli', 'waktu_penyediaan',
    ];

    protected function casts(): array
    {
        return ['harga_beli' => 'decimal:2'];
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
