<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Supplier extends Model
{
    protected $table = 'supplier';

    protected $primaryKey = 'id_supplier';

    public $timestamps = false;

    protected $fillable = [
        'nama_supplier',
        'alamat_supplier',
        'no_telp',
        'email',
    ];

    public function pembelian(): HasMany
    {
        return $this->hasMany(
            Pembelian::class,
            'id_supplier',
            'id_supplier'
        );
    }

    public function supplierProduk(): HasMany
    {
        return $this->hasMany(
            SupplierProduk::class,
            'id_supplier',
            'id_supplier'
        );
    }

    public function produk(): BelongsToMany
    {
        return $this->belongsToMany(
            Produk::class,
            'supplier_produk',
            'id_supplier',
            'id_produk'
        )->withPivot([
            'id_supplier_produk',
            'harga_beli',
            'waktu_penyediaan',
        ]);
    }
}
