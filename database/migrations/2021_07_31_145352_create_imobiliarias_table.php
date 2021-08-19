<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImobiliariasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imobiliarias', function (Blueprint $table) {
            $table->id();

            $table->string("nome", 50);
            $table->string("razao_social", 200);
            $table->string("cnpj", 18);
            $table->string("creci", 18);
            $table->string("email", 100);
            $table->boolean("status");

            // Endereco
            $table->string("logradouro", 100);
            $table->string("numero", 10);
            $table->string("complemento", 100)->default("");
            $table->string("bairro", 100);
            $table->string("cidade", 100);
            $table->string("cep", 10);
            $table->string("uf", 2);

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
        Schema::dropIfExists('imobiliarias');
    }
}
