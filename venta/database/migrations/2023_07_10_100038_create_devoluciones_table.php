<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
        Schema::create('devoluciones', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombreProducto');
            $table->string('fecha');
            $table->text('cliente');
            $table->text('status');
            $table->text('total');
            $table->text('pagado');
            $table->text('deuda');
            $table->text('statusPago');
            $table->foreignId('user_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devoluciones');
    }
};
