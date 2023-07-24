<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignacionesdiariasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('asignacionesdiarias', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('usuario_id');
			$table->date('fecha_asignada');
			$table->unsignedBigInteger('sede_id');
			$table->timestamps();
			$table->integer('status')->default('1');
			$table->foreign('usuario_id')->references('id')->on('users');
			$table->foreign('sede_id')->references('id')->on('sedes');
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
