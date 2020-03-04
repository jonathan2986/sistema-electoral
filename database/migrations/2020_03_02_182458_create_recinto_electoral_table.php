<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecintoElectoralTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recinto_electoral', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idcolegio')->unsigned();
            $table->string('nombre_recinto',100);
            $table->string('direccion',100);
            $table->timestamps();

            $table->foreign('idcolegio')->references('id')->on('colegios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recinto_electoral');
    }
}
