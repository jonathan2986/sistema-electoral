<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColegiosElectoralesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colegios_electorales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idrecinto')->unsigned();
            $table->string('numero_colegio',50);
            $table->integer('cantidad_electores');
            $table->timestamps();

            $table->foreign('idrecinto')->references('id')->on('recinto_electoral');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colegios_electorales');
    }
}
