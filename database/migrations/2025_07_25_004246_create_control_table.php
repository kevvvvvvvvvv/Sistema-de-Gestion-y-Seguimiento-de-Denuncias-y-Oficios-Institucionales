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
        Schema::create('control', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('consecutivo');
            $table->enum('acProrroga', ['Si', 'No']);     
            $table->enum('acAuxilio', ['Si', 'No']);         
            $table->enum('acRegularizacion', ['Si', 'No']);  
            $table->enum('acRequerimiento', ['Si', 'No']); 
            $table->enum('acOficioReque', ['Si', 'No']);  
            $table->enum('acInicio', ['Si', 'No']);
            $table->enum('acModificacion', ['Si', 'No']);
            $table->enum('acConclusion', ['Si', 'No']);
            $table->mediumText('comentarios')->nullable();
            $table->string('numero', 45);

            $table->foreign('numero')->references('numero')->on('expediente')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control');
    }
};
