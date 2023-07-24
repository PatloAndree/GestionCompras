<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Fechas_list;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HorarioSedesController extends Controller
{
	// public function index()
	// {
	// 	$data = array();
	// 	$data['departamentos'] = Ubigeo::where('id_padre_ubigeo', 2533)->get();
	// 	return view('/content/panel/sedes', $data);
	// }

	public function getsede(Request $request,  $sede)
	{
		$horarios = Fechas_list::get();
		echo json_encode(array("sw_error" => 0, "horarios" => $horarios));
	}
}
