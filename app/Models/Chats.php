<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chats extends Model
{
	use HasFactory;
	protected $table = 'chats';
	protected $fillable = [
		'user_id',
		'wa_id',
		'status'
	];

	public function mensajes()
	{
		return $this->hasMany(Chatsdetalles::class, 'chat_id', 'id');
	}

	public function usuario()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
}
