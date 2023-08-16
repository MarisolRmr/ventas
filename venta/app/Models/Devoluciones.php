<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devoluciones extends Model
{
    use HasFactory;
    protected $table = 'devoluciones';
    protected $fillable = [
        'user_id',
        'venta_id',
        'producto_id',
        'cantidad_devuelta',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
