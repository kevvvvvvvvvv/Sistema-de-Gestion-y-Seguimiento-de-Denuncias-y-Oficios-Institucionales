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
        Schema::create('backups', function (Blueprint $table) {
            $table->id();

            // --- ESTA ES LA PARTE IMPORTANTE ---
            // 1. Crea la columna para la clave foránea
            $table->unsignedBigInteger('user_id'); 
            // ------------------------------------

            $table->string('file_name');
            $table->string('path');
            $table->string('status')->default('pending');
            $table->timestamps();

            // --- Y ESTA ES LA DEFINICIÓN DE LA REGLA ---
            // 2. Define la restricción (foreign key)
            $table->foreign('user_id')
                  ->references('idUsuario') // La columna en la tabla 'users'
                  ->on('users')             // La tabla 'users'
                  ->onDelete('cascade');
            // ---------------------------------------------
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backups');
    }
};
