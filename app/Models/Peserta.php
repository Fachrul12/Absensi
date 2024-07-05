<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = "peserta";
    protected $primaryKey = "id";
    protected $fillable = [
        'id','nama','partai','pendukung_calon'
    ];
    
}
