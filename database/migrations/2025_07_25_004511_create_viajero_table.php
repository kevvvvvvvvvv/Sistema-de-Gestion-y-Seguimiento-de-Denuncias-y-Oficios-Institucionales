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
        Schema::create('viajero', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('folio');
            $table->mediumText('asunto');
            $table->mediumText('instruccion')->nullable();
            $table->mediumText('resultado')->nullable();
            $table->date('fechaEntrega')->nullable();
            $table->string('status', 45);
            $table->string('numOficio', 100);
            $table->unsignedBigInteger('idUsuario')->nullable();

            $table->foreign('numOficio')->references('numOficio')->on('oficio')->onDelete('cascade');
            $table->foreign('idUsuario')->references('idUsuario')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('viajero');
    }
};
