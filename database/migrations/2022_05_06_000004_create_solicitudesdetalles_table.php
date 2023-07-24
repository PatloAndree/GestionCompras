<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesDetallesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('productosdetalles', function (Blueprint $table) {
			$table->id();
			$table->integer('producto_id');
			$table->integer('cantidad');
			$table->date('fecha_vencimiento');
			$table->foreign('producto_id')->references('id')->on('productos');
		});
		/*CREATE TABLE IF NOT EXISTS `perumedi_administrador`.`productosdetalles` (
		`id` INT NOT NULL AUTO_INCREMENT,
		`producto_id` BIGINT(20) NOT NULL,
		`cantidad` INT NOT NULL COMMENT '1:COMPRA|2:MOVIMIENTO',
		`fecha_vencimiento` DATE NOT NULL,
		`created_at` TIMESTAMP NULL,
		`update_at` VARCHAR(45) NULL,
		PRIMARY KEY (`id`),
		INDEX `fk_productosdetalles_productos1_idx` (`producto_id` ASC) ,
		CONSTRAINT `fk_productosdetalles_productos1`
			FOREIGN KEY (`producto_id`)
			REFERENCES `perumedi_administrador`.`productos` (`id`)
			ON DELETE NO ACTION
			ON UPDATE NO ACTION)
		ENGINE = InnoDB*/
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('solicitudesdetalles');
	}
}
