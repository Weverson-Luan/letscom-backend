<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->string('nome');
            $table->string('tecnologia');
            $table->decimal('valor', 10, 2);
            $table->decimal('valor_creditos', 10, 2);
            $table->integer('estoque_minimo');
            $table->integer('estoque_maximo');
            $table->integer('estoque_atual');
            $table->boolean('ativo')->default(true);

            $table->timestamps();
            $table->softDeletes();


            // 🔗 Relacionamentos
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('produtos');
    }
};
