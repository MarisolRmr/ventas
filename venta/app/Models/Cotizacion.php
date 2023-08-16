<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizacion';
    protected $fillable = [
        'referencia',
        'fecha',
        'descripcion',
        'total',
        'subtotal',
        'impuestos',
        'user_id',
        'cliente_id',
    ];
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function productosAsociados()
    {
        return $this->hasMany(Cotizacion_Producto::class)->with('producto');
    }

}
