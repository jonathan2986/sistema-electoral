<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropForeignPeople extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('people', function (Blueprint $table) {
            //
            $table->dropForeign(['provincias_id']);
            $table->dropForeign(['municipios_id']);
            $table->dropForeign(['circunscripciones_id']);
            $table->dropForeign(['recintos_id']);

            $table->dropColumn('provincias_id');
            $table->dropColumn('municipios_id');
            $table->dropColumn('distritos_id');
            $table->dropColumn('circunscripciones_id');
            $table->dropColumn('recintos_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('people', function (Blueprint $table) {
            //
        });
    }
}
