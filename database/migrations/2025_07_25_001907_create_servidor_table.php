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
        Schema::create('servidor', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('idServidor');
            $table->string('nombreCompleto', 100);
            $table->enum('genero', ['Femenino', 'Masculino']);
            $table->string('grado', 45);
            $table->date('fechaIngreso')->nullable();
            $table->string('puesto', 100);
            $table->string('nivel', 45);
            $table->string('correo', 100)->nullable();
            $table->string('telefono', 45)->nullable();
            $table->enum('estatus', ['Alta', 'Baja']);
            $table->mediumText('descripcion')->nullable();
            $table->unsignedBigInteger('idInstitucion');
            $table->unsignedBigInteger('idDepartamento');

            $table->foreign('idInstitucion')->references('idInstitucion')->on('institucion')->onDelete('cascade');
            $table->foreign('idDepartamento')->references('idDepartamento')->on('departamento')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servidor');
    }
};
