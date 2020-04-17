<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CoordinadoresIdDistritos extends Migration
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
            $table->integer('coordinadores_id')->nullable()->after('id');
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
            $table->dropColumn('coordinadores_id');
        });
    }
}
