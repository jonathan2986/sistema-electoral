<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CoordinadorRecintos extends Migration
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
            $table->integer('coordinadores_id')->nullable()->after('id');
            $table->integer('coordinadores_ejecutivos_id')->nullable()->after('id');
            $table->integer('coordinadores_electorales_id')->nullable()->after('id');
            $table->integer('coordinadores_seguridad_id')->nullable()->after('id');
            $table->integer('coordinadores_finanzas_id')->nullable()->after('id');
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
            $table->dropColumn('coordinadores_id')->nullable()->after('id');
        });
    }
}
