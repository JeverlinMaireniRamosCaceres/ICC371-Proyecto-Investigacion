<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    protected $primaryKey = 'idEditorial';

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'idProveedor', 'idProveedor');
    }

    public function inventarios()
    {
        return $this->hasMany(Inventario::class, 'idEditorial', 'idEditorial');
    }
}