<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fechas_list extends Model
{
	use HasFactory;
	protected $table = 'horarios';
	protected $fillable = [
		'id',
		'entrada',
		'salida'
	];

	
}
