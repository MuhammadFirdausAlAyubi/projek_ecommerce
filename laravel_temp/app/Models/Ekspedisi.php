<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ekspedisi extends Model
{
    protected $table = 'ekspedisi';
    protected $primaryKey = 'id_ekspedisi';
    public $timestamps = false;

    protected $fillable = ['nama_ekspedisi', 'status_ekspedisi'];

    public function pengiriman(): HasMany
    {
        return $this->hasMany(Pengiriman::class, 'id_ekspedisi', 'id_ekspedisi');
    }
}
