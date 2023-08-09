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
        Schema::table('users', function (Blueprint $table) {
            $table->string('apellido')->nullable();
            $table->string('telefono')->nullable();
            $table->string('imagen')->nullable();
            $table->string('rol')->nullable();
            $table->string('status')->nullable();
            $table->string('eliminado')->nullable();
            $table->string('name')->nullable()->change();
            $table->string('password')->nullable()->change();
            $table->string('email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('apellido');
            $table->dropColumn('telefono');
            $table->dropColumn('imagen');
            $table->dropColumn('rol');
            $table->dropColumn('status');
            $table->dropColumn('eliminado');
            $table->string('name')->change();
            $table->string('password')->change();
            $table->string('email')->change();

        });
    }
};
