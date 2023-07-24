<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Asignacionesdiarias;
use App\Models\Asistencias;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AsistenciasController extends Controller
{
	public function index()
	{
		$data = array();
		$data['usuarios'] = User::where('status', 1)->get();
		return view('/content/panel/asistencias', $data);
	}

	public function asistenciafecha($fecha)
	{
		$asignaciones = Asignacionesdiarias::where('status', 1)->where('fecha_asignada', $fecha)->get();
		$htmlTable = '';
		$fechaAsignada = Carbon::createFromFormat('Y-m-d', $fecha);
		foreach ($asignaciones as $asignacion) {

			$asistencia = Asistencias::where('asignaciondiaria_id', $asignacion->id)->first();

			$asistencia_id = 0;
			$fechaIngreso = $fecha;
			$horaIngreso = '';
			$fechaSalida = '';
			$horaSalida = '';
			if ($asistencia) {
				$asistencia_id = $asistencia->id;
				$fechaIngreso = $asistencia->fechaingreso;
				$horaIngreso = $asistencia->horaingreso;
				$fechaSalida = $asistencia->fechasalida;
				$horaSalida = $asistencia->horasalida;
			}

			$disabled = '';
			$classDiv = 'trEditable';

			if ($asignacion->sw_asistencia == 0 && $fechaSalida != '' && $horaSalida) {
				$disabled = 'disabled';
				$classDiv = '';
			}
			$htmlTable .= '
						<tr class="' . $classDiv . '">
							<td class="d-none">' . $asistencia_id . '</td>
							<td class="d-none">' . $asignacion->usuario_id . '</td>
							<td>' . $asignacion->usuario->name . ' ' . $asignacion->usuario->last_name . '</td>
							<td>' . $fechaAsignada->format('d/m/Y') . '</td>
							<td><input class="form-control" type="date" min="' . $fechaIngreso . '" value="' . $fechaIngreso . '" disabled/>
							<td><input class="form-control"  type="time" value="' . $horaIngreso . '" ' . $disabled . '/>
							<td><input class="form-control" type="date" min="' . $fechaIngreso . '" value="' . $fechaSalida . '" ' . $disabled . '/>
							<td><input class="form-control"  type="time" value="' . $horaSalida . '" ' . $disabled . '/></tr>';
		}

		if ($htmlTable != '') {
			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "data" => $htmlTable));
		} else {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => 'No hay usuarios asignados para está fecha.'));
		}
	}

	public function create(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'datos' => 'required|array|min:1'
		]);

		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
			exit;
		}

		$userAuth = Auth::user();
		$insertados = 0;
		$errorInsert = 0;
		$update = 0;
		$errorUpdate = 0;
		$eliminados = 0;
		foreach ($request->datos as $dato) {
			if ($dato['asistencia_id'] == 0) {
				$usuario = User::where('id', $dato['usuario_id'])->first();
				$factor = $usuario->factor;
				if ($usuario->sw_factor_variant == 1) {
					$factor = $usuario->factor_variant;
				}

				$asignaciondiaria = Asignacionesdiarias::where('usuario_id', $dato['usuario_id'])->where('status', 1)->where('fecha_asignada', $dato['fecha_asignada'])->first();

				$dataInsert = array();
				$dataInsert['asignaciondiaria_id'] = $asignaciondiaria->id;
				$dataInsert['usuario_registra_id'] = $userAuth->id;
				$dataInsert['usuario_registrado_id'] = trim($dato['usuario_id']);
				$dataInsert['fechaingreso'] = trim($dato['fecha_ingreso']);
				$dataInsert['horaingreso'] = trim($dato['hora_ingreso']);
				if (trim($dato['fecha_salida']) != '' && trim($dato['hora_salida']) != '') {
					$dataInsert['fechasalida'] = trim($dato['fecha_salida']);
					$dataInsert['horasalida'] = trim($dato['hora_salida']);
				}

				$dataInsert['factor'] = trim($factor);
				$asistencia = Asistencias::create($dataInsert);

				if ($asistencia) {
					$asignaciondiaria->sw_asistencia = 0;
					$asignaciondiaria->update();
					$insertados++;
				} else {
					$errorInsert++;
				}
			} else if ($dato['asistencia_id'] > 0) {
				if ($dato['delete'] == 0) {
					$dataUpdate = array();
					$dataUpdate['fechaingreso'] = trim($dato['fecha_ingreso']);
					$dataUpdate['horaingreso'] = trim($dato['hora_ingreso']);
					if ($dato['fecha_salida'] != '' && $dato['hora_salida']) {
						$dataUpdate['fechasalida'] = trim($dato['fecha_salida']);
						$dataUpdate['horasalida'] = trim($dato['hora_salida']);
					}

					try {
						$asignacion = Asistencias::where('id', $dato['asistencia_id'])->first();
						$asignacion->update($dataUpdate);
						$update++;
					} catch (\Illuminate\Database\QueryException $exception) {
						$errorUpdate++;
					}
				} else {
				}
			}
		}
		echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Asistencia actualizada."));
	}

	public function create_v0(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'usuario' => 'required|integer',
			'fecha_asignada' => 'required|integer',
			'ingreso_date' => 'date_format:Y-m-d',
			'ingreso_hour' => 'date_format:H:i',
			'salida_date' => 'date_format:Y-m-d',
			'salida_hour' => 'date_format:H:i'
		]);

		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
			exit;
		}

		$userAuth = Auth::user();
		$usuario = User::where('id', $request->usuario)->first();

		$factor = $usuario->factor;
		if ($usuario->sw_factor_variant == 1) {
			$factor = $usuario->factor_variant;
		}

		$asistencia = Asistencias::create([
			'asignaciondiaria_id' => $request->fecha_asignada,
			'usuario_registra_id' => $userAuth->id,
			'usuario_registrado_id' => $usuario->id,
			'fechaingreso' => $request->ingreso_date,
			'horaingreso' => $request->ingreso_hour,
			'fechasalida' => $request->salida_date,
			'horasalida' => $request->salida_hour,
			'factor' => $factor,
		]);

		if ($asistencia) {
			$asignaciondiaria = Asignacionesdiarias::find($request->fecha_asignada);
			$asignaciondiaria->sw_asistencia = 0;
			$asignaciondiaria->update();
			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se registro correctamente la asistencia"));
		} else {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => "Ocurrio un problema."));
		}
	}

	public function list()
	{
		$user = Auth::user();
		$asistencias = Asistencias::where('status', 1)->get();
		$dataAsistencias = [];
		foreach ($asistencias as $asistencia) {
			$fechaIngreso = Carbon::createFromFormat('Y-m-d H:i:s', $asistencia->fechaingreso . ' ' . $asistencia->horaingreso);
			$fechaSalida = Carbon::createFromFormat('Y-m-d H:i:s', $asistencia->fechasalida . ' ' . $asistencia->horasalida);
			$diferenciaenhoras = $fechaIngreso->diffInHours($fechaSalida) . ':' . $fechaIngreso->diff($fechaSalida)->format('%I');
			$ver = '<div class="d-inline-flex">
						<a href="javascript:;" class="asistencia-show" data-asistenciaid="' . $asistencia->id . '"><i data-feather="eye"></i></a>
					</div>';

			$arrayUsuario = array(
				"empleado" => $asistencia->empleado->name . ' ' . $asistencia->empleado->last_name,
				"fecha_asignada" => $asistencia->asignacion->fecha_asignada,
				"sede" => $asistencia->asignacion->sede->name,
				"fecha_ingreso" =>  $fechaIngreso->format('d/m/Y H:i:s'),
				"fecha_salida" =>  $fechaSalida->format('d/m/Y H:i:s'),
				"horas" => $diferenciaenhoras,
				"factor" => $asistencia->factor,
				"usuario" => $asistencia->usuario->name . ' ' . $asistencia->usuario->last_name,
				"actions" => $ver //. $editar . $eliminar
			);
			array_push($dataAsistencias, (object)$arrayUsuario);
		}
		$dataReturn['data'] = $dataAsistencias;
		return json_encode($dataReturn);
	}

	public function data(Request $request, Asistencias $asistencia)
	{
		$dataAsistencia = array();
		$fechaIngreso = Carbon::createFromFormat('Y-m-d H:i:s', $asistencia->fechaingreso . ' ' . $asistencia->horaingreso);
		$fechaSalida = Carbon::createFromFormat('Y-m-d H:i:s', $asistencia->fechasalida . ' ' . $asistencia->horasalida);
		$diferenciaenhoras = $fechaIngreso->diffInHours($fechaSalida) . ':' . $fechaIngreso->diff($fechaSalida)->format('%I');

		$dataAsistencia['id'] = $asistencia->id;
		$dataAsistencia['usuario'] = $asistencia->empleado->name . ' ' . $asistencia->empleado->last_name;
		$dataAsistencia['fecha_asignada'] =  Carbon::createFromFormat('Y-m-d', $asistencia->asignacion->fecha_asignada)->format('d/m/Y');
		$dataAsistencia['fecha_ingreso'] = $fechaIngreso->format('d/m/Y');
		$dataAsistencia['hora_ingreso'] = $fechaIngreso->format('H:i');
		$dataAsistencia['fecha_salida'] = $fechaSalida->format('d/m/Y');
		$dataAsistencia['hora_salida'] = $fechaSalida->format('H:i');

		echo json_encode(array("sw_error" => 0, "asistencia" => $dataAsistencia));
	}
}
