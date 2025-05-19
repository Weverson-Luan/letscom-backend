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
        Schema::create('entregas_cliente', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('remessa_id');
            $table->string('responsavel_recebimento');
            $table->string('imagem_protocolo')->nullable();
            $table->timestamp('data_entrega')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->timestamps();

            // Relacionamento
            $table->foreign('remessa_id')->references('id')->on('remessas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entregas_cliente');
    }
};
