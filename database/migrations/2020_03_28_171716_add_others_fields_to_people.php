<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOthersFieldsToPeople extends Migration
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
            $table->string('celphone')->nullable()->after('phone_number');
            $table->string('address')->nullable()->after('phone_number');
            $table->string('sector')->nullable()->after('phone_number');
            $table->string('sexo')->nullable()->after('phone_number');
            $table->text('redes')->nullable()->after('phone_number');
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
            $table->dropColumn('address');
            $table->dropColumn('sector');
            $table->dropColumn('sexo');
            $table->dropColumn('redes');
        });
    }
}
