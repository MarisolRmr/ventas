<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $table = 'marca';
    protected $fillable = [
        'nombre',
        'imagen',
        'descripcion',
        'activo',
        'user_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
