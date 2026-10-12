<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{
    protected $table = 'bank';
    protected $primaryKey = 'id_bank';
    public $timestamps = false;

    protected $fillable = ['nama_bank', 'no_rekening', 'atas_nama', 'status_bank'];

    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'id_bank', 'id_bank');
    }
}
