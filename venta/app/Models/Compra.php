<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;
    protected $table = 'compra';
    protected $fillable = [
        'referencia',
        'fecha',
        'total',
        'impuestos',
        'subtotal',
        'descripcion',
        'user_id',
    ];
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
