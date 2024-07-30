<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IsiKategoriPeserta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_isi_kategori_peserta',      
        'kategori_peserta_id',   
    ];

    public function pesertas()
    {
        return $this->hasMany(Peserta::class);
    }
    
    public function kategoripesertas()
    {
        return $this->belongsTo(KategoriPeserta::class);
    }
}
