<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chatsdetalles extends Model
{
	use HasFactory;
	protected $table = 'chatsdetalles';

	protected $casts = [
		'created_at' => 'datetime:d/m/Y',
	];

	protected $fillable = [
		'chat_id',
		'mensaje',
		'tipo',
		'data_recibida',
		'watsapp_id'
	];
}
