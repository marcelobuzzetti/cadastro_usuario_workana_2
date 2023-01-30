<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cadastro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cadastros', function (Blueprint $table) {
            $table->id();
            $table->string('nome_completo');
            $table->string('email');
            $table->string('telefone');
            $table->string('nome_corretora')->nullable();
            $table->string('nr_conta_corretora')->nullable();
            $table->string('mercado');
            $table->boolean('has_corretora');
            $table->boolean('has_auth_use_metatrader');
            $table->bigInteger('zenitelic_id')->nullable();
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
        Schema::dropIfExists('cadastros');
    }
}
