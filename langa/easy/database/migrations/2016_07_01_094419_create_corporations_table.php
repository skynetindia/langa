<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorporationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corporations', function (Blueprint $table) {
            $table->increments('id')->index();
			$table->integer('user_id')->index();
			$table->string('nomeazienda');
			$table->string('nomereferente');
			$table->string('settore');
			$table->string('piva');
			$table->string('cf');
			$table->string('telefonoazienda');
			$table->string('cellulareazienda');
			$table->string('emailsecondaria');
			$table->integer('fax');
			$table->string('email');
			$table->integer('privato');
			$table->string('indirizzo');
			$table->string('statoemotivo');
			$table->string('iban');
			$table->string('logo');
			$table->string('responsabilelanga');
			$table->integer('telefonoresponsabile');
			$table->string('noteenti');
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
        Schema::drop('corporations');
    }
}
