<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Peserta;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_event',
        'kategori_id',
        'tanggal_acara',
    ];

    public function peserta()
    {
    return $this->hasMany(Peserta::class);
    }

    public function pesertaHadir()
    {
        return $this->hasMany(PesertaHadir::class);
    }

    public function background()
{
    return $this->belongsTo(Background::class);
}

}
