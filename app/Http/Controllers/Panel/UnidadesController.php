<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Unidades;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class UnidadesController extends Controller
{
	public function __construct()
	{
		$this->middleware('role:1');
	}

	public function index()
	{
		return view('/content/panel/unidades');
	}

	public function list()
	{
		$unidades = Unidades::where('status', 1)->orderBy('nombre', 'asc')->get();
		$dataUnidades = [];
		foreach ($unidades as $unidad) {
			$ver = '<div class="d-inline-flex">
								<a href="javascript:;" class="unidad-show" data-unidadid="' . $unidad->id . '"><i data-feather="eye"></i></a>
							  </div>
							  ';
			$editar = '<div class="d-inline-flex">
								<a href="javascript:;" class="unidad-edit" data-unidadid="' . $unidad->id . '"><i data-feather="edit"></i></a>
							  </div>
							  ';
			$eliminar = '<div class="d-inline-flex">
								<a href="javascript:;" class="unidad-delete" data-unidadid="' . $unidad->id . '"><i data-feather="trash-2" color="red"></i></a>
							  </div>
							  ';
			$arrayUnidad = array(
				"nombre" => $unidad->nombre,
				"abreviatura" => $unidad->abreviatura,
				"actions" => $ver . $editar . $eliminar
			);
			array_push($dataUnidades, (object)$arrayUnidad);
		}
		$dataReturn['data'] = $dataUnidades;
		return json_encode($dataReturn);
	}

	public function submit(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'tipo_submit' => 'required|integer',
			'unidad_nombre' => 'required|string|max:255',
			'unidad_abreviatura' => 'required|string|max:255'
		]);

		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
			exit;
		}

		if ($request->tipo_submit == 0) { // INSERTAMOS
			try {
				Unidades::create([
					'nombre' => trim($request->unidad_nombre),
					'nombre_url' => Str::slug(trim($request->unidad_nombre)),
					'abreviatura' => trim($request->unidad_abreviatura),
					'status' => 1
				]);
				echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se registro la unidad."));
			} catch (\Illuminate\Database\QueryException $exception) {
				$errorInfo = $exception->errorInfo;
				echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $errorInfo));
			}
		} elseif ($request->tipo_submit > 0) { // ACTUALIZAMOS
			$proveedor = Unidades::where('id', $request->tipo_submit)->first();
			if ($proveedor) {
				try {
					$proveedor->update([
						'nombre' => trim($request->unidad_nombre),
						'nombre_url' => Str::slug(trim($request->unidad_nombre)),
						'abreviatura' => trim($request->unidad_abreviatura),
						'status' => 1
					]);
					echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se actualizo la unidad."));
				} catch (\Illuminate\Database\QueryException $exception) {
					$errorInfo = $exception->errorInfo;
					echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $errorInfo));
				}
			} else {
				echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => 'Ocurrio un problema, no encontramos la unidad que quiere modificar.'));
			}
		} else {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => 'Ocurrio un problema, no encontramos la unidad que quiere modificar.'));
		}
	}

	public function data(Request $request, Unidades $unidad)
	{
		if ($unidad) {
			echo json_encode(array("sw_error" => 0, "data" => $unidad));
		} else {
			echo json_encode(array("sw_error" => 1, "data" => []));
		}
	}

	public function delete(Request $request, Unidades $unidad)
	{
		if ($unidad) {
			$userData = [];
			$userData['status'] = '0';
			$unidad->update($userData);
			echo json_encode(array("sw_error" => 0, "message" => "Se elimino el unidad."));
		} else {
			echo json_encode(array("sw_error" => 1, "message" => "Ocurrio un problema, intentelo nuevamente."));
		}
	}
}
