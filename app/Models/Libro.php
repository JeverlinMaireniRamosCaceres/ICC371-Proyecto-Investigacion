<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $primaryKey = 'idLibro';
    protected $table = 'libros';

    public function genero()
    {
        return $this->belongsTo(Genero::class, 'idGenero', 'idGenero');
    }

    public function autores()
    {
        return $this->belongsToMany(
            Autor::class,
            'libro_autor',
            'idLibro',
            'idAutor'
        );
    }

    public function inventarios()
    {
        return $this->hasMany(Inventario::class, 'idLibro', 'idLibro');
    }
}