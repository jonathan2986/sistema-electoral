<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ActivistasPeople extends Migration
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
            $table->integer('activistas1_id')->nullable()->after('distritos_id');
            $table->integer('activistas2_id')->nullable()->after('distritos_id');
            $table->integer('activistas3_id')->nullable()->after('distritos_id');
            $table->integer('activistas4_id')->nullable()->after('distritos_id');
            $table->integer('activistas5_id')->nullable()->after('distritos_id');
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
            $table->integer('activistas_id')->nullable()->after('distritos_id');
        });
    }
}
