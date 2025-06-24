<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanilhaItensTable extends Migration
{
    public function up()
    {
        Schema::create('planilha_itens', function (Blueprint $table) {
            $table->id();
            $table->string('nome_sistema')->nullable();
            $table->string('ip')->nullable();
            $table->string('ambiente')->nullable();
            $table->string('url')->nullable();
            $table->string('tipo_os')->nullable();
            $table->string('usuario_os')->nullable();
            $table->string('senha_os')->nullable();
            $table->string('usuario_site')->nullable();
            $table->string('senha_site')->nullable();
            $table->string('database')->nullable();
            $table->string('usuario_db')->nullable();
            $table->string('senha_db')->nullable();
            $table->string('caminho')->nullable();
            $table->string('git')->nullable();
            $table->string('empresa_desenvolvdor')->nullable();
            $table->string('responsavel_diretor')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('planilha_itens');
    }
}
