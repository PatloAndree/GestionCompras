<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
	use HasFactory;
	protected $table = 'proveedores';

	protected $fillable = [
		'document_id',
		'nombre',
		'numerodocumento',
		'direccion',
		'contacto',
		'telefono',
		'correo',
		'otros',
		'status'
	];

	// public function document()
	// {
	// 	return $this->belongsTo(Documents::class);
	// }
}
