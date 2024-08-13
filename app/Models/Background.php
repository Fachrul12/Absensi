<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Background extends Model
{
    use HasFactory;

    // Background.php
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
