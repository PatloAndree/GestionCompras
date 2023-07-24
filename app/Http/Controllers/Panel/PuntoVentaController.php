<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Categorias;
use App\Models\Productos;
use App\Models\Ventas;
use App\Models\VentasDetalle;
use App\Models\Comprobantes;
use App\Models\Productosdetalles;
use App\Models\Unidades;
use PDF;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class PuntoVentaController extends Controller
{

	public function index()
	{
		$data['unidades'] = Unidades::where('status', 1)->get();
		$data['categorias'] = Categorias::where('status', 1)->orderBy('nombre_categoria','asc')->get();
		// $data['ramdon'] = Str::random(6);
		return view('/content/panel/puntoventaListado', $data);
	}

	public function ventas()
	{
		$data['unidades'] = Unidades::where('status', 1)->get();
		$data['categorias'] = Categorias::where('status', 1)->orderBy('nombre_categoria','asc')->get();
		$data['ramdon'] = Str::random(6);
		return view('/content/panel/puntoventa', $data);
	}

	public function showVenta(Request $request)
	{
		$codigoId = $request->valor;
		$venta = Ventas::where('id',$codigoId)->where('status', 1)->first();
		// print_r($venta);
		// exit;
		$dataProductos = [] ;
		$ventas = VentasDetalle::where('venta_id',$codigoId)->get();
			foreach ($ventas as $producto) {
				$productos= Productos::where('id', $producto->producto_id)->first();
				$venta = Ventas::where('id',$codigoId)->where('status', 1)->first();
		
				$arrayProductos = array(
						'id_venta' 		=> $venta->id,
						'producto_nombre' => $productos->nombre_producto,
						'codigo_venta' => $venta->codigo_venta,
						'fecha_venta' => $venta->fecha_venta,
						'cantidad' => $producto->cantidad,
						'precio' => $producto->precio,
						'precio_total' => $producto->precio_total,
						'subtotal' => $venta->subtotal,
						'comprobante' => $venta->codigo_venta,
						// 'pago_total' => $venta->pago_total,
						// 'pago_total' => $venta->pago_total,
				);
				array_push($dataProductos, $arrayProductos);
				// $dataDetalles[] .= $arrayHojaDetalles;
			}
		// print_r($dataProductos);
		// exit;
		$data['codigo'] = $codigoId;
		$data['venta'] = $venta;
		$data['ventas'] = $ventas;
		$data['productos'] = $dataProductos;

		// return view('/content/panel/puntoventaShow', $data);
		$data['unidades'] = Unidades::where('status', 1)->get();
		$data['categorias'] = Categorias::where('status', 1)->orderBy('nombre_categoria','asc')->get();
		$data['ramdon'] = Str::random(6);
		return view('/content/panel/puntoventaShow', $data);

	}
	
	public function listarVentas()
	{
        // $user = Auth::user();
		$ventas = Ventas::where('status', 1)->get();
		// $productos = Categorias::where('status', 1)->get();

		$dataProductos = [];
		foreach ($ventas as $venta) {
			$comprobantes = Comprobantes::where('id',$venta->comprobante)->first();
			$editar = '
						<div class="inline-flex">
						<a href="'.route("generar.pdf",['valor' => $venta->id]).'" target="_blank" class="venta-edit" data-ventaid=""><i data-feather="printer" style="width:20px;height:17px;color:#344D67"></i></a>
						<a href="'.route("showVenta.venta",['valor' => $venta->id]).'"  class="producto-edit" ><i data-feather="eye" style="width:20px;height:17px;color:#00ABB3"></i></a>
						</div>
						<script>
							feather.replace()
						</script>
						';
			$arrayProductos = array(
                'id'=> $venta->id,
                'codigo_venta'=> $venta->codigo_venta,
                'fecha_venta'=> $venta->fecha_venta,
                'comprobante'=> $comprobantes->nombre_comprobante,
                'subtotal'=> $venta->subtotal,
                'pago_total'=> $venta->pago_total,
                'dni_cliente'=> $venta->dni_cliente,
                'nombres_cliente'=> $venta->nombres_cliente,

                'actions' => $editar 

			);
			array_push($dataProductos, (object)$arrayProductos);
		}
		$dataReturn['data'] = $dataProductos;
		return json_encode($dataReturn) ;
	}

	public function data(Request $request, $producto)
	{
		$producto=Productos::where('id',$producto)->where('status',1)->first();

		if ($producto) {
			echo json_encode(array("sw_error" => 0, "data" => $producto));

		} else {
			echo json_encode(array("sw_error" => 1, "data" => []));
		}
	}

	public function create(Request $request)
	{
		// print_r($request->All());
		// exit;
		$Products = $request->productos;
		if($Products){
				$dataVenta = array();
				$dataVenta['codigo_venta'] = trim($request->compra_codigo);
				$dataVenta['fecha_venta'] = trim($request->compra_fecha);
				$dataVenta['comprobante'] = trim($request->compra_comprobante);
				$dataVenta['subtotal'] = trim($request->compra_monto);
				$dataVenta['pago_total'] = trim($request->compra_monto_total);
				$dataVenta['igv'] = trim($request->igv);
				$dataVenta['dni_cliente'] = trim($request->dni_cliente);
				$dataVenta['nombres_cliente'] = trim($request->nombres_cliente);
			
				if($dataVenta){
					$Ventas = Ventas::create($dataVenta);
					$productos = json_decode($request->productos);
					if (isset($productos)) {
						foreach ($productos as $producto) {
							$insertProducto = array();
							$insertProducto['venta_id'] = $Ventas->id;
							$insertProducto['producto_id'] = $producto->id;
							$insertProducto['cantidad'] = $producto->cantidad;
							$insertProducto['precio'] = $producto->precio;
							$insertProducto['precio_total'] = $producto->precio_total;

							VentasDetalle::create($insertProducto);
							Productos::where('id',$producto->id)->update(['stock_producto'=>$producto->stock]);
						}
					}
				}
		}


		if(isset($Ventas)){
			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se realizó correctamente la venta"));
		}else{
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => "Intentelo de nuevo"));
		}


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
	
	public function search(Request $request)
	{
		$productos = Productos::where('nombre_producto', 'LIKE', '%' . $request->search . '%')->where('status', 1)->get();

		// $productos = Productos::where('nombre_producto', 'LIKE', '%' . $request->search . '%')->orWhere('codbarra', 'LIKE', '%' . $request->search . '%')->where('status', 1)->get();


		$arrayProductos = array();
		foreach ($productos as $producto) {
			array_push($arrayProductos, array("id" => $producto->id, "text" => $producto->nombre_producto , "precio" => $producto->precio_venta));
		}
		echo json_encode(array('results' => $arrayProductos));
	}

	public function generarPdf(Request $request){
		// PDF::loadHTML($html)->setPaper('a4')->setOrientation('landscape')->setOption('margin-bottom', 0)->save('myfile.pdf')
		ini_set('max_execution_time', 300);
		$codigoId = $request->valor;

		$venta = Ventas::where('id',$codigoId)->where('status', 1)->first();
		// print_r($venta);
		// exit;
		$dataProductos = [] ;
		$ventas = VentasDetalle::where('venta_id',$codigoId)->get();
			foreach ($ventas as $producto) {
				$productos= Productos::where('id', $producto->producto_id)->first();
				$venta = Ventas::where('id',$codigoId)->where('status', 1)->first();
		
				$arrayProductos = array(
						'id_venta' 		=> $venta->id,
						'producto_nombre' => $productos->nombre_abrev,
						'codigo_venta' => $venta->codigo_venta,
						'fecha_venta' => $venta->fecha_venta,
						'cantidad' => $producto->cantidad,
						'precio' => $producto->precio_total,
						'subtotal' => $venta->subtotal,
						'comprobante' => $venta->codigo_venta,
						'pago_total' => $venta->pago_total,
						// 'pago_total' => $venta->pago_total,
				);
				array_push($dataProductos, $arrayProductos);
				// $dataDetalles[] .= $arrayHojaDetalles;
			}
		// print_r($dataProductos);
		// exit;
		$data['codigo'] = $codigoId;
		$data['venta'] = $venta;
		$data['ventas'] = $ventas;
		$data['productos'] = $dataProductos;
		// $pdf = PDF::loadView('/content/panel/imprimirBoleta.blade', $data);
		$pdf = PDF::loadView('/content/panel/imprimirBoleta', $data);
		// $dompdf = new Dompdf();
		$pdf->setPaper('b7', 'portrait');
		// return $pdf->stream('ticket.pdf');
		$output = $pdf->output();
		return  new Response($output, 200, [
			'Content-Type' => 'application/pdf',
			'Content-Disposition' =>  'inline; filename="invoice.pdf"',
		]);

	}

}
