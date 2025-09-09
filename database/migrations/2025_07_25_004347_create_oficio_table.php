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
            $table->unsignedBigInteger('idRemitente');
            $table->unsignedBigInteger('idDestinatario');

            $table->foreign('idRemitente')->references('idServidor')->on('servidor')->onDelete('cascade');
            $table->foreign('idDestinatario')->references('idDestinatario')->on('destinatario')->onDelete('cascade');
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
