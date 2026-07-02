<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $primaryKey = 'idInventario';
    protected $table = 'inventarios';

    public function libro()
    {
        return $this->belongsTo(Libro::class, 'idLibro', 'idLibro');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'idSucursal', 'idSucursal');
    }

    public function editorial()
    {
        return $this->belongsTo(Editorial::class, 'idEditorial', 'idEditorial');
    }
}