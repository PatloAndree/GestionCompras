<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comprobantes extends Model
{
	use HasFactory;
	protected $table = 'comprobantes';

	protected $fillable = [
		'id',
		'nombre_comp',
		'unidad_categoria',
		'status'
	];
}
