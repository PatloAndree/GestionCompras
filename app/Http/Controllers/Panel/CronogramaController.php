<?php



namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Asignacionesdiarias;
use App\Models\Sedes;
use App\Models\Userscronograma;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CronogramaController extends Controller
{
	// home
	public function index()
	{
		$userAuth = Auth::user();

		$data = array();
		/*if ($userAuth->type == 1) {
			$fechasCronograma = Userscronograma::get();
		} else {
			$fechasCronograma = Userscronograma::where('user_id', $userAuth->id)->get();
		}*/
		$fechasCronograma = Userscronograma::where('user_id', $userAuth->id)->get();

		$arrayCronograma = array();
		foreach ($fechasCronograma as $fechacronograma) {
			if ($fechacronograma >= now()->toDateString()) {
				$color = 'green';
			} else {
				$color = 'red';
			}

			if ($userAuth->type == 1) {
				$title = $fechacronograma->usuario->name . ' ' . $fechacronograma->usuario->last_name;
			} else {
				$title = "Asignado";
			}
			array_push($arrayCronograma, array(
				"id" => $fechacronograma->id,
				"color" => $color,
				"textColor" => 'white',
				"title" => $title,
				"setAllDay" => true,
				"start" => $fechacronograma->fecha,
				'extraparams' => array("fecha" => $fechacronograma->fecha)
			));
		}
		$data['cronograma'] = json_encode($arrayCronograma);
		$arr_sedes = array();
		foreach ($userAuth->sedes as $sede) {
			array_push($arr_sedes, $sede->sedes);
		}
		$data['sedes'] = $arr_sedes;
		return view('/content/panel/cronograma', $data);
	}

	public function data(Request $request)
	{
		$userAuth = Auth::user();
		$fechasCronograma = Userscronograma::where('user_id', $userAuth->id)->where('status', 1)->get();
		$arrayCronograma = array();
		foreach ($fechasCronograma as $fechacronograma) {
			if ($fechacronograma->jornada == 1) {
				$title = 'Tiempo completo';
				$color = 'rgba(234, 84, 85, 0.12)';
				$textColor = '#ea5455';
			} elseif ($fechacronograma->jornada == 2) {
				$title = 'Día';
				$color = 'rgba(255, 159, 67, 0.12)';
				$textColor = '#ff9f43';
			} elseif ($fechacronograma->jornada == 3) {
				$title = 'Noche';
				$color = 'rgba(40, 199, 111, 0.12)';
				$textColor = '#28c76f';
			} else {
				$title = 'No definido';
				$color = 'white';
				$textColor = 'black';
			}

			array_push($arrayCronograma, array(
				"id" => $fechacronograma->id,
				"color" => $color,
				"textColor" => $textColor,
				"title" => $title,
				"setAllDay" => true,
				"start" => $fechacronograma->fecha,
				'extraparams' => array("fecha" => $fechacronograma->fecha, "jornada" => $fechacronograma->jornada)
			));
		}
		echo json_encode($arrayCronograma);
	}

	public function datamihorario(Request $request)
	{
		$userAuth = Auth::user();
		$fechasCronograma = Asignacionesdiarias::where('usuario_id', $userAuth->id)->where('status', 1)->get();
		$arrayCronograma = array();
		foreach ($fechasCronograma as $fechacronograma) {
			if ($fechacronograma->jornada == 1) {
				$title = 'Tiempo completo <br>' . $fechacronograma->sede->name;
				$color = 'rgba(234, 84, 85, 0.12)';
				$textColor = '#ea5455';
			} elseif ($fechacronograma->jornada == 2) {
				$title = 'Día <br>' . $fechacronograma->sede->name;
				$color = 'rgba(255, 159, 67, 0.12)';
				$textColor = '#ff9f43';
			} elseif ($fechacronograma->jornada == 3) {
				$title = 'Noche <br>' . $fechacronograma->sede->name;
				$color = 'rgba(40, 199, 111, 0.12)';
				$textColor = '#28c76f';
			} else {
				$title = 'No definido <br>' . $fechacronograma->sede->name;
				$color = 'white';
				$textColor = 'black';
			}

			array_push($arrayCronograma, array(
				"id" => $fechacronograma->id,
				"color" => $color,
				"textColor" => $textColor,
				"title" => $title,
				"setAllDay" => true,
				"start" => $fechacronograma->fecha_asignada,
				'extraparams' => array("fecha" => $fechacronograma->fecha_asignada, "jornada" => $fechacronograma->jornada)
			));
		}
		echo json_encode($arrayCronograma);
	}

	public function create(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'fecha' => 'required|date_format:Y-m-d',
			'jornadalaboral' => 'required|integer'
		]);

		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
			exit;
		}
		$userAuth = Auth::user();
		$userCronograma = Userscronograma::create([
			'user_id' => $userAuth->id,
			'fecha' => trim($request->fecha),
			'jornada' => trim($request->jornadalaboral)
		]);

		echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se registro la fecha laboral y sus sedes posibles."));
	}

	public function update(Request $request, Userscronograma $usercontroller)
	{
		$validator = Validator::make($request->all(), [
			'sedes' => 'required|array',
			'jornadalaboral' => 'required|integer'
		]);

		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
		}

		$dataUpdate = array();
		$dataUpdate['jornada'] = trim($request->jornadalaboral);

		try {
			$usercontroller->update($dataUpdate);
			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se actualizo la fecha laboral."));
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorInfo = $exception->errorInfo;
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $errorInfo));
		}
	}

	public function disponibilidad(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'fecha' => 'required|date_format:Y-m-d',
			'jornada' => 'required|integer'
		]);

		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
			exit;
		}

		$userAuth = Auth::user();

		$disponibilidad = Userscronograma::where('user_id', $userAuth->id)->where('fecha', $request->fecha)->where('status', 1)->first();
		if ($disponibilidad) {
			if ($disponibilidad->sw_asignado == 0) {
				$disponibilidad->jornada = $request->jornada;
				$disponibilidad->update();
				echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se registro su disponibilidad."));
			} else {
				echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => 'No se puedo asignar su disponibilidad.'));
			}
		} else {
			try {
				$userCronograma = Userscronograma::create([
					'user_id' => $userAuth->id,
					'fecha' => trim($request->fecha),
					'jornada' => trim($request->jornada),
				]);
				echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se registro su disponibilidad."));
			} catch (\Illuminate\Database\QueryException $exception) {
				$errorInfo = $exception->errorInfo;
				echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $errorInfo));
			}
		}
	}

	public function dataday(Request $request, $dataday = '')
	{
		if ($dataday != '') {
			$userAuth = Auth::user();
			$datos = Userscronograma::where('user_id', $userAuth->id)->where('fecha', $dataday)->get();
			if (count($datos) > 0) {
				echo json_encode(array("sw_error" => 1, "titulo" => "Atención", "type" => "warning", "message" => "Ya existe programacion para la fecha seleccionada."));
			} else {
				echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Fecha disponible."));
			}
		} else {
			echo json_encode(array("sw_error" => 1, "titulo" => "Atención", "type" => "warning", "message" => "Formato de fecha de valido."));
		}
	}

	public function event(Request $request, $event = '', $id)
	{
		if ($event != '') {
			$userAuth = Auth::user();
			$datos = Userscronograma::where('user_id', $userAuth->id)->where('id', $id)->where('fecha', $event)->get();
			if (count($datos) > 0) {
				$data = array("fecha" => $datos[0]->fecha, "jornada" => $datos[0]->jornada, "sw_asignado" => $datos[0]->sw_asignado);
				echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "datos" => $data));
			} else {
				echo json_encode(array("sw_error" => 1, "titulo" => "Éxito", "type" => "success", "message" => "Ocurrio un problema."));
			}
		} else {
			echo json_encode(array("sw_error" => 1, "titulo" => "Atención", "type" => "warning", "message" => "Ocurrio un problema."));
		}
	}

	public function fecha_asignada(Request $request, $fecha = '', $id)
	{
		if ($fecha != '') {
			$userAuth = Auth::user();
			$datos = Asignacionesdiarias::where('usuario_id', $userAuth->id)->where('id', $id)->where('fecha_asignada', $fecha)->get();

			if (count($datos) > 0) {
				$data = array("fecha" => $datos[0]->fecha_asignada, "jornada" => $datos[0]->jornada, "sede" => $datos[0]->sede);
				echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "datos" => $data));
			} else {
				echo json_encode(array("sw_error" => 1, "titulo" => "Éxito", "type" => "success", "message" => "Ocurrio un problema."));
			}
		} else {
			echo json_encode(array("sw_error" => 1, "titulo" => "Atención", "type" => "warning", "message" => "Ocurrio un problema."));
		}
	}

	public function delete(Request $request, Userscronograma $cronograma)
	{
		if ($cronograma->status == 1 && $cronograma->sw_asignado == 0) {

			$dataUpdate = array();
			$dataUpdate['status'] = '0';

			try {
				$cronograma->update($dataUpdate);
				echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se elimino correctamente."));
			} catch (\Illuminate\Database\QueryException $exception) {
				$errorInfo = $exception->errorInfo;
				echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $errorInfo));
			}
		} else {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => 'Ocurrio un problema, intentelo nuevamente.'));
		}
	}
}
