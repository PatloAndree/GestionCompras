<?php

namespace App\Http\Controllers\Panel;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Fichas;
use App\Models\Pacientes;
use App\Models\Productos;
use App\Models\Ventas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
	public function index()
	{
		$user = Auth::user();
		if ($user) {
			if ($user->type == 1) {
				return redirect()->route('home');
			} else {
				return redirect()->route('calendario.index');
			}
		} else {
			return redirect()->route('home');
		}
	}
	public function home()
	{
		$user = Auth::user();
		if ($user->type == 1) {
			$data['productos'] = Productos::where('status', 1)->count();
			$data['usuarios'] = User::where('status', 1)->count();
			$data['ventas'] = Ventas::where('status', 1)->count();
			return view('/content/home', $data);
		} else {
			return redirect()->route('calendario.index');
		}
	}
}
