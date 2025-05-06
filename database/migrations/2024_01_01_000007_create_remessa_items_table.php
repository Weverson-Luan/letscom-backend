<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('remessa_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('remessa_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained();
            $table->integer('quantidade');
            $table->decimal('valor_creditos_unitario', 10, 2);
            $table->decimal('valor_creditos_total', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('remessa_items');
    }
}; 