<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta_Producto extends Model
{
    use HasFactory;
    protected $table = 'venta_producto';
    protected $fillable = [
        'cantidad',
        'venta_id',
        'producto_id',
    ];
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'venta_id');
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
