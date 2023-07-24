<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Proveedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProveedoresController extends Controller
{
	public function __construct()
	{
		$this->middleware('role:1');
	}

	public function index()
	{
		return view('/content/panel/proveedores');
	}

	public function list()
	{
		$proveedores = Proveedores::where('status', 1)->orderBy('nombre', 'asc')->get();
		$dataProveedores = [];
		foreach ($proveedores as $proveedor) {
			$ver = '<div class="d-inline-flex">
								<a href="javascript:;" class="proveedor-show" data-proveedorid="' . $proveedor->id . '"><i data-feather="eye"></i></a>
							  </div>
							  ';
			$editar = '<div class="d-inline-flex">
								<a href="javascript:;" class="proveedor-edit" data-proveedorid="' . $proveedor->id . '"><i data-feather="edit"></i></a>
							  </div>
							  ';
			$eliminar = '<div class="d-inline-flex">
								<a href="javascript:;" class="proveedor-delete" data-proveedorid="' . $proveedor->id . '"><i data-feather="trash-2" color="red"></i></a>
							  </div>
							  ';
			$arrayProveedor = array(
				"nombre" => $proveedor->nombre,
				"documento" => "DNI",
				"celular" =>  $proveedor->telefono,
				"correo" => $proveedor->correo,
				"contacto" => $proveedor->contacto,
				"actions" => $ver . $editar . $eliminar
			);
			array_push($dataProveedores, (object)$arrayProveedor);
		}
		$dataReturn['data'] = $dataProveedores;
		return json_encode($dataReturn);
	}

	public function submit(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'tipo_submit' => 'required|integer',
			'proveedor_nombre' => 'required|string|max:255',
			'proveedor_tipo_documento' => 'required|integer',
			'proveedor_documento' => 'required|numeric',
			'proveedor_direccion' => 'required|string',
			'proveedor_contacto' => 'required|string|max:450',
			'proveedor_telefono' => 'required|integer',
			'proveedor_correo' => 'nullable|string|email|max:255',
			'proveedor_otros' => 'nullable|string'
		]);

		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
			exit;
		}

		if ($request->tipo_submit == 0) { // INSERTAMOS
			try {
				Proveedores::create([
					'nombre' => trim($request->proveedor_nombre),
					'document_id' => trim($request->proveedor_tipo_documento),
					'numerodocumento' => trim($request->proveedor_documento),
					'direccion' => trim($request->proveedor_direccion),
					'contacto' => trim($request->proveedor_contacto),
					'telefono' => trim($request->proveedor_telefono),
					'correo' => trim($request->proveedor_correo),
					'otros' => trim($request->proveedor_otros)
				]);
				echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se registro el proveedor."));
			} catch (\Illuminate\Database\QueryException $exception) {
				$errorInfo = $exception->errorInfo;
				echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $errorInfo));
			}
		} elseif ($request->tipo_submit > 0) { // ACTUALIZAMOS
			$proveedor = Proveedores::where('id', $request->tipo_submit)->first();
			if ($proveedor) {
				try {
					$proveedor->update([
						'nombre' => trim($request->proveedor_nombre),
						'document_id' => trim($request->proveedor_tipo_documento),
						'numerodocumento' => trim($request->proveedor_documento),
						'direccion' => trim($request->proveedor_direccion),
						'contacto' => trim($request->proveedor_contacto),
						'telefono' => trim($request->proveedor_telefono),
						'correo' => trim($request->proveedor_correo),
						'otros' => trim($request->proveedor_otros)
					]);
					echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se actualizo el proveedor."));
				} catch (\Illuminate\Database\QueryException $exception) {
					$errorInfo = $exception->errorInfo;
					echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $errorInfo));
				}
			} else {
				echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => 'Ocurrio un problema, no encontramos el proveedor que quiere modificar.'));
			}
		} else {
		}
	}

	public function data(Request $request, Proveedores $proveedor)
	{
		if ($proveedor) {
			echo json_encode(array("sw_error" => 0, "data" => $proveedor));
		} else {
			echo json_encode(array("sw_error" => 1, "data" => []));
		}
	}

	public function delete(Request $request, Proveedores $proveedor)
	{
		if ($proveedor) {
			$userData = [];
			$userData['status'] = '0';
			$proveedor->update($userData);
			echo json_encode(array("sw_error" => 0, "message" => "Se elimino el proveedor."));
		} else {
			echo json_encode(array("sw_error" => 1, "message" => "Ocurrio un problema, intentelo nuevamente."));
		}
	}
}
