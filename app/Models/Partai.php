<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partai extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_partai',
        'bendera_partai',
    ];

    public function pesertas()
    {
        return $this->hasMany(Peserta::class);
    }
}
