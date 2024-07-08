<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendukungCalon extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_calon',
        'event_id',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function pesertas()
    {
        return $this->hasMany(Peserta::class);
    }
}
