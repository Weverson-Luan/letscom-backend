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
        Schema::create('users_atendimentos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');// cliente que esse usuário vai atender
            $table->string('nome')->nullable(); // nome do atendente
            $table->string('email')->unique(); // e-mail do atendente
            $table->string("telefone");
            $table->string('documento')->nullable()->unique(); // cpf ou cnpj
            $table->boolean('ativo')->default(true);

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
        Schema::dropIfExists('users_atendimentos');
    }
};
