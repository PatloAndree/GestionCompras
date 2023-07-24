<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usersedes extends Model
{
	use HasFactory;
	protected $table = 'users_sedes';
	protected $fillable = [
		'user_id',
		'sede_id'
	];

	public function usuario()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
	public function sede()
	{
		return $this->belongsTo(Sedes::class, 'sede_id', 'id');
	}
}
