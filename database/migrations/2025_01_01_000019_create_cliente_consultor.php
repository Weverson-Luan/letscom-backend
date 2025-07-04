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
        Schema::create('cliente_consultor', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cliente_id');   // usuario com papel "cliente"
            $table->unsignedBigInteger('consultor_id'); // usuario com papel "consultor"


            $table->timestamps();

            // 🔗 Relacionamentos
            $table->foreign('cliente_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('consultor_id')->references('id')->on('users')->onDelete('cascade');

            $table->unique(['cliente_id', 'consultor_id']); // evita duplicidade
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente_consultor');
    }
};
