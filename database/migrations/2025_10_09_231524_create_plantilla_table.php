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
        Schema::create('plantilla', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('idPlantilla');
            $table->string('titulo', 45);
            $table->longText('contenido');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantilla');
    }
};
