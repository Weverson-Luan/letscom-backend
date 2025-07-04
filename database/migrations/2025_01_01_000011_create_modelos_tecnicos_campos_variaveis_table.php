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
        Schema::create('modelos_tecnicos_campos_variaveis', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('modelo_tecnico_id');
            $table->string('nome', 100);
            $table->boolean('obrigatorio')->default(false);
            $table->integer("ordem")->default(0); // sempre inicia possição [0,1,2,3,4]

            $table->timestamps();

            // fazendo referencia com o modelo id
            $table->foreign('modelo_tecnico_id')
                ->references('id')
                ->on('modelos_tecnicos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modelos_tecnicos_campos_variaveis');
    }
};
