<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullDistritosIdVotantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('votantes', function (Blueprint $table) {
            //
            $table->integer('distritos_id')->unsigned()->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('votantes', function (Blueprint $table) {
            //
            $table->integer('distritos_id')->unsigned()->change();
        });
    }
}
