<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencias extends Model
{
	use HasFactory;
	protected $table = 'asistencias';
	protected $fillable = [
		'asignaciondiaria_id',
		'usuario_registra_id',
		'usuario_registrado_id',
		'fechaingreso',
		'horaingreso',
		'fechasalida',
		'horasalida',
		'factor',
		'status'
	];

	public function usuario()
	{
		return $this->belongsTo(User::class, 'usuario_registra_id', 'id');
	}

	public function empleado()
	{
		return $this->belongsTo(User::class, 'usuario_registrado_id', 'id');
	}

	public function asignacion()
	{
		return $this->belongsTo(Asignacionesdiarias::class, 'asignaciondiaria_id', 'id');
	}
}
