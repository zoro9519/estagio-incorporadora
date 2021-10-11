<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();

            $table->dateTime("data_inicio");
            $table->dateTime("data_fim");
            $table->string("observacao", 200)->default("");
            $table->enum("status", [ 'A', 'C', 'E', 'N', 'R' ]); // A - Agendado, C - Cancelado, E - Esperando aprovação admin, N - Negado pelo admin, R - Realizado
            $table->enum("type", [ 'V', 'R']); // V - Visita, R - Reserva

            $table->foreignId("user_id")->index();
            $table->foreignId("corretor_id")->index()->nullable();
            $table->foreignId("lote_id")->index()->nullable();
            $table->foreignId("loteamento_id")->index();

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
        Schema::dropIfExists('agendamentos');
    }
}
