<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('remessa_fotos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('remessa_id');
            $table->unsignedBigInteger('user_id');

            $table->string('file_path'); // Caminho relativo (ex: remessas/fotos/9/1234.jpg)

            $table->timestamps();

            // 🔗 Relacionamentos
            $table->foreign('remessa_id')->references('id')->on('remessas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('remessa_fotos');
    }
};
