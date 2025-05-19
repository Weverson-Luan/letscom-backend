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
        Schema::create('enderecos_entrega', function (Blueprint $table) {
           $table->id();
            $table->unsignedBigInteger('user_id');

            $table->string('logradouro')->nullable();
            $table->string('numero');
            $table->string("complemento")->nullable();
            $table->string('bairro');
            $table->string('cidade');
            $table->string('estado');
            $table->string('cep');

            $table->string("nome_responsavel");
            $table->string("email");
            $table->string("setor");
            $table->string("telefone");

            $table->timestamps();

            // 🔗 Relacionamentos
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('endereco_entrega');
    }
};
