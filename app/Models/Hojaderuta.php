<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hojaderuta extends Model
{
	use HasFactory;
	protected $table = 'hojaderuta';
	protected $fillable = [
		'id',
		'fecha_reporte',	
		'paramedico_id',	
		'piloto_id',	
		'turno_horas',
		'sede_id',	
		'sede_ambulancia',
		'observacion',
		'observacion_admin',
		'km_inicial',
		'km_final',	
		'gaso1',	
		'gaso2',	
		'numero_vales',	
		'valorizado',	
		'estado_hr',
		'galones'
	];

	public function enfermeros()
	{
		return $this->hasMany(User::class, 'id', 'sub_base');
	}
	
	public function detalles(){
		return $this->hasMany(Hojaderutadetalle::class, 'id_hoja', 'id');
	}

	
}
