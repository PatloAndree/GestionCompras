<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Ubigeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UbigeoController extends Controller
{
	public function index()
	{
		$data = array();
		$data['departamentos'] = Ubigeo::where('id_padre_ubigeo', 2533)->get();
		return view('/content/panel/sedes', $data);
	}

	public function provincias(Request $request, Ubigeo $padre)
	{
		$provincias = Ubigeo::where('id_padre_ubigeo', $padre->id)->get();
		echo json_encode(array("sw_error" => 0, "provincias" => $provincias));
	}
}
