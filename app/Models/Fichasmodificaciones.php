<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fichasmodificaciones extends Model
{
	use HasFactory;
	protected $table = 'fichasmodificaciones';
	protected $fillable = [
		'ficha_id',
		'user_id',
		'campo',
		'valor_previo',
		'valor_nuevo'
	];

	public function usuario()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}

	public function ficha()
	{
		return $this->belongsTo(Fichas::class, 'ficha_id', 'id');
	}
}
