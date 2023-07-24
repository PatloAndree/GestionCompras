<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendario extends Model
{
	use HasFactory;
	protected $table = 'userscronograma';

	protected $fillable = [
		'id',
		'user_id',
		'fecha',
		'observacion',
		'jornada'
	];

	// public function categorias()
	// {
	// 	return $this->belongsToMany(Productos::class, 'productoscategorias', 'producto_id', 'categoria_id');
	// }

	// public function unidad()
	// {
	// 	return $this->belongsTo(Unidades::class);
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
