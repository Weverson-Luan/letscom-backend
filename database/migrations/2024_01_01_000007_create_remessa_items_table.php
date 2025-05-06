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

            $table->unsignedBigInteger('remessa_id');
            $table->unsignedBigInteger('product_id'); // Produto do item (ex: cartão Membro, Presbítero...)

            $table->integer('quantidade');
            $table->decimal('valor_creditos_unitario', 10, 2);
            $table->decimal('valor_creditos_total', 10, 2);

            $table->timestamps();

            $table->foreign('remessa_id')->references('id')->on('remessas')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('remessa_items');
    }
};
