<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspecificacoesImovelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('especificacoes_imoveis', function (Blueprint $table) {
            $table->id();
            $table->string("endereco");
            $table->integer("quantidade_quartos");
            $table->float("preco_diaria", 8, 2);
            $table->unsignedBigInteger("imovel_id");
            $table->timestamps();

            // Relacionamento
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
        Schema::dropIfExists('especificacoes_imovels');
    }
}
