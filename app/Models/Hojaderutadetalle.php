<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hojaderutadetalle extends Model
{
	use HasFactory;
	protected $table = 'hojaderutadetalle';
	protected $fillable = [
		'id',
		'id_hoja',
		'direccion',
		'departamento',
		'provincia',
		'distrito',
		'hora_llegada',
		'kilometraje',
		'hora_salida'
	];

	// public function usuario()
	// {
	// 	return $this->belongsTo(User::class, 'usuario_registra_id', 'id');
	// }

	// public function empleado()
	// {
	// 	return $this->belongsTo(User::class, 'usuario_registrado_id', 'id');
	// }

	// public function horarios()
	// {
	// 	// return $this->belongsTo(Sedes::class);
	// 	return $this->belongsTo(User::class, 'id_hoja' , 'id'); //users
		
	// }
}
