<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    protected $primaryKey = 'idAutor';
    protected $table = 'autores';

    public function libros()
    {
        return $this->belongsToMany(
            Libro::class,
            'libro_autor',
            'idAutor',
            'idLibro'
        );
    }
}