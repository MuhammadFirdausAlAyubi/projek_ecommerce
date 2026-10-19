<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Produk extends Model
{
    protected $table = 'produk';

    protected $primaryKey = 'id_produk';

    public $timestamps = false;

    protected $fillable = [
        'id_kategori',
        'id_brand',
        'nama_produk',
        'deskripsi',
        'spesifikasi',
        'harga_jual',
        'gambar',
        'status_produk',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'harga_jual' => 'decimal:2',
            'created_at' => 'datetime',
        ];
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(
            Kategori::class,
            'id_kategori',
            'id_kategori'
        );
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(
            Brand::class,
            'id_brand',
            'id_brand'
        );
    }

    public function stok(): HasOne
    {
        return $this->hasOne(
            Stok::class,
            'id_produk',
            'id_produk'
        );
    }

    public function supplierProduk(): HasMany
    {
        return $this->hasMany(
            SupplierProduk::class,
            'id_produk',
            'id_produk'
        );
    }

    public function supplier(): BelongsToMany
    {
        return $this->belongsToMany(
            Supplier::class,
            'supplier_produk',
            'id_produk',
            'id_supplier',
            'id_produk',
            'id_supplier'
        )->withPivot([
            'id_supplier_produk',
            'harga_beli',
            'waktu_penyediaan',
        ]);
    }

    public function detailPembelian(): HasMany
    {
        return $this->hasMany(
            DetailPembelian::class,
            'id_produk',
            'id_produk'
        );
    }

    public function detailKeranjang(): HasMany
    {
        return $this->hasMany(
            DetailKeranjang::class,
            'id_produk',
            'id_produk'
        );
    }

    public function detailPesanan(): HasMany
    {
        return $this->hasMany(
            DetailPesanan::class,
            'id_produk',
            'id_produk'
        );
    }

    public function fotoProduk(): HasMany
    {
        return $this->hasMany(
            FotoProduk::class,
            'id_produk',
            'id_produk'
        )->orderBy('urutan');
    }

    /**
     * Varian produk seperti warna dan kapasitas.
     */
    public function varianProduk(): HasMany
    {
        return $this->hasMany(
            VarianProduk::class,
            'id_produk',
            'id_produk'
        );
    }

    /**
     * Ulasan yang diberikan pelanggan untuk produk.
     */
    public function ulasanProduk(): HasMany
    {
        return $this->hasMany(
            UlasanProduk::class,
            'id_produk',
            'id_produk'
        );
    }
}
