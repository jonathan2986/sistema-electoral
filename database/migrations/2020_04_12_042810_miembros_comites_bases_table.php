<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MiembrosComitesBasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('miembros_comites_bases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('votantes_id')->unsigned()->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('card_id');
            $table->text('address');
            $table->text('comite_base');
            $table->text('number_member');
            $table->softDeletes();
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
        Schema::dropIfExists('miembros_comites_bases');
    }
}
