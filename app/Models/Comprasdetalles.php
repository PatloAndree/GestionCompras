<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprasdetalles extends Model
{
	use HasFactory;
	protected $table = 'comprasdetalles';

	protected $fillable = [
		'compra_id',
		'producto_id',
		'producto_cantidad',
		'producto_preciocompra',
		'producto_fechavencimiento'
	];
}
