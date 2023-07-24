<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Sedes;
use App\Models\ProductosDetalle;
use App\Models\Userscronograma;
use App\Models\Ubigeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use DateTime;
use Carbon\Carbon;
class CalendarioController extends Controller
{
	// public function __construct()
	// {
	// 	$this->middleware('role:1');
	// }
	
	public function index()
	{
		// $this->id_sed = '19';
  
		return view('/content/panel/calendario');
	}

    public function list($asistenciaDate )
	{
		$userAuth = Auth::user();
		$user_id = $userAuth->id;
		
		$asistenciaDate = "01-".str_replace(".","-",$asistenciaDate);
        $fechainicio =  date("y-m-01", strtotime($asistenciaDate));
        $fechafin =  date("y-m-t", strtotime($asistenciaDate));

		$userscronograma = Userscronograma::where('user_id', $user_id)->whereBetween('fecha', [$fechainicio, $fechafin])->orderBy('fecha', 'asc')->get();
	
        $fi = new DateTime($fechainicio);
        $ff = new DateTime($fechafin);
		$intervalo = array();
		$disabled = "";
		$observacion = "";
		$aceptado = 0;

        for($i = $fi; $i <= $ff; $i->modify('+1 day')){
            $fecha = $i->format('Y-m-d');
			$checked = "";
			$id = 0;
			
			foreach ($userscronograma as $Cronograma ) {
				if($Cronograma->aceptado == 1 ){
					$aceptado = 1;
				}
				if ($Cronograma->sw_asignado) {
					$disabled = "disabled";
				}
				if ($fecha == $Cronograma->fecha) {
					$checked = "checked";
					$id = $Cronograma->id;
				}
			$observacion = $Cronograma->observacion;

			}
			array_push($intervalo,array(
				'fecha' => $i->format('Y-m-d'),
				'checked' => $checked,
				'id' => $id
			));
        }
		$dataReturn['aceptado'] = $aceptado;
		$dataReturn['data'] = $intervalo;
		$dataReturn['observacion'] = $observacion;
		$dataReturn['estado'] = $disabled;

		 echo json_encode($dataReturn);
	}


    public function save(Request $request){
		
		ini_set('memory_limit','2048M');
		$userAuth = Auth::user();
		$count= 0;

		$validator = Validator::make($request->all(), [
			'user_id' => 'required|integer',
			'fecha' => 'required|date',
			'observación' => 'required|text',
			'aceptado' =>'required|integer'
		]);

		// ELIMINAR SEGUN RANGO DE FECHA

		$asistenciaDate = "01-".str_replace(".","-",$request->fechita);
        $fechainicio =  date("y-m-01", strtotime($asistenciaDate));
        $fechafin =  date("y-m-t", strtotime($asistenciaDate));

		if($request->sw_aceptado == 1){
			// echo("fiu mundo");

			$Calendario = Userscronograma::where('user_id', $userAuth->id)->whereBetween('fecha', [$fechainicio, $fechafin])->update([
				'aceptado' => 1
			]);
				
			if($Calendario){
				echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se actualizo correctamente","infor"=> $Calendario));
				
			}else{
				echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error" ));
	
			}

		}else{
			// echo("hola mundo");
			Userscronograma::where('user_id', $userAuth->id)->whereBetween('fecha', [$fechainicio, $fechafin])->delete();

			foreach ($request->fechas as $userfecha ) {
				$Calendario = Userscronograma::create([
					'user_id' => $userAuth->id,
					'fecha' => $userfecha,
					'observacion' => $request->observacion
				]);
	
				if ($Calendario) {
					$count++;
				}
			}
			if($count ==count($request->fechas) ){
				echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se registro correctamente","infor"=> $Calendario));
				
			}else{
				echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error" ));
	
			}
		}
		
		// echo($Calendario);

	

	}



}
