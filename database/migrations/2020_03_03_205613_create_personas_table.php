<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idcolegio_electoral')->unsigned();
            $table->string('nombre', 70);
            $table->string('apellido', 70);
            $table->string('cedula', 100)->unique();
            $table->string('direccion', 100);
            $table->string('telefono',50)->nullable();
            $table->boolean('voto')->default('0');

            $table->foreign('idcolegio_electoral')->references('id')->on('colegios_electorales');
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
        Schema::dropIfExists('personas');
    }
}
