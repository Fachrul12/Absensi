<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_peserta',      
        'foto_peserta',
        'event_id',   
        'isi_kategori_peserta_id',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }    

    public function IsiKategoriPeserta()
    {
        return $this->belongsTo(IsiKategoriPeserta::class, 'isi_kategori_peserta_id');
    }  
    
    public function pesertaHadir()
    {
        return $this->hasMany(PesertaHadir::class);
    }

    public function kehadiran()
    {
        return $this->hasMany(PesertaHadir::class);
    }

    public function getStatusHadirAttribute()
    {
        $hadir = $this->kehadiran()->whereNotNull('tanggal_hadir')->exists();
        return $hadir ? 'Hadir' : 'Belum Hadir';
    }
}
