<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Sedes;
use App\Models\ProductosDetalle;
use App\Models\Fechas_list;
use App\Models\Ubigeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use DateTime;
use Carbon\Carbon;

class Fechas_listController extends Controller
{
	public function __construct()
	{
		$this->middleware('role:1');
	}

	public function index()
	{
		return view('/content/panel/fechas_lista');
	}


	public function listar()
	{
		$fechas = fechas_list::where('status', 1)->get();
		$dataFechas = [];
		foreach ($fechas as $fecha) {
			$arrayfechas = array(
				"id" => $fecha->id,
				"entrada" => $fecha->entrada,
				"salida" => $fecha->salida,
				"actions" => '<div class="d-inline-flex">
								<a href="javascript:;" class="fechas_edit" data-fechaid="' . $fecha->id . '" ><i data-feather="edit"></i></a>
							  </div>
							  <div class="d-inline-flex">
								<a href="javascript:;" class="fechas_delete" data-fechaid="' . $fecha->id . '"><i data-feather="trash-2" color="red"></i></a>
							  </div>'
			);
			array_push($dataFechas, (object) $arrayfechas);
		}

		$data['data'] = $dataFechas;



		return json_encode($data);
	}

	public function save(Request $request)
	{

		$Fechas = Fechas_list::create([
			'entrada' => $request->fecha_Inicio,
			'salida' => $request->fecha_Fin
		]);

		if ($Fechas) {
			echo json_encode(
				array(
					"sw_error" => 0,
					"titulo" => "Éxito",
					"type" =>
					"success",
					"message" => "Se registro correctamente",
					"infor" => $Fechas
				)
			);

		} else {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error"));
		}
	}

	public function getFecha($id){
		$Fechas = Fechas_list::where('id', $id)->get();
		if($Fechas){
			 echo json_encode(
				array(
					"sw_error" => 0,
					"titulo" => "Éxito",
					"type" =>
					"success",
					"message" => "Correcto",
					"obj" => $Fechas
				)
			);;
		}
	}

	public function update(Request $request)
	{

		$Fechas = Fechas_list::where('id',$request->fechaId)->update([
			'entrada' => $request->fecha_Inicio,
			'salida' => $request->fecha_Fin
		]);

		if ($Fechas) {
			echo json_encode(
				array(
					"sw_error" => 0,
					"titulo" => "Éxito",
					"type" =>
					"success",
					"message" => "Se actualizo correctamente",
					"infor" => $Fechas
				)
			);

		} else {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error"));
		}
	}


	public function delete($id)
	{
		$Fechas = Fechas_list::where('id',$id)->update([
			'status' => 0
		]);

		if($Fechas){

			echo json_encode(array("sw_error" => 0, "message" => "Se elimino la fecha.","obj"=>$Fechas));
		}else{
			echo json_encode(array("sw_error" => 1, "message" => "Ocurrio un problema ."));

		}
	}





}