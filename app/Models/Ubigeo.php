<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubigeo extends Model
{
	use HasFactory;
	protected $table = 'ubigeo';
	protected $fillable = [
		'name',
		'nombre_ubigeo',
		'codigo_ubigeo',
		'etiqueta_ubigeo',
		'buscador_ubigeo',
		'numero_hijos_ubigeo',
		'nivel_ubigeo',
		'id_padre_ubigeo'
	];
}
