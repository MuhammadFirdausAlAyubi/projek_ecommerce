<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $table = 'brand';
    protected $primaryKey = 'id_brand';
    public $timestamps = false;

    protected $fillable = ['nama_brand', 'deskripsi'];

    public function produk(): HasMany
    {
        return $this->hasMany(Produk::class, 'id_brand', 'id_brand');
    }
}
