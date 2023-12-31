<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model{

    use HasFactory;
    protected $table = 'proveedor';
    protected $fillable = [
        'nombre',
        'codigo',
        'telefono',
        'email',
        'pais',
        'ciudad',
        'direccion',
        'imagen'
    ];
}
