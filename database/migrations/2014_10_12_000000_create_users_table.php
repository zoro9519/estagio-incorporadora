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

            $table->string('cpf', 15)->nullable();
            $table->string('phone', 18)->nullable();
            $table->enum('status', [ 'A', 'V', 'E', 'D']);
            $table->boolean('is_new')->default(true);

            // Endereco
            $table->string("logradouro", 100)->nullable();
            $table->string("numero", 10)->nullable();
            $table->string("complemento", 100)->default("");
            $table->string("bairro", 100)->nullable();
            $table->string("cidade", 100)->nullable();
            $table->string("uf", 2)->nullable();
            $table->string("cep", 10)->nullable();

            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
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
