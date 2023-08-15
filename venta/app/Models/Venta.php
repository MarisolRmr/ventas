<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;
    protected $table = 'venta';
    protected $fillable = [
        'referencia',
        'fecha',
        'pagocon',
        'cambio',
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

    public function ventaProductos() {
        return $this->hasMany(Venta_Producto::class, 'venta_id');
    }

    
}
