<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'producto';
    protected $fillable = [
        'nombre',
        'precio_venta',
        'precio_compra',
        'unidades',
        'imagen',
        'categoria_id',
        'subcategoria_id',
        'marca_id',
        'user_id',
    ];
    //conexiones a tablas de usuario, marca y categoria
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function marca()
    {
        return $this->belongsTo(Marca::class, 'marca_id');
    }
    public function categoria()
    {
        return $this->belongsTo(categoria::class, 'categoria_id');
    }

}
