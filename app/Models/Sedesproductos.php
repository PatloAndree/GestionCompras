<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sedesproductos extends Model
{
	use HasFactory;
	protected $table = 'sedesproductos';
	protected $fillable = [
		'sede_id',
		'producto_id',
		'cantidad',
		'fecha_vencimiento'
	];
}
