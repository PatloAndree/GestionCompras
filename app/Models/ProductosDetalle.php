<?php

namespace App\Models;

use App\Http\Controllers\Panel\ProductosController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductosDetalle extends Model
{
	use HasFactory;
	protected $table = 'productosdetalles';

	protected $fillable = [
		'pro_detalle_id',
		'producto_id',
		'sede_id',
		'cantidad',
		'fecha_vencimiento'
		
	];

	public function categorias()
	{
		return $this->belongsToMany(Productos::class, 'productoscategorias', 'producto_id', 'categoria_id');
	}

	public function unidad()
	{
		return $this->belongsTo(Unidades::class);
	}

	public function producto()
	{
		return $this->belongsTo(Productos::class,'producto_id','id');
	}
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
