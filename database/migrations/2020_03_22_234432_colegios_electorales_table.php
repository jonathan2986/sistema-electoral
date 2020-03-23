<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ColegiosElectoralesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colegios_electorales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('recintos_id')->unsigned();
            $table->string('name');
            $table->string('code')->unique();
            $table->foreign('recintos_id')->references('id')->on('recintos');
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colegios_electorales');
    }
}
