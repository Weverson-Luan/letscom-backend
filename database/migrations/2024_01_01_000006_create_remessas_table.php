<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('remessas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id'); // pessoa dona da remesa
            $table->unsignedBigInteger('user_id_solicitante_remessa')->nullable()->comment("Pessoa que solicitou a remessa"); // pessoa que solicitou a remessa
            $table->unsignedBigInteger('user_id_executor')->nullable()->comment("Pessoa que pegou a remessa"); // pessoa que pegou remessa

            $table->unsignedBigInteger('modelo_tecnico_id'); // modelo da remessa
            $table->unsignedBigInteger('tecnologia_id'); // tecnologia da remessa

            $table->integer('total_solicitacoes')->default(0);
            $table->enum('situacao', ['pendente', 'em_producao', 'pronto para imprimir', 'concluida', 'cancelada'])->default('pendente');
            $table->string("status")->default("pendente");
            $table->boolean('ativo')->default(true);
            $table->string("observacao")->nullable();

            $table->timestamp('data_remessa')->nullable();
            $table->timestamp('data_inicio_producao')->nullable();

            $table->enum('posicao', ['H', 'V'])->nullable();

            $table->timestamps();
            $table->softDeletes();

            // 🔗 Relacionamentos
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id_solicitante_remessa')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id_executor')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('modelo_tecnico_id')->references('id')->on('modelos_tecnicos')->onDelete('cascade');
            $table->foreign('tecnologia_id')->references('id')->on('tecnologias')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('remessas');
    }
};
