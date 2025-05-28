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
        Schema::create('tipo_entrega_user', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cliente_id');// cliente que esse usuário vai atender
            $table->unsignedBigInteger('tipo_entrega_id');



            $table->timestamps();

            // 🔗 Relacionamentos
             $table->foreign('cliente_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tipo_entrega_id')->references('id')->on('tipos_entrega')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_entrega_user');
    }
};
