<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Sedes;
use App\Models\Ubigeo;
use App\Models\Usersdocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsuarioArchivos extends Controller
{
	public function __construct()
	{
		$this->middleware('role:1');
	}


	public function delete(Request $request, Usersdocuments $archivo, $usuarioid)
	{
		$archivo->delete();
		echo json_encode(array("sw_error" => 0, "message" => "Se elimino el archivo.", "archivos" => Usersdocuments::where('user_id', $usuarioid)->where('estado', 1)->get()));
	}
}
