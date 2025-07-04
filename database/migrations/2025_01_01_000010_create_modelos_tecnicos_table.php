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
        Schema::create('modelos_tecnicos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cliente_id'); // qual cliente pertece esse modelo
            $table->unsignedBigInteger('produto_id');
            $table->unsignedBigInteger('tecnologia_id');
            $table->unsignedBigInteger('tipo_entrega_id');

            $table->string('nome_modelo', 100)->nullable();
            $table->enum('posicionamento', ['horizontal', 'vertical'])->nullable();
            $table->boolean('tem_furo')->default(false);
            $table->boolean('tem_carga_foto')->default(false);
            $table->boolean('tem_dados_variaveis')->default(false);
            $table->boolean('ativo')->default(true);
            $table->enum('tipo_furo', ['ovoide', 'redondo'])->nullable();
            $table->string('campo_chave', 50)->nullable();
            $table->string('foto_frente_path', 255)->nullable();
            $table->string('foto_verso_path', 255)->nullable();
            $table->text('observacoes')->nullable();

            $table->timestamps();

            // 🔗 Relacionamentos
            $table->foreign('cliente_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
            $table->foreign('tecnologia_id')->references('id')->on('tecnologias')->onDelete('cascade');
            $table->foreign('tipo_entrega_id')->references('id')->on('tipos_entrega')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modelos_tecnicos');
    }
};
