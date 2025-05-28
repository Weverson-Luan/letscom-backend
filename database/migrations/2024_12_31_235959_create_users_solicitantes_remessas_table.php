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
        Schema::create('users_solicitantes_remessas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('remessa_id');
            $table->unsignedBigInteger('cliente_id'); // qual cliente os usuários solicitantes pertece


            $table->string('nome');
            $table->string('documento'); // formato 000.000.000-00 ou apenas números
            $table->string('telefone', 20); // com DDD


            $table->timestamps();

             // 🔗 Relacionamentos
             $table->foreign('remessa_id')->references('id')->on('remessas')->onDelete('cascade');
             $table->foreign('cliente_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_solicitantes_remessas');
    }
};
