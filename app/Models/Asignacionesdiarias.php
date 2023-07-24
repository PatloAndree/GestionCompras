<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignacionesdiarias extends Model
{
	use HasFactory;
	protected $table = 'asignacionesdiarias';
	protected $fillable = [
		'usuario_id',
		'fecha_asignada',
		'sede_id',
		'horario_id',
		'status',
		'sw_asistencia'
	];

	public function usuario()
	{
		return $this->belongsTo(User::class);
	}

	public function sede()
	{
		return $this->belongsTo(Sedes::class);
	}

	// public function horarios()
	// {
	// 	return $this->belongsTo(HorarioSedes::class);
	// }
}
