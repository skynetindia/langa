<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
			$table->integer('user_id')->index();
            $table->string('dipartimento');
			$table->string('ente');
            $table->integer('giorno');
			$table->integer('giornoFine');
            $table->integer('mese');
            $table->integer('anno');
            $table->string('sh');
            $table->string('eh');
            $table->string('titolo');
            $table->string('dettagli');
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
        Schema::drop('events');
    }
}
