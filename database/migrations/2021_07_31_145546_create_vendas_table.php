<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();

            $table->decimal("valor");
            $table->string("forma_pagamento");
            $table->integer("nro_parcelas")->default(1);
            $table->foreignId("user_id")->index();
            $table->foreignId("corretor_id")->index();
            $table->foreignId("lote_id")->index();
            $table->foreignId("admin_id")->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendas');
    }
}
