<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitudesdetalles extends Model
{
	use HasFactory;
	protected $table = 'solicitudesdetalles';
	protected $fillable = [
		'producto_id',
		'solicitud_id',
		'cantidad_solicitada',
		'cantidad_entregada',
		'admin_add',
		'status'
	];

	public $timestamps = false;

	public function dataproducto()
	{
		return $this->belongsTo(Productos::class, 'producto_id', 'id');
	}
}
