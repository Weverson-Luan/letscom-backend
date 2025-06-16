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

            $table->enum('tipo', ['balcao', 'correios', 'motoboy_letscom', 'transportadora', 'entregue_pela_letscom', 'outros'])->default('motoboy_letscom')->nullable(); // Ex: 'Balcão', 'Correios', 'Motoboy LetScom', 'Outro' (opcional)
            $table->boolean('ativo')->default(true);

            $table->timestamps();
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
