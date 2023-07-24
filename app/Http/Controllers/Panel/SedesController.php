<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Sedes;
use App\Models\ProductosDetalle;
use App\Models\Productos;
use App\Models\Ubigeo;
use App\Models\Usersede;
use App\Models\HorarioSedes;
use App\Models\Sedesproductos;
use App\Models\Fechas_list;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SedesController extends Controller
{
	// $productos = ProductosDetalle::where('sede_id', $id)->get();
	// $sede_id = 
	public $valor_global;

	public function setUsuario_id($valor)
	{

		// print_r($this->valor_global = $valor);

		// $dataProductos = [];
		$arrayProducto = collect(["sede" => $valor]);
		// array_push($dataProductos, $arrayProducto);
		// print_r("soy data" . $arrayProducto);

		$data['data'] = $arrayProducto;
	

		return json_encode($data);
		// print_r("soy data".$data);

	}

	public function __construct()
	{
		$this->middleware('role:1');
	}

	public function index()
	{
		// $this->id_sed = '19';
		$data = array();
		$data['departamentos'] = Ubigeo::where('id_padre_ubigeo', 2533)->get();
		return view('/content/panel/sedes', $data);
	}

	public function create(Request $request)
	{
		$userAuth = Auth::user();
		$user_id = $userAuth->id;


		$validator = Validator::make($request->all(), [
			'sede_name' => 'required|string|max:255',
			'sede_departamento' => 'required|integer',
			'sede_provincia' => 'required|integer',
			'sede_distrito' => 'required|integer',
			'sede_direccion' => 'required|string',
			'sede_apertura' => 'required|date_format:H:i',
			'sede_cierre' => 'required|date_format:H:i',
		]);

		$sede_sw_ambulancia = 0;
		if (isset($request->sede_sw_ambulancia)) {
			$sede_sw_ambulancia = 1;
		}

		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
		}

		$dataSede = array();
		$dataSede['name'] = trim($request->sede_name);
		$dataSede['pais_id'] = 2533;
		$dataSede['departamento_id'] = trim($request->sede_departamento);
		$dataSede['provincia_id'] = trim($request->sede_provincia);
		$dataSede['distrito_id'] = trim($request->sede_distrito);
		$dataSede['direccion'] = trim($request->sede_direccion);
		$dataSede['apertura'] = trim($request->sede_apertura);
		$dataSede['sw_ambulancia'] = trim($request->sede_sw_ambulancia);
		$dataSede['cierre'] = trim($request->sede_cierre);
		
		if($dataSede){
			$Sedes = Sedes::create($dataSede);
			if (isset($request->sedeHorarios)) {
				foreach ($request->sedeHorarios as $horario) {
					$dataInsertSede = array();
					$dataInsertSede['sede_id'] = $Sedes->id;
					$dataInsertSede['horario_id'] = $horario;
					HorarioSedes::create($dataInsertSede);
				}
			}
		}

		if(isset($dataSede)){
			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se registro correctamente la sede"));
		}else{
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $errorInfo));

		}


	}

	public function show($sede_id)
	{
		// $valor = $sede_id;
		$data['sede_id'] = $sede_id != "" ? $sede_id : 0;
		// $sede = Horarios::where('status', 1)->get();
		if ($sede_id != 0) {
			
			$this->setUsuario_id($sede_id);
			$sede = Sedes::where('id', $sede_id)->where('status', 1)->first();
			$horarios = Fechas_list::where('status', 1)->get();

			$horarios_array = array();
			foreach ($horarios as $horario) {
				array_push(
					$horarios_array,
					array(
						"id" => $horario->id,
						"entrada" => $horario->entrada,
						"salida" => $horario->salida
						
					)
				);
			}
			
			$data['departamentos'] = Ubigeo::where('id_padre_ubigeo', 2533)->get();
			$data['provincias'] = Ubigeo::where('id_padre_ubigeo', $sede->departamento_id )->get();
			$data['distritos'] = Ubigeo::where('id_padre_ubigeo',$sede->provincia_id )->get();
			$breadcrumbs = [
				['link' => "panel/sede", 'name' => "Sedes"], ['name' => "Horarios de sede"]
			];	

			$arr_horariosede = [];
			foreach ($sede->horarios as $horarioid) {	
				array_push($arr_horariosede, $horarioid->horario_id);
			}
	

			$dataSedes = array();
			$dataSedes['id'] = $sede->id;
			$dataSedes['departamento_id'] = $sede->departamento_id;
			$dataSedes['provincias_id'] = $sede->provincia_id;
			$dataSedes['distritos_id'] = $sede->distrito_id;
			$dataSedes['nombre'] = $sede->name;
			$dataSedes['direccion'] = $sede->direccion;
			$dataSedes['apertura'] = $sede->apertura;
			$dataSedes['cierre'] = $sede->cierre;

			$dataSedes["horaid"] = $arr_horariosede;

			$data['sedes'] = $dataSedes;
			$data['horarios'] = $horarios_array;
			$data['breadcrumbs'] = $breadcrumbs;

		return view('/content/panel/sedeProductos', $data);


		}else if ($sede_id == 0) {
		
			$horarios = Fechas_list::where('status', 1)->get();
			$data['departamentos'] = Ubigeo::where('id_padre_ubigeo', 2533)->get();
			// $data['sede'] = $dataSede;
			$data['horarios'] = $horarios;
			return view('/content/panel/sedeProductos', $data);

		} 
		else {
			return abort(404);
		}
	}

	public function products($sede_id)
	{
		// $valor = $sede_id;
		$data['sede_id'] = $sede_id != "" ? $sede_id : 0;
		$sede = Sedes::where('id', $sede_id)->where('status', 1)->first();

		// $data['departamentos'] = Ubigeo::where('id_padre_ubigeo', 2533)->get();
		// $data['provincias'] = Ubigeo::where('id_padre_ubigeo', $sede->departamento_id )->get();
		// $data['distritos'] = Ubigeo::where('id_padre_ubigeo',$sede->provincia_id )->get();
		$this->setUsuario_id($sede_id);
		$sedes = Sedes::where('id', $sede_id)->where('status', 1)->first();
		// print_r("--".$this->valor);

		if ($sedes) {
			$breadcrumbs = [
				['link' => "panel/sedes", 'name' => "Sedes"], ['name' => "Productos por sede"]
			];
			$dataSedes = array();
			$dataSedes['id'] = $sedes->id;
			$dataSedes['nombre'] = $sedes->name;
			$dataSedes['pais'] = Ubigeo::where('id', $sedes->pais_id)->first()->nombre_ubigeo;
			// $dataSedes['departamento_id'] = $sedes->departamento_id;
			$dataSedes['departamento'] = Ubigeo::where('id', $sedes->departamento_id)->first()->nombre_ubigeo;
			$dataSedes['provincia'] = Ubigeo::where('id', $sedes->provincia_id)->first()->nombre_ubigeo;
			// $dataSedes['provincias_id'] = $sedes->provincia_id;
			$dataSedes['distrito'] = Ubigeo::where('id', $sedes->distrito_id)->first()->nombre_ubigeo;
			// $dataSedes['distrito_id'] = $sedes->distrito_id;
			$dataSedes['direccion'] = $sedes->direccion;
			$dataSedes['apertura'] = $sedes->apertura;
			$dataSedes['cierre'] = $sedes->cierre;
			$data['sedes'] = $dataSedes;
			$data['breadcrumbs'] = $breadcrumbs;
	
		} else {
			return abort(404);
		}
		
		return view('/content/panel/sedesProDetalle' , $data);
		// return json_encode($data);

	}

	public function listar(Request $request, $sede_id)
	{
		// $hola = $this->setUsuario_id();
		// print_r("k fue".$hola);
		// die();
		// $valor = $sede_id;
		// print_r($valor);
		// die();
		$productos = Sedesproductos::where('sede_id', $sede_id)->get();
		// print_r($productos);
		// die();
		// echo($productos[0]. '---' . $valor);
		$dataProductos = [];
		foreach ($productos as $producto) {

			$arrayProducto = array(

				"id" => $producto->pro_detalle_id,

				"nombre" => Productos::where('id', $producto->producto_id)->first()->nombre,
				// "nombre" => $producto->pro_detalle_id,
				// "sede" => Sedes::where('id', $sede[0]->id)->first()->name,
				"cantidad" => $producto->cantidad,
				"fecha_v" => $producto->fecha_vencimiento

			);
			array_push($dataProductos, (object)$arrayProducto);
		}
		// $data['data'] = $sede_id;
		$data['data'] = $dataProductos;
		// print_r($data);
		// die();
		// }
		// print_r("este es el valor ".$valor);
		return json_encode($data);
	}


	public function list()
	{
		$sede = Sedes::where('status', 1)->get();
		$dataSedes = [];
		foreach ($sede as $sede) {
			//$fechaNacimiento = Carbon::createFromFormat('Y-m-d', $sede->date_of_birth);
			$role = '<span class="badge badge-glow bg-dark">SIN ASIGNAR</span>';
			$arrayUsuario = array(
				"nombre" => $sede->name,
				"pais" => Ubigeo::where('id', $sede->pais_id)->first()->nombre_ubigeo,
				"departamento" => Ubigeo::where('id', $sede->departamento_id)->first()->nombre_ubigeo,
				"provincia" => Ubigeo::where('id', $sede->provincia_id)->first()->nombre_ubigeo,
				'direccion' => $sede->direccion,
				"distrito" => Ubigeo::where('id', $sede->distrito_id)->first()->nombre_ubigeo,
				"actions" => '
							 <div class="d-inline-flex">
							  <a href="sedes/products/' . $sede->id . '" class="sede-products" target="_blank" ><i data-feather="shopping-cart"></i></a>
							 </div>
							  <div class="d-inline-flex">
							  <a href="sedes/show/' . $sede->id . '" class="sede-show" target="_blank" ><i data-feather="edit"></i></a>
							  </div>
							  <div class="d-inline-flex">
								<a href="javascript:;" class="sede-delete" data-sedeid="' . $sede->id . '" data-nombre="' . $sede->name . '"><i data-feather="trash-2" color="red"></i></a>
							  </div>'
			);
			array_push($dataSedes, (object)$arrayUsuario);
		}
		$dataReturn['data'] = $dataSedes;
		return json_encode($dataReturn);
	}

	public function data(Request $request, Sedes $sede)
	{
		$dataSede = array();
		$dataSede['id'] = $sede->id;
		$dataSede['nombre'] = $sede->name;
		$dataSede['departamentos'] = Ubigeo::where('id_padre_ubigeo', $sede->pais_id)->get();
		$dataSede['departamento_id'] = $sede->departamento_id;
		$dataSede['provincias'] = Ubigeo::where('id_padre_ubigeo', $sede->departamento_id)->get();
		$dataSede['provincias_id'] = $sede->provincia_id;
		$dataSede['distritos'] = Ubigeo::where('id_padre_ubigeo', $sede->provincia_id)->get();
		$dataSede['distrito_id'] = $sede->distrito_id;
		$dataSede['direccion'] = $sede->direccion;
		$dataSede['sw_ambulancia'] = $sede->sw_ambulancia;
		$dataSede['apertura'] = $sede->apertura;
		$dataSede['cierre'] = $sede->cierre;

		echo json_encode(array("sw_error" => 0, "sede" => $dataSede));
	}

	public function update(Request $request, Sedes $sede)
	{
		ini_set('memory_limit','2048M');
		// print_r($sede->id);
		// die();
		$userAuth = Auth::user();
		$user_id = $userAuth->id;

		$validator = Validator::make($request->all(), [
			'sede_name' => 'required|string|max:255',
			'sede_departamento' => 'required|integer',
			'sede_provincia' => 'required|integer',
			'sede_distrito' => 'required|integer',
			'sede_direccion' => 'required|string',
			'sede_apertura1' => 'required|date_format:H:i',
			'sede_cierre1' => 'required|date_format:H:i',
		]);

		$sede_sw_ambulancia = 0;
		if (isset($request->sede_sw_ambulancia)) {
			$sede_sw_ambulancia = 1;
		}

		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
		}

		
		$dataSedeUpdate = array();
		$dataSedeUpdate['name'] = trim($request->sede_name);
		// $dataSedeUpdate['pais_id'] = trim($request);
		$dataSedeUpdate['departamento_id'] = trim($request->sede_departamento);
		$dataSedeUpdate['provincia_id'] = trim($request->sede_provincia);
		$dataSedeUpdate['distrito_id'] = trim($request->sede_distrito);
		$dataSedeUpdate['direccion'] = trim($request->sede_direccion);
		$dataSedeUpdate['apertura'] = trim($request->sede_apertura1);
		$dataSedeUpdate['sw_ambulancia'] = trim($request->sede_sw_ambulancia);
		$dataSedeUpdate['cierre'] = trim($request->sede_cierre1);
	

		$sedes = Sedes::where('id',$sede->id)->update($dataSedeUpdate);

			if($sedes){
				HorarioSedes::where('sede_id', $sede->id)->delete();
				if (isset($request->sedesHorarios) && count($request->sedesHorarios) > 0 ) {
					foreach ($request->sedesHorarios as $horario) {
						$dataInsertSede = array();
						$dataInsertSede['sede_id'] = $sede->id;
						$dataInsertSede['horario_id'] = $horario;
						HorarioSedes::create($dataInsertSede);
					}
				}
			}
	
			

		if(isset($sedes)){
			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se actualizo correctamente la sede"));
		}else{
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $errorInfo));

		}
	}

	public function delete(Request $request, Sedes $sede)
	{
		// $userData = [];
		// $userData['status'] = '0';
		$sedes = Sedes::where('id',$sede->id)->update(['status'=>0]);

		// $sede->update($userData);
		echo json_encode(array("sw_error" => 0, "message" => "Se elimino la sede."));
	}

}
