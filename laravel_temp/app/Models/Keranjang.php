<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    public $timestamps = false;

    protected $fillable = ['id_user', 'tanggal_dibuat', 'status_keranjang'];

    protected function casts(): array
    {
        return ['tanggal_dibuat' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function detailKeranjang(): HasMany
    {
        return $this->hasMany(DetailKeranjang::class, 'id_keranjang', 'id_keranjang');
    }
}
