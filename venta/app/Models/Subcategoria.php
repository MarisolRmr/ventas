<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategoria extends Model
{
    use HasFactory;
    protected $table = 'subcategoria';
    protected $fillable = [
        'imagen',
        'nombre',
        'categoria_id',
        'codigo',
        'descripcion',
        'user_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
