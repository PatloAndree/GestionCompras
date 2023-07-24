<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSedesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sedes', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->integer('pais_id');
			$table->integer('departamento_id');
			$table->integer('provincia_id');
			$table->integer('distrito_id');
			$table->text('direccion');
			$table->timestamps();
			$table->integer('status')->default('1');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('sedes');
	}
}
