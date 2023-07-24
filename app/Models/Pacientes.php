<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pacientes extends Model
{
	use HasFactory;
	protected $table = 'pacientes';

	protected $fillable = [
		'document_id',
		'name',
		'last_name',
		'number_document',
		'age',
		'sex',
		'address',
		'phone',
		'email',
		'status'
	];

	public function document()
	{
		return $this->belongsTo(Documents::class);
	}
}
