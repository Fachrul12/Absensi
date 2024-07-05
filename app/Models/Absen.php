<?php

namespace App\Models;

use App\Models\Peserta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function peserta()
    {
        return $this->hasOne(Peserta::class,'id_peserta','id_peserta');
    }
}
