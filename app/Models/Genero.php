<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    protected $primaryKey = 'idGenero';

    public function libros()
    {
        return $this->hasMany(Libro::class, 'idGenero', 'idGenero');
    }
}