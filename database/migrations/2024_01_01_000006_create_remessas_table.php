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

    $table->unsignedBigInteger('cliente_id');
    $table->unsignedBigInteger('user_id');
    $table->unsignedBigInteger('modelo_tecnico_id');

    $table->integer('total_solicitacoes')->default(0);
    $table->enum('status', ['pendente', 'em_producao', 'concluida', 'cancelada'])->default('pendente');

    $table->timestamp('data_remessa')->nullable();
    $table->timestamp('data_inicio_producao')->nullable();

    $table->string('tecnologia', 100)->nullable(); // Ex: "Nenhuma Tecnologia"
    $table->enum('posicao', ['H', 'V'])->nullable();

    $table->timestamps();
    $table->softDeletes();

    $table->foreign('cliente_id')->references('id')->on('clients')->onDelete('cascade');
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('modelo_tecnico_id')->references('id')->on('modelos_tecnicos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('remessas');
    }
};
