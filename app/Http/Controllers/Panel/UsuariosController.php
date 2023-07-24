<?php

namespace App\Http\Controllers\Panel;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Sedes;
use App\Models\User;
use App\Models\Usersdocuments;
use App\Models\Usersedes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UsuariosController extends Controller
{
	public function __construct()
	{
		$this->middleware('role:1');
	}
	public function index()
	{
		return view('/content/panel/usuarios');
	}

	public function show($user_id = '0')
	{
		
		ini_set('max_execution_time', 180);
		$user = User::where('id', $user_id)->where('status', 1)->first();
		$sedes = Sedes::where('status', 1)->get();
		$sedes_arr = array();
		foreach ($sedes as $sede) {
			array_push(
				$sedes_arr,
				array(
					"id" => $sede->id,
					"name" => $sede->name,
					"pais" => $sede->pais->nombre_ubigeo,
					"departamento" => $sede->departamento->nombre_ubigeo,
					"provincia" => $sede->provincia->nombre_ubigeo,
					"distrito" => $sede->distrito->nombre_ubigeo
				)
			);
		}
		if ($user) {
			$breadcrumbs = [
				['link' => "panel/usuarios", 'name' => "Usuarios"], ['name' => "Edición de usuario"]
			];
			$data['user_id'] = $user->id;
			$fechaNacimiento = Carbon::createFromFormat('Y-m-d', $user->date_of_birth);
			$fechaContratacion = Carbon::createFromFormat('Y-m-d', $user->date_of_hiring);
			$dataUsuarios = array();
			$dataUsuarios['id'] = $user->id;
			$dataUsuarios["archivos"] = $user->archivos;

			$arr_sedeuser = [];
			foreach ($user->sedes as $usersede) {
				array_push($arr_sedeuser, $usersede->sede_id);
			}
			
			$dataUsuarios["sedes"] = $arr_sedeuser;
			$dataUsuarios['document_id'] = $user->document_id;
			$dataUsuarios['name'] = $user->name;
			$dataUsuarios['last_name'] = $user->last_name;
			$dataUsuarios['number_document'] = $user->number_document;
			$dataUsuarios['date_of_birth'] = $fechaNacimiento->format('Y-m-d');
			$dataUsuarios['date_of_hiring'] = $fechaContratacion->format('Y-m-d');
			$dataUsuarios['sex'] = $user->sex;
			$dataUsuarios['address'] = $user->address;
			$dataUsuarios['phone'] = $user->phone;
			$dataUsuarios['cuentabancaria'] = $user->cuentabancaria;
			$dataUsuarios['cuentainterbancaria'] = $user->cuentainterbancaria;
			$dataUsuarios['email'] = $user->email;
			$dataUsuarios['type'] = $user->type;
			$dataUsuarios['factor'] = $user->factor;
			$dataUsuarios['sw_factor_variant'] = $user->sw_factor_variant;
			$dataUsuarios['factor_variant'] = $user->factor_variant;
			$dataUsuarios['activo'] = $user->activo;

			$data['user'] = $dataUsuarios;
		} else if ($user_id == '0') {
			$breadcrumbs = [
				['link' => "panel/usuarios", 'name' => "Usuarios"], ['name' => "Creación de usuario"]
			];
			$data['user_id'] = 0;
		} else {
			return abort(404);
		}

		$data['sedes'] = $sedes_arr;
		$data['breadcrumbs'] = $breadcrumbs;
		return view('/content/panel/usuario', $data);
	}

	public function create(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'user_name' => 'required|string|max:255',
			'user_lastname' => 'required|string|max:255',
			'user_document' => 'required|integer',
			'user_numbredocument' => 'required',
			'user_dateofbirth' => 'date_format:Y-m-d',
			'user_hiring' => 'date_format:Y-m-d',
			'user_sex' => 'required|integer',
			'email' => 'required|string|email|max:255|unique:users',
			'user_type' => 'required|integer',
			'user_factor' => 'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
			'user_address' => 'required|string',
			'user_phone' => 'required|integer'
		]);

		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
		}

		$dataUser = array();
		$dataUser['document_id'] = trim($request->user_document);
		$dataUser['name'] = trim($request->user_name);
		$dataUser['last_name'] = trim($request->user_lastname);
		$dataUser['number_document'] = trim($request->user_numbredocument);
		$dataUser['date_of_birth'] = trim($request->user_dateofbirth);
		$dataUser['date_of_hiring'] = trim($request->user_hiring);
		$dataUser['sex'] = trim($request->user_sex);
		$dataUser['address'] = trim($request->user_address);
		$dataUser['phone'] = trim($request->user_phone);
		$dataUser['email'] = trim($request->email);
		$dataUser['type'] = trim($request->user_type);
		$dataUser['factor'] = trim($request->user_factor);
		$dataUser['password'] = Hash::make(trim($request->user_numbredocument));

		if (trim($request->user_cuentabancaria) != '') {
			$dataUser['cuentabancaria'] = trim($request->user_cuentabancaria);
		}
		if (trim($request->user_cuentainterbancaria) != '') {
			$dataUser['cuentainterbancaria'] = trim($request->user_cuentainterbancaria);
		}

		try {
			$user = User::create($dataUser);
			if (isset($request->sedesusuarios)) {
				foreach ($request->sedesusuarios as $sede) {
					$dataInsertSede = array();
					$dataInsertSede['user_id'] = $user->id;
					$dataInsertSede['sede_id'] = $sede;
					Usersedes::create($dataInsertSede);
				}
			}
			if ($request->hasfile('user_documents')) {
				foreach ($request->file('user_documents') as $key => $file) {

					$imageName = 'user_archive_' . time() . $key . '.' . $file->getClientOriginalExtension();
					$path = $file->storeAs('storage/files', $imageName);
					//$name = $file->getClientOriginalName();

					$titulo =  $file->getClientOriginalName();
					$extencion = $file->getClientOriginalExtension();
					$archivo = $path;

					Usersdocuments::insert(array("user_id" => $user->id, "titulo" => $titulo, "extencion" => $extencion, "archivo" => $archivo));
				}
			}
			
			Helper::sendBienvenidaUser($user->id);
			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se registro correctamente el usuario"));
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorInfo = $exception->errorInfo;
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $errorInfo));
		}
	}

	public function list()
	{
		$usuarios = User::where('status', 1)->get();
		$dataUsuarios = [];
		foreach ($usuarios as $usuario) {
			$fechaNacimiento = Carbon::createFromFormat('Y-m-d', $usuario->date_of_birth);
			$role = '<span class="badge badge-glow bg-dark">SIN ASIGNAR</span>';
			if ($usuario->type == 1) {
				$role = '<span class="badge bg-info">Administrador</span>';
			} elseif ($usuario->type == 5) {
				$role = '<span class="badge bg-info">Call center</span>';
			} elseif ($usuario->type == 2) {
				$role = '<span class="badge bg-info">Enfermero</span>';
			} elseif ($usuario->type == 3) {
				$role = '<span class="badge bg-info">Doctor</span>';
			} elseif ($usuario->type == 4) {
				$role = '<span class="badge bg-info">Conductor</span>';
			} elseif ($usuario->type == 6) {
				$role = '<span class="badge bg-info">Supervisor</span>';
			}
			$arrayUsuario = array(
				"nombres" => $usuario->name . ' ' . $usuario->last_name,
				"documento" => $usuario->document->short_name . ' : ' . $usuario->number_document,
				"nacimiento" => $fechaNacimiento->format('d/m/Y'),
				"correo" => $usuario->email,
				"telefono" => $usuario->phone,
				"role" => $role,
				"actions" => '<div class="d-inline-flex">
								<a href="' . route("usuario.show", $usuario->id) . '"><i data-feather="eye"></i></a>
							  </div>
							  <div class="d-inline-flex">
								<a href="javascript:;" class="user-delete" data- ="' . $usuario->id . '" data-nombre="' . $usuario->name . '"><i data-feather="trash-2" color="red"></i></a>
							  </div>'
			);
			array_push($dataUsuarios, (object)$arrayUsuario);
		}
		$dataReturn['data'] = $dataUsuarios;
		return json_encode($dataReturn);
	}

	public function delete(Request $request, User $user)
	{
		$userData = [];
		$userData['status'] = '0';
		$user->update($userData);
		echo json_encode(array("sw_error" => 0, "message" => "Se elimino el usuario."));
	}

	public function data(Request $request, User $user)
	{
		$dataUsuarios = array();
		$fechaNacimiento = Carbon::createFromFormat('Y-m-d', $user->date_of_birth);
		$fechaContratacion = Carbon::createFromFormat('Y-m-d', $user->date_of_hiring);
		$dataUsuarios['id'] = $user->id;
		$dataUsuarios["archivos"] = $user->archivos;
		$dataUsuarios['document_id'] = $user->document_id;
		$dataUsuarios['name'] = $user->name;
		$dataUsuarios['last_name'] = $user->last_name;
		$dataUsuarios['number_document'] = $user->number_document;
		$dataUsuarios['date_of_birth'] = $fechaNacimiento->format('Y-m-d');
		$dataUsuarios['date_of_hiring'] = $fechaContratacion->format('Y-m-d');
		$dataUsuarios['sex'] = $user->sex;
		$dataUsuarios['address'] = $user->address;
		$dataUsuarios['phone'] = $user->phone;
		$dataUsuarios['cuentabancaria'] = $user->cuentabancaria;
		$dataUsuarios['cuentainterbancaria'] = $user->cuentainterbancaria;
		$dataUsuarios['email'] = $user->email;
		$dataUsuarios['type'] = $user->type;
		$dataUsuarios['factor'] = $user->factor;
		$dataUsuarios['sw_factor_variant'] = $user->sw_factor_variant;
		$dataUsuarios['factor_variant'] = $user->factor_variant;

		echo json_encode(array("sw_error" => 0, "user" => $dataUsuarios));
	}

	public function update(Request $request, User $user)
	{
		
		$validator = Validator::make($request->all(), [
			'user_name' => 'required|string|max:255',
			'user_lastname' => 'required|string|max:255',
			'user_document' => 'required|integer',
			'user_numbredocument' => 'required',
			'user_dateofbirth' => 'date_format:Y-m-d',
			'user_hiring' => 'date_format:Y-m-d',
			'user_sex' => 'required|integer',
			'user_type' => 'required|integer',
			'user_factor' => 'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
			'user_address' => 'required|string',
			'user_phone' => 'required|integer',
			'user_sw_factor_variant' => 'nullable|string',
			'user_factor_variant' => 'nullable|required_if:user_sw_factor_variant,on|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/'
		]);

		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
			exit;
		}
		
		$dataUpdate = array();
		$dataUpdate['document_id'] = trim($request->user_document);
		$dataUpdate['name'] = trim($request->user_name);
		$dataUpdate['last_name'] = trim($request->user_lastname);
		$dataUpdate['number_document'] = trim($request->user_numbredocument);
		$dataUpdate['date_of_birth'] = trim($request->user_dateofbirth);
		$dataUpdate['date_of_hiring'] = trim($request->user_hiring);
		$dataUpdate['sex'] = trim($request->user_sex);
		$dataUpdate['address'] = trim($request->user_address);
		$dataUpdate['phone'] = trim($request->user_phone);
		$dataUpdate['type'] = trim($request->user_type);
		$dataUpdate['factor'] = trim($request->user_factor);
		$dataUpdate['activo'] = trim($request->chekiado);

		if (isset($request->user_sw_factor_variant)) {
			$dataUpdate['sw_factor_variant'] = 1;
			$dataUpdate['factor_variant'] = trim($request->user_factor_variant);
		} else {
			$dataUpdate['sw_factor_variant'] = 0;
		}

		if (trim($request->user_cuentabancaria) != '') {
			$dataUpdate['cuentabancaria'] = trim($request->user_cuentabancaria);
		} else {
			$dataUpdate['cuentabancaria'] = NULL;
		}
		if (trim($request->user_cuentainterbancaria) != '') {
			$dataUpdate['cuentainterbancaria'] = trim($request->user_cuentainterbancaria);
		} else {
			$dataUpdate['cuentainterbancaria'] = NULL;
		}

		try {
			$user->update($dataUpdate);
			Usersedes::where('user_id', $user->id)->delete();
			if (isset($request->sedesusuarios)) {
				foreach ($request->sedesusuarios as $sede) {
					$dataInsertSede = array();
					$dataInsertSede['user_id'] = $user->id;
					$dataInsertSede['sede_id'] = $sede;
					Usersedes::create($dataInsertSede);
				}
			}
			if ($request->hasfile('user_documents')) {
				foreach ($request->file('user_documents') as $key => $file) {

					$imageName = 'user_archive_' . time() . $key . '.' . $file->getClientOriginalExtension();
					$path = $file->storeAs('storage/files', $imageName);
					//$name = $file->getClientOriginalName();

					$titulo =  $file->getClientOriginalName();
					$extencion = $file->getClientOriginalExtension();
					$archivo = $path;

					Usersdocuments::insert(array("user_id" => $user->id, "titulo" => $titulo, "extencion" => $extencion, "archivo" => $archivo));
				}
			}
			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se actualizo el usuario."));
		} catch (\Illuminate\Database\QueryException $exception) {
			$errorInfo = $exception->errorInfo;
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $errorInfo));
		}
	}

	public function sendbienvenida(Request $request, User $user)
	{
		$send=Helper::sendBienvenidaUser($user->id);
		if($send){
			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se envio el mensaje."));
		}else{
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => "No se envio el mensaje."));
		}
	}
}
