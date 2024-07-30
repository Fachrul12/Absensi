<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPeserta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategori_peserta',       
    ];
    

    public function isikategoripesertas()
    {
        return $this->hasMany(IsiKategoriPeserta::class,  'kategori_peserta_id');
    }

}
