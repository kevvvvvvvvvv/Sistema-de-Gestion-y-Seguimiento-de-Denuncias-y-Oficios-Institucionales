<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historial', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('idHistorial');
            $table->dateTime('fecha');
            $table->string('accion', 255);
            $table->unsignedBigInteger('idUsuario');

            $table->foreign('idUsuario')->references('idUsuario')->on('users')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE historial MODIFY idHistorial INT(8) ZEROFILL UNSIGNED NOT NULL AUTO_INCREMENT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial');
    }
};
