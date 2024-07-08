<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesertaHadir extends Model
{
    use HasFactory;

    protected $fillable = [
        'peserta_id',
        'event_id',
        'tanggal_hadir',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
