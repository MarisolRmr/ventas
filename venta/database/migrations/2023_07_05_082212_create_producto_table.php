<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre');
            $table->double('precio_venta');
            $table->double('precio_compra');
            $table->integer('unidades');
            //agregamos la relacion a categorias, subcategoria, usuario y marca
            $table->foreignId('categoria_id')->constrained('categoria');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('marca_id')->constrained('marca')->onDelete('cascade');
            $table->foreignId('subcategoria_id')->constrained('subcategoria');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};
