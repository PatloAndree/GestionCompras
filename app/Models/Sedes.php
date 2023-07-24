<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sedes extends Model
{
	use HasFactory;
	protected $table = 'sedes';
	protected $fillable = [
		'name',
		'pais_id',
		'departamento_id',
		'provincia_id',
		'distrito_id',
		'direccion',
		'apertura',
		'cierre',
		'sw_ambulancia',
		'status'
	];



	public function pais()
	{
		return $this->belongsTo(Ubigeo::class, 'pais_id', 'id');
	}
	public function departamento()
	{
		return $this->belongsTo(Ubigeo::class, 'departamento_id', 'id');
	}
	public function provincia()
	{
		return $this->belongsTo(Ubigeo::class, 'provincia_id', 'id');
	}
	public function distrito()
	{
		return $this->belongsTo(Ubigeo::class, 'distrito_id', 'id');
	}

	public function horarios()
	{
		return $this->hasMany(HorarioSedes::class,'sede_id' , 'id');
	}


	// public function horarios()
	// {
	// 	return $this->hasMany(HorarioSedes::class);
	// }
	// public function sedes()
	// {
	// 	return $this->hasMany(HorarioSedes::class);
	// }

	// public function horarios()
	// {
	// 	// return $this->hasMany(HorarioSedes::class,'horario_id','id');
	// 	return $this->hasMany(HorarioSedes::class);

		
	
	
	// public function sedes()
	// {
	// 	return $this->hasMany(HorarioSedes::class);
	// }
}
