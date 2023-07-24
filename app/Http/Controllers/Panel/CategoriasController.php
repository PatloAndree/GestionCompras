<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Categorias;
use App\Models\Unidades;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CategoriasController extends Controller
{
	public function __construct()
	{
		$this->middleware('role:1');
	}

	public function index()
	{
		$data['unidades'] = Unidades::where('status', 1)->get();

		return view('/content/panel/categorias', $data);
	}

	
	public function listarCategorias()
	{
        // $user = Auth::user();
		$categorias = Categorias::where('status', 1)->get();
		// $productos = Categorias::where('status', 1)->get();

		$dataCategorias = [];
		foreach ($categorias as $categoria) {
			$Unidades = Unidades::where('id',$categoria->unidad_categoria)->first();

			$editar = '
						<div class="inline-flex">
							<a href="javascript:;" class="categoria-edit" data-categoriaid="' . $categoria->id . '"><i data-feather="edit" style="width:20px;height:17px;color:#10AC84"></i></a>
						</div>
						<script>
							feather.replace()
						</script>
						';
			$arraycategorias = array(
                'id'=> $categoria->id,
                'nombre_categoria'=> $categoria->nombre_categoria,

                'unidad_categoria'=> $Unidades->nombre_unidad,
                'status'=> $categoria->status,
                'actions' => $editar 

			);
			array_push($dataCategorias, (object)$arraycategorias);
		}
		$dataReturn['data'] = $dataCategorias;
		return json_encode($dataReturn) ;
	}

	public function data(Request $request, Categorias $categoria)
	{
		if ($categoria) {
			echo json_encode(array("sw_error" => 0, "data" => $categoria));

		} else {
			echo json_encode(array("sw_error" => 1, "data" => []));
		}
	}

	public function create(Request $request)
	{

		$validator = Validator::make($request->all(), [
			'categoria_nombre' => 'required|string|max:255',
			'unidad_categoria' => 'required|integer',
		]);
		if ($validator->fails()) {
			echo json_encode(array("sw_error" => 1, "titulo" => "Error", "type" => "error", "message" => $validator->errors()));
		}
		Categorias::create([
			'nombre_categoria'=>$request->categoria_nombre,
			'unidad_categoria'=>$request->unidad_categoria,
		]);

		echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se registro correctamente la categoría"));
	}

	public function update(Request $request , $categoriaId)
	{
		$dataUpdate = array();
		$dataUpdate['nombre_categoria'] 	= $request->nombre_categoriaE;
		$dataUpdate['unidad_categoria'] 	= $request->unidad_nombre;
		$CategoriaUpdate = Categorias::where('id', $categoriaId)->update($dataUpdate);

		if(isset($CategoriaUpdate)){
			echo json_encode(array("sw_error" => 0, "titulo" => "Éxito", "type" => "success", "message" => "Se actualizo correctamente la categoría"));
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


}
