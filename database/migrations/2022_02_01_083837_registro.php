<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Registro extends Migration
{
    public function up()
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->id('ID_usuario');
            $table->string('CPF', 16);
            $table->string('Nome', 50);
            $table->string('Login', 12);
            $table->dateTime('Data_Inicial');
            $table->dateTime('Data_limite');
            $table->dateTime('Data_ult_ent');
            $table->integer('Contador');
            $table->string('Origem_registro', 10);
            $table->string('Cod_Admin', 33);
            $table->string('Email', 100);
            $table->string('Telefone', 30);
            $table->string('IP', 15);
            $table->integer('usuario');
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
        Schema::dropIfExists('registros');
    }

}
