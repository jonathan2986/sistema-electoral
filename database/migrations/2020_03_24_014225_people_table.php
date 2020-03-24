<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('provincias_id')->unsigned();
            $table->integer('municipios_id')->unsigned();
            $table->integer('distritos_id')->unsigned();
            $table->integer('circunscripciones_id')->unsigned();
            $table->integer('recintos_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('card_id');
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->date('date_birthdate');
            $table->string('profession')->nullable();
            $table->string('colegio_electoral');
            $table->foreign('provincias_id')->references('id')->on('provincias');
            $table->foreign('municipios_id')->references('id')->on('municipios');
            $table->foreign('circunscripciones_id')->references('id')->on('circunscripciones');
            $table->foreign('recintos_id')->references('id')->on('recintos');
            $table->softDeletes();
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
        Schema::dropIfExists('people');
    }
}
