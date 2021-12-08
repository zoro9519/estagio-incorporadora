<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProprietariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proprietarios', function (Blueprint $table) {
            $table->id();

            $table->string("nome", 100);
            $table->string("documento", 18);
            $table->string("email", 200);
            $table->string("phone", 18);
            
            $table->dateTime("data_inicio");
            $table->dateTime("data_fim")->nullable();

            // Endereco
            $table->string("logradouro", 100)->nullable();
            $table->string("numero", 10)->nullable();
            $table->string("complemento", 100)->default("");
            $table->string("bairro", 100)->nullable();
            $table->string("cidade", 100)->nullable();
            $table->string("uf", 2)->nullable();
            $table->string("cep", 10)->nullable();

            $table->foreignId("lote_id")->index();

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
        Schema::dropIfExists('proprietarios');
    }
}
