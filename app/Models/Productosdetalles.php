<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productosdetalles extends Model
{
	use HasFactory;
	protected $table = 'productosdetalles';

	protected $fillable = [
		'producto_id',
		'cantidad',
		'fecha_vencimiento',
		'status'
	];

}
