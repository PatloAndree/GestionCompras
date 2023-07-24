<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Asignacionesdiarias;
use App\Models\Categorias;
use App\Models\Compras;
use App\Models\Comprasdetalles;
use App\Models\Productosdetalles;
use App\Models\Productos;
use App\Models\Proveedores;
use App\Models\Unidades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ComprasController extends Controller
{
	public function __construct()
	{
		$this->middleware('role:1');
	}

	public function index()
	{
		return view('/content/panel/compras');
	}

	public function nuevo()
	{
		$data['proveedores'] = Proveedores::where('status', 1)->orderBy('nombre', 'asc')->get();
		return view('/content/panel/comprasNueva', $data);
	}

	public function list()
	{
		$compras = Compras::where('status', 1)->orderBy('fecha', 'asc')->get();
		$dataProveedores = [];
		foreach ($compras as $compra) {
			$ver = '<div class="d-inline-flex">
								<a href="javascript:;" class="compra-show" data-compraid="' . $compra->id . '"><i data-feather="eye"></i></a>
							  </div>
							  ';
			$editar = '<div class="d-inline-flex">
								<a href="javascript:;" class="compra-edit" data-compraid="' . $compra->id . '"><i data-feather="edit"></i></a>
							  </div>
							  ';
			$eliminar = '<div class="d-inline-flex">
								<a href="javascript:;" class="compra-delete" data-compraid="' . $compra->id . '"><i data-feather="trash-2" color="red"></i></a>
							  </div>
							  ';
			$arrayProductos = array(
				"nombre" => "julio ",
				"fecha" => $compra->fecha,
				"cantidad_productos" => $compra->productos,
				"precio"=>1,
				// "precio" => collect($compra->productos)->map(function ($product, $key) {
				// 	return $product->producto_preciocompra * $product->producto_cantidad;
				// })->sum(),
				"actions" => $ver . $editar . $eliminar
			);
			array_push($dataProveedores, (object)$arrayProductos);
		}
		$dataReturn['data'] = $dataProveedores;
		return json_encode($dataReturn);
	}

	public function submit(Request $request)
	{	
		
		$validator = Validator::make($request->all(), [
			'compra_proveedor' => 'required|integer',
			'compra_fecha' => 'required|date_format:Y-m-d',
			'compra_codigo' => 'nullable|string|max:255',
			'compra_comprobante' => 'nullable|string|max:255',
			'compra_adicional' => 'required|string',
			'compra_monto' => 'required',
			'productos' => 'required|json'
		]);

		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
			exit;
		}

		//if ($request->tipo_submit == 0) { // INSERTAMOS
		$userAuth = Auth::user();
		$dataCompra = array();

		$dataCompra['user_id'] = $userAuth->id;
		$dataCompra['proveedor_id'] = $request->compra_proveedor;
		$dataCompra['fecha'] = $request->compra_fecha;

		if (isset($request->compra_codigo) && trim($request->compra_codigo) != '') {
			$dataCompra['codigocompra'] = $request->compra_fecha;
		}
		if (isset($request->compra_adicional) && trim($request->compra_adicional) != '') {
			$dataCompra['datos'] = $request->compra_adicional;
		}
		if (isset($request->compra_comprobante) && trim($request->compra_comprobante) != '') {
			$dataCompra['documento'] = $request->compra_comprobante;
		}
		$dataCompra['status'] = 1;

		$compra = Compras::create($dataCompra);
		if ($compra) {
			foreach (json_decode($request->productos) as $producto) {
				$detalleCompra = Comprasdetalles::insert([
					'compra_id' => $compra->id,
					'producto_id' => $producto->id,
					'producto_cantidad' => $producto->cantidad,
					'producto_preciocompra' => $producto->precio,
					'producto_fechavencimiento' => $producto->fecha
				]);
				$productoReal = Productos::where('id', $producto->id)->where('status', '1')->first();
				$productoReal->stock = $productoReal->stock + $producto->cantidad;
				$productoReal->save();

				$productoDetalle = Productosdetalles::insert([
					'producto_id' => $producto->id,
					'cantidad' => $producto->cantidad,
					'fecha_vencimiento' => $producto->fecha
				]);
			}
			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se registro la compra."));
		} else {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => 'ocurrio un problema, intenelo nuevamente.'));
		}
	}

	public function data(Request $request, Productos $producto)
	{
		if ($producto) {
			echo json_encode(array("sw_error" => 0, "data" => $producto));
		} else {
			echo json_encode(array("sw_error" => 1, "data" => []));
		}
	}

	public function delete(Request $request, Productos $producto)
	{
		if ($producto) {
			$productoData = [];
			$productoData['status'] = '0';
			$producto->update($productoData);
			echo json_encode(array("sw_error" => 0, "message" => "Se elimino la categoria."));
		} else {
			echo json_encode(array("sw_error" => 1, "message" => "Ocurrio un problema, intentelo nuevamente."));
		}
	}
}
