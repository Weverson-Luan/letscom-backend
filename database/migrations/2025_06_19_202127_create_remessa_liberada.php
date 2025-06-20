<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('remessa_liberada', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('remessa_id');
            $table->unsignedBigInteger('user_id_executor'); // quem liberou a remessa
            $table->unsignedBigInteger('tipo_entrega_id'); // tipo de entrega para o pedido

            $table->timestamp('data_entrega')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string("observacao")->nullable();

            $table->timestamps();

            // relacionamento
            $table->foreign('remessa_id')->references('id')->on('remessas')->onDelete('cascade');
            $table->foreign('user_id_executor')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tipo_entrega_id')->references('id')->on('tipos_entrega')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remessa_liberada');
    }
};
