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
        Schema::create('users_cliente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cliente_id');
            $table->string('email')->unique();
            $table->string('nome')->nullable();
            $table->string("senha");
            $table->string('documento')->nullable()->unique(); // cpf ou cnpj
            $table->boolean('ativo')->default(true);

            $table->timestamps();

            // 🔗 Relacionamentos
            $table->foreign('cliente_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_cliente');
    }
};
