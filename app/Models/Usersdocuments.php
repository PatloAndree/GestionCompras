<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usersdocuments extends Model
{
	use HasFactory;
	protected $table = 'documents_user';
	protected $fillable = [
		'user_id',
		'titulo',
		'extencion',
		'archivo',
		'estado'
	];

	public function usuario()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
