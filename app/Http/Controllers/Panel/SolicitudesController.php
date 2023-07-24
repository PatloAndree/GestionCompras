<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Asignacionesdiarias;
use App\Models\Categorias;
use App\Models\Productos;
use App\Models\ProductosDetalle;
use App\Models\Productosdetalles;
use App\Models\Sedesproductos;
use App\Models\Solicitudes;
use App\Models\Solicitudesdetalles;
use App\Models\Unidades;
use Carbon\Carbon;
use PDF;
use App\Models\User;
use App\Models\Sedes;
use App\Models\Ubigeo;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SolicitudesController extends Controller
{
	public function index()
	{
		$data = array();
		return view('/content/panel/solicitudes', $data);
	}
	public function list()
	{
		$user = Auth::user();
		$solicitudes = Solicitudes::orderBy('created_at', 'desc');
		if (Auth::user()->type != 1) {
			$solicitudes = $solicitudes->where('user_id', $user->id);
		}
		$solicitudes = $solicitudes->get();
		$dataSolicitudes = [];
		foreach ($solicitudes as $solicitud) {
			$estado = '';
			if ($solicitud->status == 1) {
				$estado = '<span class="badge bg-success">Completado</span>';
			} else if ($solicitud->status == 2) {
				$estado = '<span class="badge bg-warning">Pendiente</span>';
			} else if ($solicitud->status == 3) {
				$estado = '-3';
			} else if ($solicitud->status == 4) {
				$estado = '-4';
			}

			$ver = '<div class="d-inline-flex">
								<a href="' . route("solicitud.show", [$solicitud->id]) . '" ><i data-feather="eye"></i></a>
							  </div>
							  ';

			$admin = '';
			if (Auth::user()->type == 1 && $solicitud->status==2) {
				$admin = '<div class="d-inline-flex">
								<a href="' . route("solicitud.attend", [$solicitud->id]) . '" ><i data-feather="edit"></i></a>
							  </div>';
			}else if($solicitud->status==2){
				$admin = '<div class="d-inline-flex">
								<a href="' . route("solicitud.edit", [$solicitud->id]) . '" ><i data-feather="edit"></i></a>
							  </div>';
			}

			$arrayUsuario = array(
				"solicitante" => $solicitud->usuario->name . ' ' . $solicitud->usuario->last_name,
				"sede" => $solicitud->sede->name,
				"cantidad_productos" => count($solicitud->productos),
				"estado" => $estado,
				"actions" => $ver . $admin
			);
			array_push($dataSolicitudes, (object)$arrayUsuario);
		}
		$dataReturn['data'] = $dataSolicitudes;
		return json_encode($dataReturn);
	}

	// public function list_products()
	// {
	// 	$productos = Productos::where('status', 1)->orderBy('nombre', 'asc')->get();
	// 	$dataProductos = [];
	// 	foreach ($productos as $producto) {

	// 		$editar = '<div class="d-inline-flex">
	// 							<a href="javascript:;" class="producto-edit" data-productoid="' . $producto->id . '"><i data-feather="add"></i></a>
	// 						  </div>
	// 						  ';
	// 		$eliminar = '<div class="d-inline-flex">
	// 							<a href="javascript:;" class="producto-delete" data-productoid="' . $producto->id . '"><i data-feather="trash-2" color="red"></i></a>
	// 						  </div>
	// 						  ';
	// 		$arrayProductos = array(
	// 			"id" => $producto->codigo,
	// 			"nombre" => $producto->nombre,
	// 			"actions" => $ver . $editar . $eliminar
	// 		);
	// 		array_push($dataProductos, (object)$arrayProductos);
	// 	}
	// 	$dataReturn['data'] = $dataProductos;
	// 	print_r($dataProductos);
	// 	die();
	// 	return json_encode($dataReturn);
	// }

	public function show(Solicitudes $solicitud)
	{

		$data['categorias'] = Categorias::where('status', 1)->get();
		$data['unidades'] = Unidades::where('status', 1)->get();
		$data['productos'] = Productos::where('status', 1)->where('stock', '>', 0)->get();
		$data['solicitud'] = $solicitud;
		$sede = Sedes::where('id', $solicitud->sede_id)->first();
		$data['sede'] = $sede->name;
		$sede = Sedes::where('id', $solicitud->sede_id)->first();
		$user = User::where('id',$solicitud->user_id)->first();
		$data['user'] = $user->name.'-'.$user->last_name;

		return view('/content/panel/solicitudes_show', $data);
	}

	public function editview(Solicitudes $solicitud){
		$data['categorias'] = Categorias::where('status', 1)->get();
		$data['unidades'] = Unidades::where('status', 1)->get();
		$data['productos'] = Productos::where('status', 1)->where('stock', '>', 0)->get();
		$data['solicitud'] = $solicitud;
		return view('/content/panel/solicitudes_editar', $data);
	}

	// public function attend(Solicitudes $solicitud)
	// {
	// 	$data = array();
	// 	// $productos = Productos::where('status', 1)->orderBy('nombre', 'asc')->get();
	// 	// echo($productos);
	// 	// die();

	// 	$data = array();
	// 	$data['categorias'] = Categorias::where('status', 1)->get();
	// 	$data['unidades'] = Unidades::where('status', 1)->get();
	// 	$data['solicitud'] = $solicitud;
	// 	$productos = array();
	// 	foreach ($solicitud->productos as $producto) {
	// 		$dataProducto = Productos::find($producto->producto_id);
	// 		$producto_arr = array();
	// 		$producto_arr['id'] = $producto->producto_id;
	// 		$producto_arr['name'] = $dataProducto->nombre;
	// 		$producto_arr['stock'] = $dataProducto->stock;
	// 		$producto_arr['cantidad_solicitada'] = $producto->cantidad_solicitada;
	// 		array_push($productos, $producto_arr);
	// 	}
	// 	$data['solicitudProductos'] = json_decode(json_encode($productos, true));

	// 	return view('/content/panel/solicitudes_attend', $data);
	// }

	public function listaProductos()
	{
		$data = array();
		$productos = Productos::where('status', 1)->get();
		// print_r($productos);
		// die();
		$productes = array();
		foreach ($productos as $producto) {

			$editar = '<div class="d-inline-flex">
								<a href="javascript:;" class="producto-edit" data-productoid="' . $producto->id . '"><i data-feather="plus"></i></a>
							  </div>
							  ';
			$eliminar = '<div class="d-inline-flex">
								<a href="javascript:;" class="producto-delete" data-productoid="' . $producto->id . '"><i data-feather="trash-2" color="red"></i></a>
							  </div>
							  ';
			$producto_arr = array(
				"id" => $producto->id,
				"name" => $producto->nombre,
				// "stock" => $producto->stock,
				"actions" =>  $editar . $eliminar

			);
			// $producto_arr['id'] = $producto->id;
			// $producto_arr['name'] = $producto->nombre;
			// $producto_arrr['actions'] = $ver . $editar . $eliminar;

			// $producto_arr['stock'] = $dataProducto->stock;
			// $producto_arr['cantidad_solicitada'] = $producto->cantidad_solicitada;
			array_push($productes, (object)$producto_arr);
		}
		$dataReturn['data'] = $productes;
		return json_encode($dataReturn);
	}


	public function attend($solicitud)
	{
		$data = array();

		$data['solicitud'] = Solicitudes::where('id', $solicitud)->where('status', 2)->first();
		if($data['solicitud']){
			$data['categorias'] = Categorias::where('status', 1)->get();
			$data['unidades'] = Unidades::where('status', 1)->get();
			$data['productos'] = Productos::selectRaw('productos.*,productosdetalles.fecha_vencimiento, sum(productosdetalles.cantidad) as total_stock')->join('productosdetalles', 'productos.id', '=', 'productosdetalles.producto_id')->havingRaw('sum(productosdetalles.cantidad) > ?', [0])->where('productos.status', 1)->groupBy('productos.id')->get();
			$data['solicitudDetalles'] = $data['solicitud']->productos;
			return view('/content/panel/solicitudes_attend', $data);
		}else{
			abort(404);
		}
	}

	public function nuevo()
	{
		$data = array();
		$data['categorias'] = Categorias::where('status', 1)->get();
		$data['unidades'] = Unidades::where('status', 1)->get();
		$data['productos'] = Productos::selectRaw('productos.*,productosdetalles.fecha_vencimiento, sum(productosdetalles.cantidad) as total_stock')->join('productosdetalles', 'productos.id', '=', 'productosdetalles.producto_id')->havingRaw('sum(productosdetalles.cantidad) > ?', [0])->where('productos.status', 1)->groupBy('productos.id')->get();
		
		return view('/content/panel/solicitudes_nuevo', $data);
	}


	public function search(Request $request)
	{
		$queryProducto = Productos::where('status', 1);
		if (trim($request->textoSearch) != '') {
			$queryProducto = $queryProducto->where('nombre', 'LIKE', '%' . $request->textoSearch . '%')->orWhere('codbarra', 'LIKE', '%' . $request->textoSearch . '%');
		}
		if (trim($request->unidad) != '') {
			$queryProducto = $queryProducto->where('unidad_id', $request->unidad);
		}
		$productos = $queryProducto->groupBy('productos.id')->get();

		return $productos;
	}
	public function submit(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'productos' => 'required|array',
			'solicitud_note' => 'nullable|string'
		]);

		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
			exit;
		}
		$userAuth = Auth::user();

		$personalAsignadoSede = Asignacionesdiarias::where('usuario_id', $userAuth->id)->where('fecha_asignada', date('Y-m-d'))->first();
		if ($personalAsignadoSede) {
			$dataSolicitud = array();

			$dataSolicitud['user_id'] = $userAuth->id;
			$dataSolicitud['sede_id'] = $personalAsignadoSede->sede_id;

			if (isset($request->note) && trim($request->note) != '') {
				$dataSolicitud['note'] = $request->note;
			}

			$dataSolicitud['status'] = 2;

			$solicitud = Solicitudes::create($dataSolicitud);
			if ($solicitud) {
				foreach ($request->productos as $producto) {
					$detalleSolicitud = Solicitudesdetalles::insert([
						'solicitud_id' => $solicitud->id,
						'producto_id' => $producto['id'],
						'cantidad_solicitada' => $producto['cantidad'],
						'cantidad_entregada' => '0',
						'status' => '2'
					]);
				}
				echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se registro la solicitud.","code"=>$solicitud->id));
			} else {
				echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => 'ocurrio un problema, intenelo nuevamente.',"code"=>"0"));
			}
		} else {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => 'No cuentas con una sede asignada para el dia de hoy.',"code"=>"0"));
		}

		//if ($request->tipo_submit == 0) { // INSERTAMOS


	}

	public function modificar(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'solicitud_id' => 'required|integer',
			'productos' => 'required|array',
			'note' => 'nullable|string'
		]);

		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
			exit;
		}

		$solicitud = Solicitudes::where('id', $request->solicitud_id)->where("status", Solicitudes::PENDIENTE)->first();
		if ($solicitud) {

			Solicitudesdetalles::where('solicitud_id',$solicitud->id)->delete();
			foreach ($request->productos as $producto) {
				Solicitudesdetalles::insert([
					'solicitud_id' => $solicitud->id,
					'producto_id' => $producto['id'],
					'cantidad_solicitada' => $producto['cantidad'],
					'cantidad_entregada' => '0',
					'status' => '2'
				]);
			}

			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se registro la solicitud."));
		} else {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => "No se encontro la solicitud."));
		}
	}

	public function finalizar(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'solicitud_id' => 'required|integer',
			'productos' => 'required|array',
			'note' => 'nullable|string'
		]);

		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
			exit;
		}

		//obtenemos la solicitud

		$solicitud = Solicitudes::where('id', $request->solicitud_id)->where("status", Solicitudes::PENDIENTE)->first();
		//
		if ($solicitud) {
			foreach ($request->productos as $producto) {
				if ($producto['type'] == 'nuevo') {
					$detalleSolicitud = Solicitudesdetalles::insert([
						'solicitud_id' => $solicitud->id,
						'producto_id' => $producto['id'],
						'cantidad_solicitada' => 0,
						'admin_add' => 1,
						'cantidad_entregada' => $producto['cantidad'],
						'status' => 1
					]);
				}
				//NUEVO	

				//DESCONTAMOS DE PRODUCTOSDETALLES
				$products = Productosdetalles::where('producto_id',$producto['id'])->where('cantidad', '>', 0)->orderBy('fecha_vencimiento','asc')->get();

				$total_descontado = 0;

				foreach ($products as $product) {
					$descuentoActual=0;
					if ($product->cantidad - $producto['cantidad'] >= 0) {
						$product->cantidad -= $producto['cantidad'];
						$total_descontado = $producto['cantidad'];
						$descuentoActual= $producto['cantidad'];
						//INSERTAMOS A LA SEDE
						$sedesproductos=Sedesproductos::where("sede_id",$solicitud->sede_id)->where("producto_id",$producto['id'])->where('fecha_vencimiento',$product->fecha_vencimiento)->first();
						if($sedesproductos){
							$sedesproductos->cantidad+=$descuentoActual;
							$sedesproductos->save();
						}else{
							Sedesproductos::create([
								"sede_id"=>$solicitud->sede_id,
								"producto_id"=>$producto['id'],
								"cantidad"=>$descuentoActual,
								"fecha_vencimiento"=>$product->fecha_vencimiento
							]);
						}
						break;
					} else {
						$total_descontado += $product->cantidad;
						$descuentoActual= $product->cantidad;
						$product->cantidad = 0;
						//INSERTAMOS A LA SEDE

						$sedesproductos=Sedesproductos::where("sede_id",$solicitud->sede_id)->where("producto_id",$producto['id'])->where('fecha_vencimiento',$product->fecha_vencimiento)->first();
						if($sedesproductos){
							$sedesproductos->cantidad+=$descuentoActual;
							$sedesproductos->save();
						}else{
							Sedesproductos::create([
								"sede_id"=>$solicitud->sede_id,
								"producto_id"=>$producto['id'],
								"cantidad"=>$descuentoActual,
								"fecha_vencimiento"=>$product->fecha_vencimiento
							]);
						}
					}
					
					

					if ($total_descontado == $producto['cantidad']) {
						break;
					}
				}
				
				$products->each->save();
				Solicitudesdetalles::where('solicitud_id',$solicitud->id)->where('producto_id',$producto['id'])->update(["status"=>1,"cantidad_entregada"=>$producto['cantidad']]);
				

				//MODIFICAMOS DE SOLICITUDES DETALLES
			}
			
			if(isset($request->note)){
				$solicitud->note_final = $request->note;
			}
			$solicitud->fecha_atencion = date("Y-m-d");
			$solicitud->status = 1;
			$solicitud->save();
			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Solicitud atendida.","code"=>$solicitud->id));
		} else {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => "No se encontro la solicitud.","code"=>"0"));
		}
	}

	public function pdf(Solicitudes $solicitud){
		ini_set('max_execution_time', 300);
		$data['solicitud'] = $solicitud;
		$sede = Sedes::where('id', $solicitud->sede_id)->first();
		$data['sede'] = $sede->name;
		$sede = Sedes::where('id', $solicitud->sede_id)->first();
		$user = User::where('id',$solicitud->user_id)->first();
		$data['user'] = $user->name.'-'.$user->last_name;
		$pdf = PDF::loadView('/content/panel/solicitudpdf', $data);
		return $pdf->download('archivo.pdf');

	}
}
