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
        Schema::create('oficio', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('numOficio', 100)->primary();
            $table->date('fechaLlegada');
            $table->date('fechaCreacion');
            $table->string('url', 100);

            // Remitente
            $table->unsignedBigInteger('idServidorRemitente')->nullable();
            $table->unsignedBigInteger('idParticularRemitente')->nullable();
            $table->unsignedBigInteger('idDepartamentoRemitente')->nullable();

            // Destinatarios
            $table->unsignedBigInteger('idServidorDestinatario')->nullable();
            $table->unsignedBigInteger('idParticularDestinatario')->nullable();
            $table->unsignedBigInteger('idDepartamentoDestinatario')->nullable();

            $table->foreign('idServidorRemitente')->references('idServidor')->on('servidor')->onDelete('cascade');
            $table->foreign('idParticularRemitente')->references('idParticular')->on('particular')->onDelete('cascade');
            $table->foreign('idDepartamentoRemitente')->references('idDepartamento')->on('departamento')->onDelete('cascade');

            $table->foreign('idServidorDestinatario')->references('idServidor')->on('servidor')->onDelete('cascade');
            $table->foreign('idParticularDestinatario')->references('idParticular')->on('particular')->onDelete('cascade');
            $table->foreign('idDepartamentoDestinatario')->references('idDepartamento')->on('departamento')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oficio');
    }
};
