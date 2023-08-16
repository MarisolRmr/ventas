<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion_Producto extends Model
{
    use HasFactory;
    protected $table = 'cotizacion_producto';
    protected $fillable = [
        'cantidad',
        'cotizacion_id',
        'producto_id',
    ];
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id');
    }
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
