<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengiriman extends Model
{
    protected $table = 'pengiriman';
    protected $primaryKey = 'id_pengiriman';
    public $timestamps = false;

    protected $fillable = [
        'id_pesanan', 'id_ekspedisi', 'no_resi',
        'tanggal_pengiriman', 'tanggal_diterima', 'status_pengiriman',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pengiriman' => 'datetime',
            'tanggal_diterima' => 'datetime',
        ];
    }

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function ekspedisi(): BelongsTo
    {
        return $this->belongsTo(Ekspedisi::class, 'id_ekspedisi', 'id_ekspedisi');
    }
}
