<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idcandidato')->unsigned();
            $table->foreign('idcandidato')->references('id')->on('candidatos');
            $table->integer('idpartido')->unsigned();
            $table->foreign('idpartido')->references('id')->on('partidos');
            $table->integer('voto_candidato')->nullable();
            $table->integer('voto_nulo')->nullable();
            $table->integer('votos_valido')->nullable();
            $table->integer('boletas_observada')->nullable();
            $table->integer('total_voto')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votos');
    }
}
