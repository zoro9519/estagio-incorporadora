<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();

            $table->string("descricao", 100);
            $table->decimal("area");
            $table->decimal("valor", 20, 2)->default(0);
            $table->enum("status", [ 'R', 'L', 'V', 'C' ])->default('L'); // R - Reservado, L - Livre, V - Vendido, C - Cancelado

            $table->foreignId("quadra_id")->index();

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
        Schema::dropIfExists('lotes');
    }
}
