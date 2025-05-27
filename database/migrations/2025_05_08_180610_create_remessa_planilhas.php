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
        Schema::create('remessa_planilhas', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('remessa_id');
            $table->unsignedBigInteger('cliente_id');

            $table->string('file_path'); // Ex: remessas/planilhas/9/exportacao_abril.xlsx
            $table->string('tipo')->nullable(); // Ex: 'exportacao', 'relatorio', 'resumo' (opcional)

            $table->timestamps();

            // 🔗 Relacionamentos
            $table->foreign('remessa_id')->references('id')->on('remessas')->onDelete('cascade');
            $table->foreign('cliente_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remessa_planilhas');
    }
};
