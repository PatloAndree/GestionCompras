<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Documents extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('documents', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('short_name');
			$table->integer('min_val');
			$table->integer('max_val');
			$table->integer('alphanumeric')->default("1");
			$table->timestamps();
			$table->integer('status')->default("1");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}
}
