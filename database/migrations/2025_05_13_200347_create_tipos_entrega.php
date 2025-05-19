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
        Schema::create('tipos_entrega', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id'); // usuário que criou o tipo de entrega
            $table->unsignedBigInteger('cliente_id'); // qual cliente pertece esse tipo de entrega
            $table->unsignedBigInteger('endereco_entrega_id')->nullable();

            $table->enum('tipo', ['balcao', 'correios', 'motoboy_letscom', 'transportadora', 'outros'])->default('motoboy_letscom')->nullable(); // Ex: 'Balcão', 'Correios', 'Motoboy LetScom', 'Outro' (opcional)

            $table->timestamps();

            // 🔗 Relacionamentos
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('users')->onDelete('cascade');
           $table->foreign('endereco_entrega_id')->references('id')->on('enderecos')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_entrega');
    }
};
