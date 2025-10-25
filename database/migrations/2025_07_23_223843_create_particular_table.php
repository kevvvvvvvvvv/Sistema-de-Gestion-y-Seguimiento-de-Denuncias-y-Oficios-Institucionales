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
        Schema::create('particular', function (Blueprint $table) {
            $table->bigIncrements('idParticular');
            $table->string('nombreCompleto', 100);
            $table->enum('genero', ['Femenino', 'Masculino']);
            $table->string('grado', 45);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('particular');
    }
};
