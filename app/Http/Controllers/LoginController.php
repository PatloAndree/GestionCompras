<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
	public function index()
	{
		return view('/content/authentication/auth-login');
	}

	public function register()
	{

		return view('/content/authentication/auth-register');
	}

	public function recuperar_contrasenia()
	{

		return view('/content/authentication/auth-forgot-password');
	}
}
