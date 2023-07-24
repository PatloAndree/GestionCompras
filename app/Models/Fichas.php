<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fichas extends Model
{
	use HasFactory;
	protected $table = 'fichas';
	protected $fillable = [
		'paciente_id',
		'user_id',
		'age',
		'sede_id',
		'type_of_attention',
		'date_of_attention',
		'hour_of_attention_start',
		'hour_of_attention_end',
		'accident_location',
		'first_aid',
		'allergies',
		'personal_history',
		'proxy_document_id',
		'proxy_document',
		'proxy',
		'patient_type',
		'patient_type_text',
		'anamesis',
		'blood_pressure_start',
		'temperature_start',
		'oxygen_saturation_start',
		'heart_rate_start',
		'breathing_frequency_start',
		'presumptive_diagnosis',
		'treatment',
		'blood_pressure_end',
		'temperature_end',
		'oxygen_saturation_end',
		'breathing_frequency_end',
		'heart_rate_end',
		'transfer_sw',
		'transfer_destiny',
		'transfer_external_support',
		'observation',
		'status'
	];

	public function usuario()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function paciente()
	{
		return $this->belongsTo(Pacientes::class);
	}

	public function modificaciones()
	{
		return $this->hasMany(Fichasmodificaciones::class, 'ficha_id');
	}

	public function sede()
	{
		return $this->hasMany(Sedes::class, 'sede_id', 'id');
	}

	public function archivos()
	{
		return $this->hasMany(Fichasdocumentos::class, 'ficha_id');
	}
}
