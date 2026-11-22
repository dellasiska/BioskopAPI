<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bioskop extends Model
{
    protected $table = 'bioskop';

    protected $fillable = [
        'nama_bioskop',
        'alamat',
        'kota',
        'no_telepon',
        'email',
        'jumlah_studio',
        'kapasitas_total',
        'jam_operasional',
        'status'
    ];

    public function jadwalFilm()
    {
        return $this->hasMany(JadwalFilm::class, 'bioskop_id');
    }
}