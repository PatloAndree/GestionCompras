<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Categorias;
use App\Models\Productos;
use App\Models\Productosdetalles;
use App\Models\Unidades;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class ProductosController extends Controller
{

	public function index()
	{
		$data['unidades'] = Unidades::where('status', 1)->get();
		$data['categorias'] = Categorias::where('status', 1)->orderBy('nombre_categoria','asc')->get();
		return view('/content/panel/productos', $data);
	}
	
	public function listarProductos()
	{
        // $user = Auth::user();
		$productos = Productos::where('status', 1)->get();
		// $productos = Categorias::where('status', 1)->get();

		$dataProductos = [];
		foreach ($productos as $producto) {
			$Categoria = Categorias::where('id',$producto->categoria_producto)->first();
			$editar = '
						<div class="inline-flex">
							<a href="javascript:;" class="producto-edit" data-productoid="' . $producto->id . '"><i data-feather="edit" style="width:20px;height:17px;color:#10AC84"></i></a>
							<a href="javascript:;" class="producto-delete" data-productoid="' . $producto->id . '"><i data-feather="trash" style="width:20px;height:17px;color:#EB455F"></i></a>
						</div>
						<script>
							feather.replace()
						</script>
						';
			$arrayProductos = array(
                'id'=> $producto->id,
                'nombre_producto'=> $producto->nombre_producto,
                'imagen_producto'=> '
				<img src="'.$producto->imagen_producto.'" style="max-width:30px;border-radius:10px">
				',
                'stock_producto'=> $producto->stock_producto,
                'precio_compra'=> $producto->precio_compra,
                'precio_venta'=> $producto->precio_venta,
                // 'fecha_ven_producto'=> $producto->fecha_ven_producto,
                'categoria_producto'=> $Categoria->nombre_categoria,
                'marca_producto'=> $producto->marca_producto,
                'actions' => $editar 

			);
			array_push($dataProductos, (object)$arrayProductos);
		}
		$dataReturn['data'] = $dataProductos;
		return json_encode($dataReturn) ;
	}

	public function data(Request $request, Productos $producto)
	{
		if ($producto) {
			echo json_encode(array("sw_error" => 0, "data" => $producto));

		} else {
			echo json_encode(array("sw_error" => 1, "data" => []));
		}
	}

	public function create(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'marca_producto' => 'required|string|max:255',
			// 'imagen_producto' => 'required|string|max:255',
			'precio_compra' => 'required',
			'precio_venta' => 'required',
			'fecha_ven_producto' => 'required|date',
			// 'categoria_producto' => 'required|:H:i',
			'marca_producto' => 'required|string|max:255'
		]);

		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
		}

		if(isset($request->foto_producto)){
			$imagen = $request->foto_producto->store('public/incidencias');
			$url = Storage::url($imagen);
		}
		if(isset($url)){
			$miUrl = $url;
		}else{
			$miUrl = '/storage/incidencias/imagen-no-disponible.jpg';
		}


		Productos::create([
			'nombre_producto'=>$request->nombre_producto,
			'nombre_abrev'=>$request->nombre_abrev,
			'imagen_producto'=>$miUrl,
			'stock_producto'=>$request->stock_producto,
			'precio_compra'=>$request->precio_compra,
			'precio_venta'=>$request->precio_venta,
			'fecha_ven_producto'=>$request->fecha_ven_producto,
			'categoria_producto'=>$request->categoria_producto,
			'marca_producto'=>$request->marca_producto,
		]);

		echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se registro correctamente la sede"));
	}

	public function update(Request $request , $productoId)
	{

		$dataUpdate = array();

		if(isset($request->foto_producto)){
			$imagen = $request->foto_producto->store('public/incidencias');
			$url = Storage::url($imagen);
			$dataUpdate['imagen_producto'] 		= $url;
		}

		$dataUpdate['nombre_producto'] 		= $request->nombre_producto;
		$dataUpdate['nombre_abrev'] 		= $request->nombre_abrev;
		$dataUpdate['stock_producto'] 		= $request->producto_stock;
		$dataUpdate['precio_compra'] 		= $request->precio_compra;
		$dataUpdate['precio_venta'] 		= $request->precio_venta;
		$dataUpdate['fecha_ven_producto']   = $request->fecha_ven_producto;
		$dataUpdate['categoria_producto']   = $request->categoria_producto;
		$dataUpdate['marca_producto'] 		= $request->marca_producto;
	
		$ProductoUpdate = Productos::where('id', $productoId)->update($dataUpdate);

		if(isset($ProductoUpdate)){
			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se actualizo correctamente el producto"));
		}else{
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => "Intentelo de nuevo"));
		}
	}

	public function delete( $Idproducto)
	{
		$Productos = Productos::where('id',$Idproducto)->update(['status'=>0]);
		if(isset($Productos)){
			echo json_encode(array("sw_error" => 0, "message" => "Se elimino el producto con exito."));
		}else{
			echo json_encode(array("sw_error" => 1, "message" => "No se pudo eliminar, intentelo de nuevo."));

		}
	}
	// public function __construct()
	// {
	// 	$this->middleware('role:1');
	// }

	// public function index()
	// {
	// 	$data['unidades'] = Unidades::where('status', 1)->get();
	// 	$data['categorias'] = Categorias::where('status', 1)->get();
	// 	return view('/content/panel/productos', $data);
	// }

	// public function home()
	// {
	// 	$data['unidades'] = Unidades::where('status', 1)->get();
	// 	$data['categorias'] = Categorias::where('status', 1)->get();
	// 	return view('/content/panel/productosDetalles', $data);
	// }

	// public function list()
	// {
	// 	$productos = Productos::where('status', 1)->orderBy('nombre', 'asc')->get();
	// 	$dataProductos = [];
	// 	foreach ($productos as $producto) {
	// 		$ver = '<div class="d-inline-flex">
	// 							<a href="javascript:;" class="producto-show" data-productoid="' . $producto->id . '"><i data-feather="eye"></i></a>
	// 						  </div> 		
	// 						  ';
	// 		$editar = '<div class="d-inline-flex">
	// 							<a href="javascript:;" class="producto-edit" data-productoid="' . $producto->id . '"><i data-feather="edit"></i></a>
	// 						  </div>
	// 						  ';
	// 		$eliminar = '<div class="d-inline-flex">
	// 							<a href="javascript:;" class="producto-delete" data-productoid="' . $producto->id . '"><i data-feather="trash-2" color="red"></i></a>
	// 						  </div>
	// 						  ';
	// 		$arrayProductos = array(
	// 			"id" => $producto->id,
	// 			"nombre" => $producto->nombre,
	// 			"unidad" => $producto->unidad->nombre,
	// 			"stock" => $producto->stock,
	// 			"actions" => $ver . $editar . $eliminar
	// 		);
	// 		array_push($dataProductos, (object)$arrayProductos);
	// 	}
	// 	$dataReturn['data'] = $dataProductos;
	// 	return json_encode($dataReturn);
	// }

	// public function submit(Request $request)
	// {

		
	// 	$validator = Validator::make($request->all(), [
	// 		'tipo_submit' => 'required|integer',
	// 		'name' => 'required|string',
	// 		'code' => 'nullable|string',
	// 		'unidad' => 'required|integer',
	// 		'sw_topico' => 'required|integer',
	// 		'sw_ambulancia' => 'required|integer',
	// 		'productos' => 'required|array'
	// 	]);
	// 	if ($validator->fails()) {
	// 		echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
	// 		exit;
	// 	}

	// 	if ($request->tipo_submit == 0) { // INSERTAMOS
			
	// 		//'stock' => trim($request->producto_stock),
	// 		$producto = Productos::create([
	// 			'unidad_id' => trim($request->unidad),
	// 			'nombre' => trim($request->name),
	// 			'codbarra' => trim($request->code),
	// 			'topico' => trim($request->sw_topico),
	// 			'ambulancia' => trim($request->sw_ambulancia)
	// 		]);

	// 		//DETALLE DE PRODUCTOS
	// 		Productosdetalles::where('producto_id',$producto->id)->delete();
	// 		$countStock=0;
	// 		foreach ($request->productos as $product) {
	// 			Productosdetalles::create([
	// 				"producto_id"=>$producto->id,
	// 				"cantidad"=>$product['stock'],
	// 				"fecha_vencimiento"=>$product['fecha']
	// 			]);
	// 			$countStock=$countStock+$product['stock'];
				
	// 		}
			
	// 		$producto->update(['stock'=>$countStock]);
	// 		echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se registro el producto."));
	// 	} elseif ($request->tipo_submit > 0) { // ACTUALIZAMOS
	// 		$producto = Productos::where('id', $request->tipo_submit)->first();
	// 		if ($producto) {
	// 			try {
	// 				$producto->update([
	// 					'unidad_id' => trim($request->unidad),
	// 					'nombre' => trim($request->name),
	// 					'codbarra' => trim($request->code),
	// 					'topico' => trim($request->sw_topico),
	// 					'ambulancia' => trim($request->sw_ambulancia)
	// 				]);

	// 				//DETALLE DE PRODUCTOS
	// 				Productosdetalles::where('producto_id',$producto->id)->delete();
	// 				$countStock=0;
	// 				foreach ($request->productos as $product) {
	// 					Productosdetalles::create([
	// 						"producto_id"=>$producto->id,
	// 						"cantidad"=>$product['stock'],
	// 						"fecha_vencimiento"=>$product['fecha']
	// 					]);
	// 					$countStock=$countStock+$product['stock'];
	// 				}
	// 				$producto->update(['stock'=>$countStock]);

	// 				echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se actualizo el producto."));
	// 			} catch (\Illuminate\Database\QueryException $exception) {
	// 				$errorInfo = $exception->errorInfo;
	// 				echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $errorInfo));
	// 			}
	// 		} else {
	// 			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => 'Ocurrio un problema, no encontramos el producto que quiere modificar.'));
	// 		}
	// 	} else {
	// 		echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => 'Ocurrio un problema, no encontramos el producto que quiere modificar.'));
	// 	}
	// }

	// public function data(Request $request, $producto)
	// {
	// 	$producto=Productos::with('detalles')->where('id',$producto)->where('status',1)->first();
		
	// 	if ($producto) {
	// 		echo json_encode(array("sw_error" => 0, "data" => $producto));
	// 	} else {
	// 		echo json_encode(array("sw_error" => 1, "data" => []));
	// 	}
	// }

	// public function delete(Request $request, Productos $producto)
	// {
	// 	if ($producto) {
	// 		$productoData = [];
	// 		$productoData['status'] = '0';
	// 		$producto->update($productoData);
	// 		echo json_encode(array("sw_error" => 0, "message" => "Se elimino la categoria."));
	// 	} else {
	// 		echo json_encode(array("sw_error" => 1, "message" => "Ocurrio un problema, intentelo nuevamente."));
	// 	}
	// }

	// public function search(Request $request)
	// {
	// 	$productos = Productos::where('nombre', 'LIKE', '%' . $request->search . '%')->orWhere('codbarra', 'LIKE', '%' . $request->search . '%')->where('status', 1)->get();
	// 	$arrayProductos = array();
	// 	foreach ($productos as $producto) {
	// 		array_push($arrayProductos, array("id" => $producto->id, "text" => $producto->nombre));
	// 	}
	// 	echo json_encode(array('results' => $arrayProductos));
	// }


}
