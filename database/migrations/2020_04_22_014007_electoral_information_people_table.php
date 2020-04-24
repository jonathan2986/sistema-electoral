<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ElectoralInformationPeopleTable extends Migration
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
            $table->integer('colegios_electorales_id')->nullable()->after('id');
            $table->integer('recintos_id')->nullable()->after('id');
            $table->integer('distritos_id')->nullable()->after('id');
            $table->integer('circunscripciones_id')->nullable()->after('id');
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
            $table->dropColumn('recintos_id');
            $table->dropColumn('distritos_id');
            $table->dropColumn('circunscripciones_id');
            $table->dropColumn('colegios_electorales_id');
        });
    }
}
