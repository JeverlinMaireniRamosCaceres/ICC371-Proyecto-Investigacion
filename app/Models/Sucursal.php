<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $primaryKey = 'idSucursal';
    protected $table = 'sucursales';

    public function encargado()
    {
        return $this->belongsTo(Encargado::class, 'idEmpleado', 'idEncargado');
    }

    public function inventarios()
    {
        return $this->hasMany(Inventario::class, 'idSucursal', 'idSucursal');
    }
}