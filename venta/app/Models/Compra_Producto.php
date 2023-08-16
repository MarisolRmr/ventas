<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra_Producto extends Model
{
    use HasFactory;
    protected $table = 'compra_producto';
    protected $fillable = [
        'cantidad',
        'compra_id',
        'producto_id',
        'proveedor_id',
        'precio_compra'
    ];
    public function compra()
    {
        return $this->belongsTo(Compra::class, 'compra_id');
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    public function proveedor()
    {
        return $this->belongsTo(Proveedores::class, 'proveedor_id');
    }
    
}
