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
        Schema::create('expediente', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('numero', 45)->primary();
            $table->string('ofRequerimiento', 100);
            $table->date('fechaRequerimiento');
            $table->string('ofRespuesta', 100)->nullable();
            $table->date('fechaRespuesta')->nullable();
            $table->date('fechaRecepcion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expediente');
    }
};
