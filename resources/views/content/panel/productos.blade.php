@extends('layouts/contentLayoutMaster')
@section('title', 'Productos')

@section('page-style')
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/multiselect/multi-select.css') }}">
	<style>
		.ms-container{
			width: 100%;
		}
	</style>
@endsection

@section('content')
	<div class="card">
		<div class="card-body">
			<!-- list and filter start -->
			<div class="card">
				<div class="card-body border-bottom text-right">
					<button class="btn btn-info" tabindex="0" type="button" data-bs-toggle="modal" id="añadirProducto"><span>Nuevo producto</span></button>
				</div>
				<div class="card-datatable table-responsive pt-0">
					{{-- <table class="user-list-table table" id="tabla_productos"> --}}
                    <table class="table table-report" id="tabla_productos">

						<thead class="table-light">
						<tr>
							<th class="whitespace-no-wrap">Imagen</th>
							<th class="text-left whitespace-no-wrap">Categoríá</th>
							<th class="whitespace-no-wrap">Marca</th>
							<th class="whitespace-no-wrap">Producto</th>
							<th class="text-center whitespace-no-wrap">Precio compra</th>
							<th class="text-center whitespace-no-wrap">Precio venta</th>
							<th class="text-center whitespace-no-wrap">Stock</th>
							<th class="row">Acciones</th>
						</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
				<!-- Modal to add new asignacion starts-->
				
				<!-- Modal to add new sede Ends-->
			</div>
		</div>
	</div>


	<div class="modal fade" id="modalNuevo" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-transparent">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body pb-5 px-sm-5 pt-50">
					<div class="text-center mb-2">
						<h4 class="mb-1" id="title-modal">Nuevo producto</h4>
					</div>
					<form id="nuevoProductoForm" name="nuevoProductoForm" method="post" enctype="multipart/form-data" class="row gy-1 pt-75">
						{{-- <div class="col-12 col-md-6"> --}}
							<div class="col-12 col-md-12">
								<label class="form-label" for="categoria_producto">Categoria</label>
								<select class="form-select" aria-label="Default select example"  id="categoria_productoN" name="categoria_producto">
									<option selected>Seleccionar categoria</option>
									@foreach ($categorias as $categoria)
										<option value="{{$categoria['id']}}">{{$categoria['nombre_categoria']}}</option>
									@endforeach 
								</select>
							</div>
		
							<input type="text" class="hidden" placeholder="Ace,Gloria,Coca cola..." id="idProducto"  name="idProducto" >
                            <div class="col-md-12">
								<label class="form-label" for="categoria_producto">Producto</label>
								<input type="text" class="form-control" placeholder="Nombre producto" id="nombre_productoN" name="nombre_producto">
							</div>
                            <div class="col-md-6">
								<label class="form-label" for="nombre_abrev">Producto Abreviatura</label>
								<input type="text" class="form-control" placeholder="ARR PACS 1K" id="nombre_abrevN"  name="nombre_abrev" >
							</div>
							<div class="col-md-6">
								<label class="form-label" for="categoria_producto">Marca</label>
								<input type="text" class="form-control" placeholder="Ace,Gloria,Coca cola..." id="marca_productoN"  name="marca_producto" >
							</div>
						
		
							<div class="col-12 col-md-4">
								<label class="form-label" for="categoria_producto">Precio compra</label>
								
								<input type="number" class="form-control" placeholder="10" id="precio_compraN" name="precio_compra">
							</div>
							<div class="col-12 col-md-4">
								<label class="form-label" for="categoria_producto">Precio venta</label>
								
								<input type="number" class="form-control" placeholder="10" id="precio_ventaN" name="precio_venta">
							</div>
							<div class="col-12 col-md-4">
								<label class="form-label" for="categoria_producto">Stock</label>
								
								<input type="number" class="form-control" placeholder="10" id="producto_stockN" name="stock_producto">
								
							</div>
		
							<div class="col-md-12 col-span-6">
								<label class="form-label" for="categoria_producto">Fecha</label>
								
								<input type="date" class="form-control"  id="fecha_ven_productoN" name="fecha_ven_producto">
							</div>
							<div class="col-span-12 col-span-12">
								<label class="form-label" for="categoria_producto">Foto</label>
								
								<input type="file" class="form-control"  id="foto_producto" name="foto_producto"  onchange="previewImageEdit(event, '#imgPreviewEdit')">
							</div>
							<div class="col-span-12 col-span-12" id="foto_bd">
								<img id="imgPreview"   style="max-width:150px;border-radius:15px">
							</div>
						{{-- </div> --}}
					</form>
					
				</div>
				<div class="modal-footer">
					<button type="button" id="nuevoProductoCrear" class="btn btn-info me-1">Guardar</button>
					<button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modalShow" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-transparent">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body pb-5 px-sm-5 pt-50">
					<div class="text-center mb-2">
						<h4 class="mb-1" id="title-modal">Editar producto</h4>
					</div>
					<form id="editarProductoForm" name="editarProductoForm" method="post" enctype="multipart/form-data" class="row gy-1 pt-75">
						{{-- <div class="col-12 col-md-6"> --}}
							<div class="col-12 col-md-12">
								<label class="form-label" for="categoria_producto">Categoria</label>
								<select class="form-select" aria-label="Default select example"  id="categoria_producto" name="categoria_producto">
									<option selected>Seleccionar categoria</option>
									@foreach ($categorias as $categoria)
										<option value="{{$categoria['id']}}">{{$categoria['nombre_categoria']}}</option>
									@endforeach 
								</select>
							</div>
		
							<input type="text" class="hidden" placeholder="Ace,Gloria,Coca cola..." id="idProducto"  name="idProducto" >
                            <div class="col-md-12">
								<label class="form-label" for="categoria_producto">Producto</label>
								<input type="text" class="form-control" placeholder="Nombre producto" id="nombre_producto" name="nombre_producto">
							</div>
                            <div class="col-md-6">
								<label class="form-label" for="nombre_abrev">Producto Abreviatura</label>
								<input type="text" class="form-control" placeholder="..." id="nombre_abrev"  name="nombre_abrev" >
							</div>
							<div class="col-md-6">
								<label class="form-label" for="categoria_producto">Marca</label>
								<input type="text" class="form-control" placeholder="Ace,Gloria,Coca cola..." id="marca_producto"  name="marca_producto" >
							</div>
                            
						
							
		
							<div class="col-12 col-md-4">
								<label class="form-label" for="categoria_producto">Precio compra</label>
								
								<input type="number" class="form-control" placeholder="10" id="precio_compra" name="precio_compra">
							</div>
							<div class="col-12 col-md-4">
								<label class="form-label" for="categoria_producto">Precio venta</label>
								
								<input type="number" class="form-control" placeholder="10" id="precio_venta" name="precio_venta">
							</div>
							<div class="col-12 col-md-4">
								<label class="form-label" for="categoria_producto">Stock</label>
								
								<input type="number" class="form-control" placeholder="10" id="producto_stock" name="producto_stock">
								
							</div>
		
							<div class="col-md-12 col-span-6">
								<label class="form-label" for="categoria_producto">Fecha</label>
								
								<input type="date" class="form-control"  id="fecha_ven_producto" name="fecha_ven_producto">
							</div>
							
							<div class="col-md-6 col-span-12">
								<label class="form-label" for="categoria_producto">Foto</label>
								<input type="file" class="form-control"  id="foto_producto" name="foto_producto"  onchange="previewImageEdit(event, '#imgPreviewEdit')">
							</div>

							<div class="col-span-12 col-md-6" id="foto_bd">
								<img id="imgPreviewEdit"   style="max-width:150px;border-radius:15px">
							</div>
						{{-- </div> --}}
					</form>
					
				</div>
				<div class="modal-footer">
					<button type="button" id="editarProducto" class="btn btn-info me-1">Editar</button>
					<button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
				</div>
			</div>
		</div>
	</div>




@endsection
@section('page-script')
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset('js/scripts/multiselect/jquery.multi-select.js') }}"></script>
<script src="{{ asset('js/scripts/multiselect/jquery.quicksearch.min.js') }}"></script>
<script src="{{ asset('js/scripts/numeric/numeric.js') }}"></script>
<script>
	var countFilaAdd=1;
	function validateNumber(){
		$(".number-decimal").numeric({
			decimal: ".",
			negative: false,
			scale: 2
		});
		$(".number-integer").numeric({
			decimal: false,
			negative: false
		});
	}

		dt_ajax = $("#tabla_productos").dataTable({
            processing: true,
            
            // "pagingType": "simple_numbers",
			dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            ajax: "{{route('productos.list')}}",
			language: {
			paginate: {
					previous: '&nbsp;',
					next: '&nbsp;'
				}
			},
            columns: [
                    { data: 'imagen_producto' },
                    { data: 'categoria_producto'},
                    { data: 'marca_producto' },
                    { data: 'nombre_producto' },
                    { data: 'precio_compra',className: "text-center" },
                    { data: 'precio_venta',className: "text-center" },
                    { data: 'stock_producto', className: "text-center" },
                    // { data: 'fecha_ven_producto',className: "text-center" },
                    { data: 'actions', className: "text-center"}
                ],
            // drawCallback: function( settings ) {
            //     feather.replace();
            // }

        });

        $('#añadirProducto').on('click', function(){

            $("#nombre_productoN").val('');
            $("#nombre_abrevN").val('');
            $("#marca_productoN").val('');
            $("#idProductoN").val('');
            $("#stock_productoN").val('');
            $("#precio_compraN").val('');
            $("#precio_ventaN").val('');
            $("#producto_imageN").val('');
            $("#categoria_productoN").val('Seleccionar categoria');
            $("#fecha_ven_productoN").val('');
            $("#producto_stockN").val('');
            document.getElementById('imgPreview').src = "https://mdbootstrap.com/img/Photos/Others/placeholder.jpg";
            // $("#categoria_productoN").html("<option selected>Seleccionar categoria</option>");
            $("#modalNuevo").modal('show');
        });

        $('#nuevoProductoCrear').on('click', function(){
			formData = new FormData(document.getElementById("nuevoProductoForm"));
			v_token = "{{ csrf_token() }}";
            formData.append("_method", "POST");
			formData.append("_token", v_token);
            $.ajax({
                url: "{{route('producto.create')}}",
                type: "POST",
                data: formData,
                dataType: 'json',
                processData: false, 
                contentType: false,
                success: function(obj){
                    if(obj.sw_error==1){
                        Swal.fire({
                            position: "bottom-end",
                            icon: "warning",
                            title: "Atención",
                            text: obj.message,
                            showConfirmButton: false,
                            timer: 2500
                        });
                    }else{
                        console.log(obj.message);
                        Swal.fire({
								position: "bottom-end",
								icon: "success",
								title: "Exito",
								text: obj.message,
								showConfirmButton: false,
								timer: 2500
							});
                        setTimeout(() => {
						    dt_ajax.api().ajax.reload();
                            $("#modalNuevo").modal('hide');
						}, 1000);
                    }
                }
            });
            
        });

        $("#tabla_productos").on('click','.producto-edit', function(){
            productoID=$(this).data('productoid');
            v_token = "{{ csrf_token() }}";
            method = 'GET';
            $.ajax({
                url: "{{ route('producto.data') }}/"+productoID,
                type: "GET",
                data: {_token:v_token,_method:method},
                dataType: 'json',
                success: function(obj){
                    if(obj.sw_error==1){
                        Swal.fire({
                            position: "bottom-end",
                            icon: "warning",
                            title: "Atención",
                            text: obj.message,
                            showConfirmButton: false,
                            timer: 2500
                        });
                    }else{
                        console.log(obj.data.stock_producto);
                        $("#nombre_producto").val(obj.data.nombre_producto);
                        $("#marca_producto").val(obj.data.marca_producto);
                        $("#idProducto").val(obj.data.id);
                        $("#precio_compra").val(obj.data.precio_compra);
                        $("#precio_venta").val(obj.data.precio_venta);
                        $("#categoria_producto").val(obj.data.categoria_producto);
                        $("#fecha_ven_producto").val(obj.data.fecha_ven_producto);
                        $("#producto_stock").val(obj.data.stock_producto);

                        // $("#stock_producto").val(obj.data.id);
                        
                        var rutafoto = obj.data.imagen_producto;
                        document.getElementById('imgPreviewEdit').src = rutafoto;

                        // if(rutafoto != "" && rutafoto != null){
                        // }else{
                        //     document.getElementById('imgPreview').src = "/storage/incidencias/nodisponible.jpg";
                        // }
                        // var setearFoto = document.getElementById('foto_bd');
                        // setearFoto.innerHtml = '<img id="imgPreview" src="{{ asset("/storage/incidencias/Hm03X7W6Sc7GgfRYCyWvgmOPKvLjry07jVlqLT0t.jpg") }}" style="max-width:200px;border-radius:15px">';
                        $("#modalShow").modal('show');

                    }
                }
            });
          
	    });

        $("#tabla_productos").on('click','.producto-delete', function(){
            Idproducto=$(this).data('productoid');
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                v_token = "{{ csrf_token() }}";
                method = 'POST';
                $.ajax({
                    url: "{{route('producto.delete')}}/"+Idproducto,
                    type: "POST",
                    data: {_token:v_token,_method:method},
                    dataType: 'json',
                    success: function(obj){
                        if(obj.sw_error==1){
                            Swal.fire({
                                position: "bottom-end",
                                icon: "warning",
                                title: "Atención",
                                text: obj.message,
                                showConfirmButton: false,
                                timer: 2500
                            });
                        }else{
                            Swal.fire({
                                position: "bottom-end",
                                icon: "success",
                                title: "Atención",
                                text: obj.message,
                                showConfirmButton: false,
                                timer: 2500
                            });
                            location.reload();
                        }
                    }
                });
              
            }
            })          


        });
        
        $('#editarProducto').on('click', function(){
            productoID = $("#idProducto").val();
            console.log(productoID);
			formData = new FormData(document.getElementById("editarProductoForm"));
			v_token = "{{ csrf_token() }}";
            formData.append("_method", "POST");
			formData.append("_token", v_token);
            $.ajax({
                url: "{{route('producto.update')}}/"+productoID,
                type: "POST",
                data: formData,
                dataType: 'json',
                processData: false, 
                contentType: false,
                success: function(obj){
                    if(obj.sw_error==1){
                        Swal.fire({
                            position: "bottom-end",
                            icon: "warning",
                            title: "Atención",
                            text: obj.message,
                            showConfirmButton: false,
                            timer: 2500
                        });
                    }else{
                        console.log(obj.message);
                        Swal.fire({
								position: "bottom-end",
								icon: "success",
								title: "Exito",
								text: obj.message,
								showConfirmButton: false,
								timer: 2500
							});
                        setTimeout(() => {
						    dt_ajax.api().ajax.reload();
                            $("#modalShow").modal('hide');
						}, 1000);
                    }
                }
            });
            
        });
        
        function previewImage(event, querySelector){
            //Recuperamos el input que desencadeno la acción
            const input = event.target;
            //Recuperamos la etiqueta img donde cargaremos la imagen
            $imgPreview = document.querySelector(querySelector);
            // Verificamos si existe una imagen seleccionada
            if(!input.files.length) return
            //Recuperamos el archivo subido
            file = input.files[0];
            //Creamos la url
            objectURL = URL.createObjectURL(file);
            //Modificamos el atributo src de la etiqueta img
            $imgPreview.src = objectURL;
                    
        }

        function previewImageEdit(event, querySelector){
            //Recuperamos el input que desencadeno la acción
            const input = event.target;
            //Recuperamos la etiqueta img donde cargaremos la imagen
            $imgPreviewEdit = document.querySelector(querySelector);
            // Verificamos si existe una imagen seleccionada
            if(!input.files.length) return
            //Recuperamos el archivo subido
            file = input.files[0];
            //Creamos la url
            objectURL = URL.createObjectURL(file);
            //Modificamos el atributo src de la etiqueta img
            $imgPreviewEdit.src = objectURL;
                    
        }
</script>
@endsection