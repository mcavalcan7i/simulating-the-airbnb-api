<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocacaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("cliente_id");
            $table->date("data_inicio_locacao");
            $table->date("data_saida_previsao");
            $table->date("data_saida_locacao");
            $table->unsignedBigInteger("imovel_id");
            $table->timestamps();

            // Relacionamentos
            $table->foreign("cliente_id")->references("id")->on("users");
            $table->foreign("imovel_id")->references("id")->on("imoveis");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locacaos');
    }
}
