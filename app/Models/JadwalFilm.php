<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalFilm extends Model
{
    protected $table = 'jadwal_film';

    protected $fillable = [
        'bioskop_id',
        'judul_film',
        'genre',
        'studio',
        'tanggal_tayang',
        'jam_mulai',
        'harga_tiket',
        'status_tayang'
    ];

    public function bioskop()
    {
        return $this->belongsTo(Bioskop::class, 'bioskop_id');
    }
}