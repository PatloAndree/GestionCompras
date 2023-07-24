<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
	use HasFactory, Notifiable, HasRoles;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'document_id',
		'name',
		'last_name',
		'number_document',
		'date_of_birth',
		'date_of_hiring',
		'sex',
		'address',
		'phone',
		'email',
		'cuentabancaria',
		'cuentainterbancaria',
		'type',
		'factor',
		'sw_factor_variant',
		'factor_variant',
		'password',
		'activo',
		'status'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	public function document()
	{
		return $this->belongsTo(Documents::class);
	}
	public function archivos()
	{
		return $this->hasMany(Usersdocuments::class,);
	}
	public function sedes()
	{
		return $this->hasMany(Usersedes::class);
	}

	public function cronograma()
	{
		return $this->hasMany(Userscronograma::class, 'user_id', 'id');
	}
	public function asignaciondiaria(){
		return $this->hasMany(Asignacionesdiarias::class,'usuario_id','id');
	}
}
