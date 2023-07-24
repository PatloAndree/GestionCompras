<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentasDetalle extends Model
{
	use HasFactory;
	protected $table = 'venta_detalle';
	protected $fillable = [
		'id',
		'venta_id',
		'producto_id',
		'cantidad',
		'precio',
		'precio_total'
	];

}
