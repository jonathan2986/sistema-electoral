<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableRecintos extends Migration
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
            $table->integer('activistas_id')->nullable()->after('distritos_id');
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
            $table->dropColumn('activistas_id');
        });
    }
}
