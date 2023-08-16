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
        Schema::create('cotizacion', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('referencia');
            $table->text('descripcion');
            $table->date('fecha');
            $table->double('total');
            $table->double('subtotal');
            $table->double('impuestos');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('cliente_id')->constrained('cliente');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotizacion');
    }
};
