<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignDistritos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distritos', function (Blueprint $table) {
            //
            $table->foreign('circunscripciones_id')->references('id')->on('circunscripciones');
            $table->foreign('municipios_id')->references('id')->on('municipios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distritos', function (Blueprint $table) {
            //
        });
    }
}
