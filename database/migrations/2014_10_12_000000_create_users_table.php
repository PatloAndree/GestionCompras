<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('document_id');
			$table->string('name');
			$table->string('last_name');
			$table->string('number_document');
			$table->date('date_of_birth');
			$table->integer('sex');
			$table->text('address');
			$table->integer('phone');
			$table->string('email')->unique();
			$table->integer('type');
			$table->decimal('factor', $precision = 8, $scale = 2);
			$table->integer('sw_factor_variant')->default('0');
			$table->decimal('factor_variant', $precision = 8, $scale = 2);
			$table->timestamp('email_verified_at')->nullable();
			$table->string('password');
			$table->rememberToken();
			$table->timestamps();
			$table->integer('status')->default('1');
			$table->foreign('document_id')->references('id')->on('documents');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}
}
