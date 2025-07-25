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
        Schema::create('departamento', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->bigIncrements('idDepartamento');
                $table->string('nombre', 100);
                $table->unsignedBigInteger('idInstitucion');

                $table->foreign('idInstitucion')->references('idInstitucion')->on('institucion')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departamento');
    }
};
