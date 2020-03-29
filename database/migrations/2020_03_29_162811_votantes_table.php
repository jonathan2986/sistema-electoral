<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VotantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votantes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('people_id')->unsigned();
            $table->integer('circunscripciones_id')->unsigned();
            $table->integer('municipios_id')->unsigned();
            $table->integer('distritos_id')->unsigned();
            $table->integer('recintos_id')->unsigned();
            $table->integer('colegios_electorales_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('card_id')->unique();
            $table->foreign('people_id')->references('id')->on('people');
            $table->foreign('circunscripciones_id')->references('id')->on('circunscripciones');
            $table->foreign('municipios_id')->references('id')->on('municipios');
            $table->foreign('recintos_id')->references('id')->on('recintos');
            $table->foreign('colegios_electorales_id')->references('id')->on('colegios_electorales');
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
        Schema::dropIfExists('votantes');
    }
}
