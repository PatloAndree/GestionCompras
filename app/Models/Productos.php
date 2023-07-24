<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Productos extends Model
{
	use HasFactory;
	protected $table = 'productos';

	protected $fillable = [
		'id',
		'nombre_producto',
		'nombre_abrev',
		'imagen_producto',
		'stock_producto',
		'precio_compra',
		'precio_venta',
		'fecha_ven_producto',
		'categoria_producto',
		'marca_producto',
	];

	// public function categorias()
	// {
	// 	return $this->belongsToMany(Productos::class, 'productoscategorias', 'producto_id', 'categoria_id');
	// }

	// public function unidad()
	// {
	// 	return $this->belongsTo(Unidades::class);
	// }

	// public function detalles(){
	// 	return $this->hasMany(Productosdetalles::class, 'producto_id', 'id')->orderBy('fecha_vencimiento','asc');
	// }

	/*public function categorias()
	{
		return $this->belongsToMany(
			Productoscategorias::class
		);
		/*return $this->belongsToMany(
			config('permission.models.role'),
			config('permission.table_names.role_has_permissions'),
			PermissionRegistrar::$pivotPermission,
			PermissionRegistrar::$pivotRole
		);
	}*/
}
