<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandingPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            
            $table->string("descricao", 200)->nullable();
            $table->string("endereco_completo", 300)->nullable();
            $table->string("texto_acompahe_a_obra", 200)->nullable();
            $table->decimal("percentual_acompahe_a_obra", 5, 2)->nullable()->default(0);
            $table->string("cor_fundo", 20)->default("#fff");
            $table->string("cor_texto", 20)->default("#000");

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
        Schema::dropIfExists('landing_pages');
    }
}
