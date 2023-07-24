<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\Fichas;
use App\Models\Fichasdocumentos;
use App\Models\Fichasmodificaciones;
use App\Models\Pacientes;
use App\Models\Sedes;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FichasController extends Controller
{
	public function index()
	{
		Artisan::call('storage:link');
		return view('/content/panel/fichas');
	}

	public function nueva()
	{
		return view('/content/panel/fichasNueva');
	}

	public function create(Request $request)
	{

		$user = Auth::user();
		$validator = Validator::make($request->all(), [
			'sede_id' => 'required|integer',
			'paciente_name' => 'required|string|max:255',
			'paciente_last_name' => 'required|string|max:255',
			'paciente_tipo_documento' => 'required|integer',
			'paciente_documento' => 'required|numeric',
			'paciente_age' => 'required',
			'paciente_sex' => 'required|integer',
			'paciente_address' => 'required|string',
			'paciente_phone' => 'nullable|integer',
			'proxy_document_id' => 'nullable|integer',
			'proxy_document' => 'nullable|numeric',
			'proxy' => 'nullable|string',
			'paciente_tipo'=> 'required|integer',
			'paciente_tipo_nombre' => 'nullable|string',
			'type_of_attention' => 'required|integer',
			'date_of_attention' => 'required|date_format:Y-m-d',
			'hour_of_attention_start' => 'required',
			'hour_of_attention_end' => 'required',
			'accident_location' => 'nullable|string',
			'first_aid' => 'required|string',
			'allergies' => 'required|string',

			'personal_history' => 'required|string',
			'anamesis' => 'required|string',
			'blood_pressure_start' => 'required',
			'temperature_start' => 'required',
			'oxygen_saturation_start' => 'required',
			'heart_rate_start' => 'required',
			'breathing_frequency_start' => 'required',
			'presumptive_diagnosis' => 'required|string',
			'treatment' => 'required|string',
			'blood_pressure_end' => 'required',
			'temperature_end' => 'required',
			'oxygen_saturation_end' => 'required',
			'heart_rate_end' => 'required',
			'breathing_frequency_end' => 'required',
			'transfer_sw' => 'required|integer',
			'transfer_destiny' => 'nullable|integer',
			'transfer_external_support' => 'nullable|integer',
			'observation' => 'required|string',
		]);

		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
			exit;
		}


		$paciente = Pacientes::where('document_id', trim($request->paciente_tipo_documento))->where('number_document', trim($request->paciente_documento))->first();
		if (!$paciente) {
			$dataPaciente = array();
			$dataPaciente['document_id'] = trim($request->paciente_tipo_documento);
			$dataPaciente['name'] = trim($request->paciente_name);
			$dataPaciente['last_name'] = trim($request->paciente_last_name);
			$dataPaciente['number_document'] = trim($request->paciente_documento);
			$dataPaciente['age'] = trim($request->paciente_age);
			$dataPaciente['sex'] = trim($request->paciente_sex);
			$dataPaciente['address'] = trim($request->paciente_address);
			if (isset($request->paciente_phone) && trim($request->paciente_phone) != '') {
				$dataPaciente['phone'] = trim($request->paciente_phone);
			}
			if (isset($request->email) && trim($request->email) != '') {
				$dataPaciente['email'] = trim($request->email);
			}
			$paciente = Pacientes::create($dataPaciente);
		}



		if ($paciente) {
			$ficha = Fichas::create([
				'paciente_id' => $paciente->id,
				'user_id' => $user->id,
				'age' => trim($request->paciente_age),
				'sede_id' => $request->sede_id,
				'type_of_attention' => $request->type_of_attention,
				'date_of_attention' => $request->date_of_attention,
				'hour_of_attention_start' => $request->hour_of_attention_start,
				'hour_of_attention_end' => $request->hour_of_attention_end,
				'accident_location' => $request->accident_location,
				'first_aid' => $request->first_aid,
				'allergies' => $request->allergies,
				'personal_history' => $request->first_aid,
				'proxy_document_id' => $request->proxy_type_document,
				'proxy_document' => $request->proxy_document,
				'proxy' => $request->proxy,
				'patient_type' => $request->paciente_tipo,
				'patient_type_text' => $request->paciente_tipo_nombre,
				'anamesis' => $request->anamesis,
				'blood_pressure_start' => $request->blood_pressure_start,
				'temperature_start' => $request->temperature_start,
				'oxygen_saturation_start' => $request->oxygen_saturation_start,
				'heart_rate_start' => $request->heart_rate_start,
				'breathing_frequency_start' => $request->breathing_frequency_start,
				'presumptive_diagnosis' => $request->presumptive_diagnosis,
				'treatment' => $request->treatment,
				'blood_pressure_end' => $request->blood_pressure_end,
				'temperature_end' => $request->temperature_end,
				'oxygen_saturation_end' => $request->oxygen_saturation_end,
				'heart_rate_end' => $request->heart_rate_end,
				'breathing_frequency_end' => $request->breathing_frequency_end,
				'transfer_sw' => $request->transfer_sw,
				'transfer_destiny' => $request->transfer_destiny,
				'observation' => $request->observation,
				'status' => 1
			]);

			if ($request->hasfile('documentos')) {
				foreach ($request->file('documentos') as $key => $file) {

					$imageName = 'ficha_archive_' . time() . $key . '.' . $file->getClientOriginalExtension();
					$url = "storage/files/" . $imageName;
					$ruta = public_path($url);
					copy($file, $ruta);
					//$path = $file->storeAs('public/storage/files', $imageName);
					//$name = $file->getClientOriginalName();

					$titulo =  $file->getClientOriginalName();
					$extencion = $file->getClientOriginalExtension();
					$archivo = $url;

					Fichasdocumentos::insert(array("ficha_id" => $ficha->id, "titulo" => $titulo, "extencion" => $extencion, "archivo" => $archivo));
				}
			}
			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se registro correctamente el usuario."));
		} else {
			echo json_encode(array("sw_error" => 1, "titulo" => "Atención", "type" => "warning", "message" => "Ocurrio un problema, intentelo nuevamente."));
		}
	}

	public function list()
	{
		$user = Auth::user();
		if (Auth::user()->type == 1 || Auth::user()->type == 6 || Auth::user()->type == 3) {
			$fichas = Fichas::where('status', 1)->orderBy('date_of_attention', 'desc')->get();
		} else {
			$fichas = Fichas::where('status', 1)->where('user_id', $user->id)->orderBy('date_of_attention', 'desc')->get();
		}

		$dataFichas = [];
		foreach ($fichas as $ficha) {
			$fechaAtencion = Carbon::createFromFormat('Y-m-d', $ficha->date_of_attention);
			$tipoAtencion = '';
			if ($ficha->type_of_attention == 1) {
				$tipoAtencion = 'Consulta';
			} else if ($ficha->type_of_attention == 2) {
				$tipoAtencion = 'Urgencia';
			} else if ($ficha->type_of_attention == 3) {
				$tipoAtencion = 'Emergencia';
			} else if ($ficha->type_of_attention == 4) {
				$tipoAtencion = 'Accidente';
			}

			$ver = '<div class="d-inline-flex">
								<a href="'.route("ficha.show",[$ficha->id]).'" target="_blank"><i data-feather="eye"></i></a>
							  </div>
							  ';
			$eliminar = '<div class="d-inline-flex">
								<a href="javascript:;" class="ficha-delete" data-fichaid="' . $ficha->id . '"><i data-feather="trash-2" color="red"></i></a>
							  </div>
							  ';
			$eliminar = '';
			if ($user->type != '3' && $user->type != '6') {
				$eliminar = '';
			}
			$arrayUsuario = array(
				"paciente" => $ficha->paciente->name . ' ' . $ficha->paciente->last_name,
				"documento" => $ficha->paciente->document->short_name . ' : ' . $ficha->paciente->number_document,
				"fecha_atencion" => $fechaAtencion->format('d/m/Y'),
				"tipo_atencion" => $tipoAtencion,
				"usuario" => $ficha->usuario->name . ' ' . $ficha->usuario->last_name,
				"actions" => $ver . $eliminar
			);
			array_push($dataFichas, (object)$arrayUsuario);
		}
		$dataReturn['data'] = $dataFichas;
		return json_encode($dataReturn);
	}

	public function data(Request $request, Fichas $ficha)
	{
		$dataFicha = array();
		$dataFicha['id'] = $ficha->id;
		$dataFicha['document_id'] = $ficha->paciente->document_id;
		$dataFicha['number_document'] = $ficha->paciente->number_document;
		$dataFicha['name'] = $ficha->paciente->name;
		$dataFicha['last_name'] = $ficha->paciente->last_name;
		$dataFicha['age'] = $ficha->paciente->age;
		$dataFicha['sex'] = $ficha->paciente->sex;
		$dataFicha['address'] = $ficha->paciente->address;
		$dataFicha['phone'] = $ficha->paciente->phone;
		$dataFicha['email'] = $ficha->paciente->email;
		$dataFicha['archivos'] = $ficha->archivos;
		/******************************************** */
		$arrModificaciones = array();
		foreach ($ficha->modificaciones as $modificacion) {
			array_push($arrModificaciones, array(
				'fecha' => $modificacion->created_at->format('d/m/Y'),
				'campo' =>  $modificacion->campo,
				'previo' => $modificacion->valor_previo,
				'nuevo' => $modificacion->valor_nuevo,
				'usuario' => $modificacion->usuario->name . ' ' . $modificacion->usuario->last_name
			));
		}
		$dataFicha['modificaciones'] = $arrModificaciones;
		$dataFicha['type_of_attention'] = $ficha->type_of_attention;
		$dataFicha['date_of_attention'] = $ficha->date_of_attention;
		$dataFicha['diagnosis'] = $ficha->diagnosis;
		$dataFicha['treatment'] = $ficha->treatment;
		$dataFicha['observation'] = $ficha->observation;

		echo json_encode(array("sw_error" => 0, "ficha" => $dataFicha));
	}

	public function update(Request $request, Fichas $ficha)
	{
		$validator = Validator::make($request->all(), [
			'paciente_diagnostico' => 'required|string',
			'paciente_tratamiento' => 'required|string'
		]);
		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
		}

		if ($ficha) {
			$user = Auth::user();
			if ($user->type == '3' || $user->type == '6') {


				if (trim($ficha->diagnosis) != trim($request->paciente_diagnostico)) {
					Fichasmodificaciones::create([
						'ficha_id' => $ficha->id,
						'user_id' => $user->id,
						'campo' => 'Diagnóstico',
						'valor_previo' =>  $ficha->diagnosis,
						'valor_nuevo' => $request->paciente_diagnostico
					]);
				}

				if (trim($ficha->treatment) != trim($request->paciente_tratamiento)) {
					Fichasmodificaciones::create([
						'ficha_id' => $ficha->id,
						'user_id' => $user->id,
						'campo' => 'Tratamiento',
						'valor_previo' =>  $ficha->treatment,
						'valor_nuevo' => $request->paciente_tratamiento
					]);
				}


				$dataUpdate = array();
				$dataUpdate['diagnosis'] = trim($request->paciente_diagnostico);
				$dataUpdate['treatment'] = trim($request->paciente_tratamiento);

				try {
					$ficha->update($dataUpdate);
					echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se actualizo la ficha."));
				} catch (\Illuminate\Database\QueryException $exception) {
					$errorInfo = $exception->errorInfo;
					echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $errorInfo));
				}
			} else {
				echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => 'No estás autorizado para modificar está información.'));
			}
		} else {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => 'Ocurrio un problema, intentelo nuevamente.'));
		}
	}

	public function show(Fichas $ficha){
		$data['ficha'] = $ficha;
		$data['sede'] = Sedes::where('id',$ficha->sede_id)->first();
		$data['paciente'] = $ficha->paciente;
		$data['usuario'] = $ficha->usuario;
		$data['modificaciones'] = $ficha->modificaciones;
		$data['archivos'] = $ficha->archivos;
		return view('/content/panel/fichaEdicion',$data);
	}
}
