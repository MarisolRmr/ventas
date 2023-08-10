<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devoluciones extends Model
{
    use HasFactory;
    protected $table = 'devoluciones';
    protected $fillable = [
        'nombreProducto',
        'fecha',
        'cliente',
        'status',
        'total',
        'pagado',
        'deuda',
        'statusPago',
        'user_id',
        'imagen',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
