<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nome');

            $table->string('phone', 18);
            $table->string('cpf', 15);
            $table->boolean('status');

            // Endereco
            $table->string("logradouro", 100);
            $table->string("numero", 10);
            $table->string("complemento", 100)->default("");
            $table->string("bairro", 100);
            $table->string("cidade", 100);
            $table->string("uf", 2);
            $table->string("cep", 10);

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
