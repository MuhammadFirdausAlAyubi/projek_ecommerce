<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    public $timestamps = false;

        
    protected $fillable = [
        'id_user',
        'id_alamat',
        'alamat_pengiriman_snapshot',
        'tanggal_pesanan',
        'total_harga',
        'ongkir',
        'status_pesanan',
    ];

protected function casts(): array
{
    return [
        'tanggal_pesanan' => 'datetime',
        'total_harga' => 'decimal:2',
        'ongkir' => 'decimal:2',
    ];
}


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function alamat(): BelongsTo
    {
        return $this->belongsTo(Alamat::class, 'id_alamat', 'id_alamat');
    }

    public function detailPesanan(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'id_pesanan', 'id_pesanan');
    }

    public function pengiriman(): HasOne
    {
        return $this->hasOne(Pengiriman::class, 'id_pesanan', 'id_pesanan');
    }
}
