<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_peserta',
        'partai_id',
        'pendukung_calon_id',
        'foto_peserta',
        'event_id',
        'qr_code',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function partai()
    {
        return $this->belongsTo(Partai::class);
    }

    public function pendukungCalon()
    {
        return $this->belongsTo(PendukungCalon::class);
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
