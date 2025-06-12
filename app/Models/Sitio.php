<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sitio extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'categoria', 'imagen', 'latitud', 'longitud'];

    public function getImagenUrlAttribute()
    {
        return $this->imagen ? asset($this->imagen) : asset('img/default.png');
    }
}
