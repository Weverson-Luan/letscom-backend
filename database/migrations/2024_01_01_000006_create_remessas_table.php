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

            $table->unsignedBigInteger('cliente_id'); // pessoa dona da remesa
            $table->unsignedBigInteger('user_id_solicitante_remessa')->nullable()->comment("Pessoa que solicitou a remessa"); // pessoa que solicitou a remessa
            $table->unsignedBigInteger('user_id_executor')->nullable()->comment("Pessoa que pegou a remessa"); // pessoa que pegou remessa

            $table->unsignedBigInteger('modelo_tecnico_id'); // modelo da remessa
            $table->unsignedBigInteger('tecnologia_id'); // tecnologia da remessa

            $table->integer('total_solicitacoes')->default(0);
            $table->enum('situacao', ['pendente', 'em_producao', 'pronto para imprimir', 'concluida', 'cancelada', 'error', 'duplicidade', 'a fazer', 'a aprovar','enviar pdf'])->default('pendente');
            $table->string("status")->default("pendente");
            $table->boolean('ativo')->default(true);
            $table->string("observacao")->nullable();

            $table->timestamp('data_remessa')->nullable();
            $table->timestamp('data_inicio_producao')->nullable();

            $table->enum('posicao', ['H', 'V'])->nullable();

            $table->timestamps();
            $table->softDeletes();

            // 🔗 Relacionamentos
            $table->foreign('cliente_id')->references('id')->on('users')->onDelete('cascade');// qual cliente pertece essa remessa
            $table->foreign('user_id_solicitante_remessa')->references('id')->on('users')->onDelete('cascade'); // quem que solicitou a remessa dentro do sistema
            $table->foreign('user_id_executor')->references('id')->on('users')->onDelete('cascade'); // reponsável por pegar a remessa para produzir
            $table->foreign('modelo_tecnico_id')->references('id')->on('modelos_tecnicos')->onDelete('cascade'); // modelo que o deve ser feito o crachá
            $table->foreign('tecnologia_id')->references('id')->on('tecnologias')->onDelete('cascade'); // tecnologias que tem o crachá
        });
    }

    public function down()
    {
        Schema::dropIfExists('remessas');
    }
};
