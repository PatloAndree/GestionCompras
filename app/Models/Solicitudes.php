<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitudes extends Model
{
	use HasFactory;
	const PENDIENTE = "2";
	protected $table = 'solicitudes';
	protected $fillable = [
		'sede_id',
		'user_id',
		'note',
		'note_final',
		'fecha_atencion',
		'status'
	];

	public function usuario()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function sede()
	{
		return $this->belongsTo(Sedes::class, 'sede_id', 'id');
	}

	public function productos()
	{
		return $this->hasMany(Solicitudesdetalles::class, 'solicitud_id', 'id');
	}
}
