<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compras extends Model
{
	use HasFactory;
	protected $table = 'compras';

	protected $fillable = [
		'user_id',
		'sede_id',
		'proveedor_id',
		'fecha',
		'codigocompra',
		'documento',
		'datos',
		'status'
	];

	// public function document()
	// {
	// 	return $this->belongsTo(Documents::class);
	// }

	// public function proveedor()
	// {
	// 	return $this->belongsTo(Proveedores::class, 'proveedor_id', 'id');
	// }

	// public function productos()
	// {
	// 	return $this->hasMany(Comprasdetalles::class, 'compra_id', 'id');
	// }
}
