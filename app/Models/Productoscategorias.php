<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productoscategorias extends Model
{
	protected $table = 'productoscategorias';
	protected $guarded = ['id'];

	public function productos()
	{
		return $this->belongsToMany(Productos::class);
	}
}
