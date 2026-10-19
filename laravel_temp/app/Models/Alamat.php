<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    protected $table = 'alamat';

    protected $primaryKey = 'id_alamat';

    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'nama_penerima',
        'no_telp_penerima',
        'provinsi',
        'kota',
        'kecamatan',
        'kode_pos',
        'alamat_lengkap',
        'is_utama',
    ];

    protected function casts(): array
    {
        return [
            'is_utama' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
