<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('vendas_creditos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('user_id_executor');
            $table->unsignedBigInteger('produto_id');

            $table->decimal('valor', 10, 2);
            $table->decimal('quantidade_creditos', 10, 2);
            $table->enum('status', ['pendente', 'confirmado', 'cancelado'])->default('pendente');
            $table->timestamp('data_venda');
            $table->enum('tipo_transacao', ['entrada', 'saida'])->default("saida")->nullable();
            $table->text('observacao')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // 🔗 Relacionamentos
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id_executor')->references('id')->on('users')->onDelete('cascade'); // reponsável por realizar a transação dos creditos
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendas_creditos');
    }
};
