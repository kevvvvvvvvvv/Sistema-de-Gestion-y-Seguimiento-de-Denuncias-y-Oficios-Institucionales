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
        Schema::create('destinatario', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('idDestinatario');
            $table->enum('tipo', ['Servidor', 'Departamento']);
            $table->unsignedBigInteger('idServidor')->nullable();
            $table->unsignedBigInteger('idDepartamento')->nullable();

            $table->foreign('idServidor')->references('idServidor')->on('servidor')->onDelete('set null');
            $table->foreign('idDepartamento')->references('idDepartamento')->on('departamento')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinatario');
    }
};
