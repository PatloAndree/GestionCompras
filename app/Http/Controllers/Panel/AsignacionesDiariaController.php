<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Asignacionesdiarias;
use App\Models\Sedes;
use App\Models\User;
use App\Models\Fechas_list;
use App\Models\Userscronograma;
use App\Models\Usersedes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AsignacionesDiariaController extends Controller
{
	public function __construct()
	{
		$this->middleware('role:1,2');
	}

	public function index()
	{
		$data = array();
		$data['usuarios'] = User::where('status', 1)->get();
		$data['sedes'] = Sedes::where('status', 1)->get();
		return view('/content/panel/asignacionDiaria', $data);
	}

	public function users(Request $request, $fecha = '')
	{
		if ($fecha != '') {
			$usercronograma = Userscronograma::where('status', 1)
				->where('fecha', $fecha)->get();
			if (count($usercronograma) > 0) {
				$dataSend = array();
				$htmlTable = '';
				foreach ($usercronograma as $user) {
					$usuario = User::where('status', 1)->where('activo', 1)->where('id', $user->user_id)->first();
					if ($usuario) {
						$asignacion = Asignacionesdiarias::where('usuario_id', $user->user_id)->where('fecha_asignada', $fecha)->where('status', 1)->first();
						
						$id_asignacion = 0;
						$sede_asignacion = 0;
						$jornada_asignacion = 0;
						$asistencia_asignacion = 0;
				
						if ($asignacion) {
							$id_asignacion = $asignacion->id;
							$sede_asignacion = $asignacion->sede_id;
							$jornada_asignacion = $asignacion->horario_id;
							$asistencia_asignacion = $asignacion->sw_asistencia;
						}

						$disabled = '';
						$classDiv = 'trEditable';
						if ($asistencia_asignacion == 0 && $id_asignacion != 0) {
							$disabled = 'disabled';
							$classDiv = '';
						}
						$fechaAsignada = Carbon::createFromFormat('Y-m-d', $fecha);
						//SEDES
						if ($id_asignacion == 0) {
							$htmlSede = '<option value="" data-horario="[]" selected>Seleccionar</option>';
						} else {
							$htmlSede = '<option value="" data-horario="[]" >Seleccionar</option>';
							if (count($usuario->sedes) == 0) {
								$sede = Sedes::where('id', $sede_asignacion)->first();
								$htmlSede .= '<option value="' . $sede->id . '" selected>' . $sede->name . '</option>';
							}
						}

						if (count($usuario->sedes) > 0) {
							$existeSede = 0;
							foreach ($usuario->sedes as $sede) {
								$selected = '';
								if ($sede->sede_id == $sede_asignacion) {
									$selected = 'selected';
									$existeSede++;
								}
								$htmlSede .= "<option value='" . $sede->sede->id . "' data-horario='".json_encode($sede->sede->horarios->load('horarios'))."' ' . $selected . '>" . $sede->sede->name . "</option>";
							}
							if ($existeSede == 0 && $sede_asignacion != 0) {
								$sede = Sedes::where('id', $sede_asignacion)->first();
								$htmlSede .= '<option value="' . $sede->id . '" selected>' . $sede->name . '</option>';
							}
						}

					
						// $horarios = Fechas_list::where('id',)->get();
						$horarios = Fechas_list::where('id', $jornada_asignacion)->where('status',1)->get();					
						$htmlHorario = '<option value="" data-horario="[]" selected>Seleccionar</option>';
						
						foreach ($horarios as $horario) {
							$htmlHorario .= '<option value="' . $horario->id . '" selected>' . $horario->entrada .'-' .$horario->salida .'</option>';

						}
							
						$htmlTable .= '
						<tr class="' . $classDiv . '">
							<td class="d-none">' . $id_asignacion . '</td>
							<td class="d-none">' . $usuario->id . '</td>
							<td>' . $usuario->name . ' ' . $usuario->last_name . '</td>
							<td>' . $fechaAsignada->format('d/m/Y') . '</td>
							<td>
								<select class="form-select sede_horario" ' . $disabled . '>
									' . $htmlSede . '
								</select>
							</td>
							<td>
								<select class="form-select id_horario"' . $disabled . '>
									' . $htmlHorario . '
								</select>
							</td>
						</tr>';
					}
				}
				if ($htmlTable != '') {
					echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "data" => $htmlTable));
				} else {
					echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => 'No hay usuarios asignados para está fecha.'));
				}
			} else {
				echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => 'No hay usuarios asignados para está fecha.'));
			}
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
		// recorremos los datos
		$insertados = 0;
		$errorInsert = 0;
		$update = 0;
		$errorUpdate = 0;
		$eliminados = 0;
		foreach ($request->datos as $dato) {

			if ($dato['asignacion_id'] == 0) {
				$cronograma = Userscronograma::where('user_id', $dato['usuario_id'])->where('fecha', $dato['fecha'])->where('status', 1)->where('sw_asignado', 0)->first();
				if ($cronograma) {
					try {
						$cronograma->sw_asignado = 1;
						$cronograma->update();
					
						$valores = Asignacionesdiarias::create([
							'usuario_id' => trim($dato['usuario_id']),
							'horario_id' => trim($dato['horario']),
							'fecha_asignada' => trim($dato['fecha']),
							'sede_id' => trim($dato['sede'])
						]);
					
						$insertados++;
						//echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se asigno correctamente."));
					} catch (\Illuminate\Database\QueryException $exception) {
						$errorInsert++;
					}
				} else {
					$errorInsert++;
				}
			} else {

				if ($dato['delete'] == 0) {
					$dataUpdate = array();
					$dataUpdate['usuario_id'] = trim($dato['usuario_id']);
					$dataUpdate['fecha_asignada'] = trim($dato['fecha']);
					$dataUpdate['horario_id'] = trim($dato['horario']);
					$dataUpdate['sede_id'] = trim($dato['sede']);

					try {
						$asignacion = Asignacionesdiarias::where('id', $dato['asignacion_id'])->first();
						$asignacion->update($dataUpdate);
						$update++;
					} catch (\Illuminate\Database\QueryException $exception) {
						$errorUpdate++;
					}
				} else {
					$cronograma = Userscronograma::where('status', 1)->where('fecha', $dato['fecha'])->where('sw_asignado', 1)->first();
					if ($cronograma) {
						$cronograma->sw_asignado = 0;
						$cronograma->update();
					}

					$asignacion = Asignacionesdiarias::where('id', $dato['asignacion_id'])->first();

					$dataUpdate = [];
					$dataUpdate['status'] = '0';
					$asignacion->update($dataUpdate);
					$eliminados++;
				}
			}
		}

		echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Datos actualizados."));
	}

	public function create2(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'datos' => 'required|array|min:1'
		]);

		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
			exit;
		}
		// recorremos los datos
		$insertados = 0;
		$errorInsert = 0;
		$update = 0;
		$errorUpdate = 0;
		$eliminados = 0;
		if($request->datos[0]['fecha']>=now()->toDateString())
		{
			foreach ($request->datos as $dato) {
	
				if ($dato['asignacion_id'] == 0) {
					$cronograma = Userscronograma::where('user_id', $dato['usuario_id'])->where('fecha', $dato['fecha'])->where('status', 1)->where('sw_asignado', 0)->first();
					if(!$cronograma){
						$cronograma = Userscronograma::create([
							"user_id"=>$dato['usuario_id'],
							"fecha"=>$dato['fecha'],
							"observacion"=>"creado por admin",
							"sw_asignado"=>0,
							"aceptado"=>0,
							"status"=>1
						]);
					}
	
					try {
						$cronograma->sw_asignado = 1;
						$cronograma->update();
					
						$valores = Asignacionesdiarias::create([
							'usuario_id' => trim($dato['usuario_id']),
							'horario_id' => trim($dato['horario']),
							'fecha_asignada' => trim($dato['fecha']),
							'sede_id' => trim($dato['sede'])
						]);
					
						$insertados++;
						//echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se asigno correctamente."));
					} catch (\Illuminate\Database\QueryException $exception) {
						$errorInsert++;
					}
				} else {
					if ($dato['delete'] == 0) {
						$dataUpdate = array();
						$dataUpdate['usuario_id'] = trim($dato['usuario_id']);
						$dataUpdate['fecha_asignada'] = trim($dato['fecha']);
						$dataUpdate['horario_id'] = trim($dato['horario']);
						$dataUpdate['sede_id'] = trim($dato['sede']);
	
						try {
							$asignacion = Asignacionesdiarias::where('id', $dato['asignacion_id'])->first();
							$asignacion->update($dataUpdate);
							$update++;
						} catch (\Illuminate\Database\QueryException $exception) {
							$errorUpdate++;
						}
					} else {
						$cronograma = Userscronograma::where('status', 1)->where('fecha', $dato['fecha'])->where('sw_asignado', 1)->first();
						if ($cronograma && ($cronograma<=now()->toDateString())) {
							$cronograma->sw_asignado = 0;
							if($cronograma->observacion=='creado por admin'){
								$cronograma->status = 0;
							}
							
							$cronograma->save();
							$asignacion = Asignacionesdiarias::where('id', $dato['asignacion_id'])->first();
	
							$dataUpdate = [];
							$dataUpdate['status'] = '0';
							$asignacion->update($dataUpdate);
							$eliminados++;
						}
	
						
					}
				}
			}
			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Datos actualizados."));
		}else{
			echo json_encode(array("sw_error" => 1, "titulo" => "Atención", "type" => "error", "message" => "No se puede actualizar fechas pasadas."));
		}

		
	}
	public function datos(Request $request, $usuarioid = '')
	{
		$asignaciones = Asignacionesdiarias::where('status', 1)->where('sw_asistencia', 1)->where('usuario_id', $usuarioid)->get();
		if (count($asignaciones) > 0) {
			$datos = array();
			foreach ($asignaciones as $asignacion) {
				array_push($datos, array(
					"id" => $asignacion->id,
					"fecha_asignada" => $asignacion->fecha_asignada,
					"sede" => $asignacion->sede->name
				));
			}
			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "datos" => $datos));
		} else {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => 'No tiene fecha asignada.'));
		}
	}

	public function getfecha($fecha)
	{
		$userAuth = Auth::user();
		$asignaciones = Asignacionesdiarias::where('usuario_id', $userAuth->id)->where('status', 1)->where('fecha_asignada', $fecha)->get();
		$dataAsignacionFecha = array();
		if ($asignaciones) {
			foreach ($asignaciones as $asignacion) {
				array_push($dataAsignacionFecha, array(
					'id' => $asignacion->sede->id,
					'nombre' => $asignacion->sede->name
				));
			}
		}

		echo json_encode($dataAsignacionFecha);
	} 

	public function getUsersBySede(Request $request){
		$validator = Validator::make($request->all(), [
			'fecha' => 'required|date_format:Y-m-d',
			'sedeid' => 'required|integer'
		]);

		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
			exit;
		}

		$users=Usersedes::where('sede_id',$request->sedeid)
		->with(['usuario.asignaciondiaria'=>function($query) use($request){
			$query->where('fecha_asignada',$request->fecha);
			$query->where('sede_id',$request->sedeid);
			$query->where('status',1);
		},'sede.horarios.horarios','usuario.cronograma'=>function($query) use($request){
			$query->where('fecha',$request->fecha);
			$query->where('status',1);
		}])->whereHas('usuario', function ($query) {
			$query->where('status', '=', 1);
			$query->where('activo', '=',1);
		})->whereDoesntHave('usuario.asignaciondiaria', function ($query) use($request){
			$query->where('fecha_asignada','=',$request->fecha);
			$query->where('sede_id','!=',$request->sedeid);
		})->has('sede.horarios')->get();
		/*->whereHas('usuario.asignaciondiaria', function($query) use($request){
			$query->where('sede_id','=' ,$request->sedeid);
		  }) */
		echo json_encode($users);
		
	}
}
