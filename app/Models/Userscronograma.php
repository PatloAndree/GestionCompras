<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userscronograma extends Model
{
	use HasFactory;
	protected $table = 'userscronograma';
	protected $fillable = [
		'user_id',
		'fecha',
		'observacion',
		'jornada',
		'sw_asignado',
		'aceptado',
		'status'
	];

	public function usuario()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
