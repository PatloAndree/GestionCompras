<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
	use HasFactory;
	protected $table = 'ventas';
	protected $fillable = [
		'id',
		'codigo_venta',
		'fecha_venta',
		'subtotal',
		'pago_total',
		'status',
		'igv',
        'comprobante',
        'dni_cliente',
        'nombres_cliente'
	];

	// public function usuario()
	// {
	// 	return $this->belongsTo(User::class, 'usuario_registra_id', 'id');
	// }

	// public function empleado()
	// {
	// 	return $this->belongsTo(User::class, 'usuario_registrado_id', 'id');
	// }

	// public function asignacion()
	// {
	// 	return $this->belongsTo(Asignacionesdiarias::class, 'asignaciondiaria_id', 'id');
	// }
}
