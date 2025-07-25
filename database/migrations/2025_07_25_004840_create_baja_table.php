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
        Schema::create('baja', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('idBaja');
            $table->string('puestoAnt', 45);
            $table->string('nivelAnt', 45);
            $table->string('adscripcionAnt', 45);
            $table->date('fechaBaja');
            $table->string('descripcion', 45);
            $table->string('numero', 45)->nullable();
            $table->unsignedBigInteger('idServidor');

            $table->foreign('numero')->references('numero')->on('expediente')->onDelete('set null');
            $table->foreign('idServidor')->references('idServidor')->on('servidor')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baja');
    }
};
