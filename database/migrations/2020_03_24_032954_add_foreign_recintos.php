<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignRecintos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recintos', function (Blueprint $table) {
            //
            $table->foreign('municipios_id')->references('id')->on('municipios');
            $table->foreign('distritos_id')->references('id')->on('distritos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recintos', function (Blueprint $table) {
            //
        });
    }
}
