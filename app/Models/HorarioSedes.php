<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioSedes extends Model
{
	use HasFactory;
	protected $table = 'sedes_horarios';
	protected $fillable = [
        'sede_id',
		'horario_id',

	];

	// public function sedes()
	// {
	// 	return $this->hasMany(Fechas_list::class, 'sede_id', 'id');
	// }

    public function horarios()
	{
		// return $this->belongsTo(Sedes::class);
		return $this->belongsTo(Fechas_list::class, 'horario_id' , 'id');
		
	}


}
