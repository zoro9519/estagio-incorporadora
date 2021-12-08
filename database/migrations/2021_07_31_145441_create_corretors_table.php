<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorretorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corretors', function (Blueprint $table) {
            $table->id();

            $table->string("nome", 100);
            $table->string("cpf", 18);
            $table->string("phone", 18);
            $table->string("email");
            $table->decimal("taxa_venda_porcentagem");
            $table->decimal("taxa_venda_valor", 11, 2);
            $table->boolean("ativo");
            $table->string("profile_picture")->nullable();

            $table->foreignId("imobiliaria_id")->index()->nullable();

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
        Schema::dropIfExists('corretors');
    }
}
