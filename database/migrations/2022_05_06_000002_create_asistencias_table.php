<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsistenciasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('asistencias', function (Blueprint $table) {
			$table->id();
			$table->integer('usuario_registra_id');
			$table->integer('usuario_registrado_id');
			$table->date('fechaingreso');
			$table->time('horaingreso');
			$table->date('fechasalida');
			$table->time('horasalida');
			$table->timestamps();
			$table->integer('status')->default('2'); // 2 pendiente || 1 culminada
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
