<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fichasdocumentos extends Model
{
	use HasFactory;
	protected $table = 'fichasdocumentos';
	protected $fillable = [
		'ficha_id',
		'titulo',
		'extencion',
		'archivo',
		'estado'
	];

	public function ficha()
	{
		return $this->belongsTo(Fichas::class, 'ficha_id', 'id');
	}
}
