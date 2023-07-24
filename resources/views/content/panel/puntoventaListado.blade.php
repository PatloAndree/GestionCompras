@extends('layouts/contentLayoutMaster')
@section('title', 'Listado de ventas')

@section('page-style')
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
@endsection

@section('content')
	<div class="card">
		<div class="card-body">
			<!-- list and filter start -->
			<div class="card">
				<div class="card-body border-bottom text-right">
					{{-- <button class="btn btn-flat-success" tabindex="0" type="button" data-bs-toggle="modal" id="añadirCategoria"><span>Realizar venta</span></button> --}}
                    {{-- <a  class="btn btn-info" href="{{route('fichas.nueva')}}"></a> --}}
				    <a class="btn btn-flat-success" href="{{route('realizar.venta')}}"><i data-feather="shopping-cart"></i> <span>Nueva venta</span></a>


				</div>
				<div class="card-datatable table-responsive pt-0">
					<table class="user-list-table table" id="tabla_productos">
						<thead class="table-light">
						<tr>
							<th class="text-left whitespace-no-wrap">Código</th>
							<th class="whitespace-no-wrap">Fecha venta</th>
							<th class="text-center whitespace-no-wrap">Dni</th>
							<th class="text-left">Cliente</th>
							<th class="text-left">Comprobante</th>
							<th class="text-center whitespace-no-wrap">Sub total</th>
							<th class="text-center whitespace-no-wrap">Total</th>
							<th class="row">ACCIONES</th>
						</tr>
						</thead>
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
						<h1 class="mb-1" id="title-modal">Nueva categoria</h1>
					</div>
					<form id="categoriaForm" name="categoriaForm" class="row gy-1 pt-75">
						<div class="col-md-12">
							<label class="form-label" for="categoria_nombre">Categoria</label>
							<input type="text" id="categoria_nombre" name="categoria_nombre" class="form-control" required/>
						</div>
						<div class="col-md-12">
							<select class="form-select" aria-label="Default select example" id="unidad_categoria" name="unidad_categoria">
								<option selected>Seleccionar categoria</option>
								@foreach ($unidades as $unidad)
									<option value="{{$unidad['id']}}">{{$unidad['nombre_unidad']}}</option>
								@endforeach 
							</select>
							<input type="text" class="d-none" name="tipo_submit" id="tipo_submit" value="0" required>
						</div>
						
					</form>
				</div>
				<div class="modal-footer">
					<div class="col-12 text-right mt-2 pt-50 form-botones">
						<button type="button" id="btn-save" class="btn btn-info me-1">Guardar</button>
						<button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-transparent">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body pb-5 px-sm-5 pt-50">
					<div class="text-center mb-2">
						<h1 class="mb-1" id="title-modal">Nueva categoria</h1>
					</div>
					<form id="categoriaForm" name="categoriaForm" class="row gy-1 pt-75">
						<div class="col-12 col-md-12">
							<label class="form-label" for="categoria_nombre">Categoria</label>
							<input type="text" id="nombre_categoriaE" name="nombre_categoriaE" class="form-control" required/>
						</div>
						<div class="col-12 col-md-12">
							<select class="form-select" aria-label="Default select example" id="unidad_nombreE" name="unidad_nombre">
								<option selected>Seleccionar categoria</option>
								@foreach ($unidades as $unidad)
									<option value="{{$unidad['id']}}">{{$unidad['nombre_unidad']}}</option>
								@endforeach 
							</select>
							<input type="text" class="d-none" name="tipo_submit" id="tipo_submit" value="0" required>
						</div>
						<div class="col-12 text-right mt-2 pt-50 form-botones">
							<button type="button" id="btn-save" class="btn btn-info me-1">Guardar</button>
							<button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
						</div>
					</form>
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
<script>

   		dt_ajax = $("#tabla_productos").dataTable({
            processing: true,
			responsive: true,
			// dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            ajax: "{{route('puntoventa.list')}}",
			language: {
			paginate: {
					previous: '&nbsp;',
					next: '&nbsp;'
				}
			},			
            columns: [
                    { data: 'codigo_venta'},
                    { data: 'fecha_venta' },
                    { data: 'dni_cliente' },
                    { data: 'nombres_cliente' },
                    { data: 'comprobante' , className: "text-left"},
                    { data: 'subtotal' , className: "text-center"},
                    { data: 'pago_total' , className: "text-center"},
                    // { data: 'status',  className: "text-center" },
                    { data: 'actions', className: "text-center"}
                ],
            // drawCallback: function( settings ) {
            //     feather.replace();
            // }

        });

        $('#añadirCategoria').on('click', function(){
            $("#nombre_categoria").val('');
            $("#unidad_categoria").val('Seleccionar categoria');
            $("#modalNuevo").modal('show');
        });

        // $("#tabla_productos").on('click','.venta-edit', function(){
        //     // categoriaID=$(this).data('categoriaid');
        //     v_token = "{{ csrf_token() }}";
        //     method = 'GET';
        //     $.ajax({
        //         // url: "{{route('categoria.data') }}/"+categoriaID,
        //         url: "{{route('generar.pdf') }}",
        //         type: "GET",
        //         data: {_token:v_token,_method:method},
        //         dataType: 'json',
        //         success: function(obj){
        //             if(obj.sw_error==1){
        //                 Swal.fire({
        //                     position: "bottom-end",
        //                     icon: "warning",
        //                     title: "Atención",
        //                     text: obj.message,
        //                     showConfirmButton: false,
        //                     timer: 2500
        //                 });
        //             }else{
        //                 location.reload();
        //                 // $("#nombre_categoriaE").val(obj.data.nombre_categoria);
        //                 // $("#unidad_nombreE").val(obj.data.unidad_categoria);
        //                 // $("#estado_categoria").val(obj.data.status);
        //                 // $("#idCategoria").val(obj.data.id);
        //                 // $("#modalEditar").modal('show');

        //             }
        //         }
        //     });
          
	    // });

        $('#nuevaCategoriaCrear').on('click', function(){
			formData = new FormData(document.getElementById("nuevaCategoriaForm"));
			v_token = "{{ csrf_token() }}";
            formData.append("_method", "POST");
			formData.append("_token", v_token);
            $.ajax({
                url: "{{route('categoria.create')}}",
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

        $("#tabla_productos").on('click','.categoria-edit', function(){
            categoriaID=$(this).data('categoriaid');
            v_token = "{{ csrf_token() }}";
            method = 'GET';
            $.ajax({
                url: "{{route('categoria.data') }}/"+categoriaID,
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
                        console.log(obj.data.nombre_categoria);
                        $("#nombre_categoriaE").val(obj.data.nombre_categoria);
                        $("#unidad_nombreE").val(obj.data.unidad_categoria);
                        $("#estado_categoria").val(obj.data.status);
                        $("#idCategoria").val(obj.data.id);
                        $("#modalEditar").modal('show');

                    }
                }
            });
          
	    });

        $('#editarCategoria').on('click', function(){
            categoriaID = $("#idCategoria").val();
            console.log(categoriaID);
			formData = new FormData(document.getElementById("editarCategoriaForm"));
			v_token = "{{ csrf_token() }}";
            formData.append("_method", "POST");
			formData.append("_token", v_token);
            $.ajax({
                url: "{{route('categoria.update')}}/"+categoriaID,
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
                            $("#modalEditar").modal('hide');
						}, 1000);
                    }
                }
            });
            
        });
</script>
@endsection