@extends('layouts/contentLayoutMaster')
@section('title', 'Productos Detalles')

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
					<!-- <button class="btn btn-info" tabindex="0" type="button" data-bs-toggle="modal" id="nuevoProducto"><span>Nuevo producto</span></button> -->
				</div>
				<div class="card-datatable table-responsive pt-0">
					<table class="user-list-table table" id="table-productos">
						<thead class="table-light">
						<tr>
							<th>Nombre</th>
							<th>Unidad</th>
							<th>Stock</th>
							<th>Cod barra</th>
							<th>Actions</th>
						</tr>
						</thead>
					</table>
				</div>
				<!-- Modal to add new asignacion starts-->
				
				<!-- Modal to add new sede Ends-->
			</div>
		</div>
	</div>
	<div class="modal fade" id="modals-producto" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-transparent">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body pb-5 px-sm-5 pt-50">
					<div class="text-center mb-2">
						<h1 class="mb-1" id="title-modal">Nuevo producto</h1>
					</div>
					<form id="productoForm" name="productoForm" class="row gy-1 pt-75">
						<div class="col-12 col-md-12">
							<label class="form-label" for="producto_nombre">Nombre</label>
							<input type="text" id="producto_nombre" name="producto_nombre" class="form-control" required/>
						</div>
						<div class="col-12 col-md-12 mb-1">
							<label class="form-label" for="producto_codigobarra">Codigo de barra</label>
							<input type="text" id="producto_codigobarra" name="producto_codigobarra" class="form-control" required/>
						</div>
						<div class="col-12 col-md-6 mb-1">
							<label class="form-label" for="producto_unidad">Unidad</label>
							<select id="producto_unidad" name="producto_unidad" class="form-select" required>
								<option value="">Seleccionar</option>
								@foreach ($unidades as $unidad)
									<option value="{{$unidad->id}}">{{$unidad->nombre.' ['.$unidad->abreviatura.']'}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-12 col-md-6 mb-1">
							<label class="form-label" for="producto_stock">Stock</label>
							<input type="text" id="producto_stock" name="producto_stock" class="form-control" required/>
						</div>
						<div class="">
							<label class="form-label" for="producto_categorias">Categorías</label>
							<select id='producto_categorias' name="producto_categorias[]" multiple='multiple'>
								@foreach ($categorias as $categoria)
									<option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
								@endforeach
							</select>
						</div>
						<input type="text" class="d-none" name="tipo_submit" id="tipo_submit" value="0" required>
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
<script src="{{ asset('js/scripts/multiselect/jquery.multi-select.js') }}"></script>
<script src="{{ asset('js/scripts/multiselect/jquery.quicksearch.min.js') }}"></script>
<script>
	$('#producto_categorias').multiSelect({
		selectableHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='buscar'>",
  		selectionHeader: "<input type='text' class='search-input form-control' autocomplete='off' placeholder='buscar'>",
		afterInit: function(ms){
			var that = this,
				$selectableSearch = that.$selectableUl.prev(),
				$selectionSearch = that.$selectionUl.prev(),
				selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
				selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

			that.qs1 = $selectableSearch.quicksearch(selectableSearchString).on('keydown', function(e){
				if (e.which === 40){
					that.$selectableUl.focus();
					return false;
				}
			});

			that.qs2 = $selectionSearch.quicksearch(selectionSearchString).on('keydown', function(e){
				if (e.which == 40){
					that.$selectionUl.focus();
					return false;
				}
			});
		},
		afterSelect: function(){
			this.qs1.cache();
			this.qs2.cache();
		},
		afterDeselect: function(){
			this.qs1.cache();
			this.qs2.cache();
		}
	});

	$("#nuevoProducto").click(function(){
		$(this).prop('disabled',true);
		$("#title-modal").html('Nuevo producto');
		$("#tipo_submit").val(0);
		$("#modals-producto").modal('show');
	});
	$('#modals-producto').on('hidden.bs.modal', function (e) {
		$('.form-botones').removeClass('d-none');
		$("#nuevoProducto").prop('disabled',false);
		$("#productoForm").trigger("reset");
	});
	dt_ajax = $("#table-productos").dataTable({
		processing: true,
		dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
		ajax: "{{route('productosDetalles.list')}}",
		language: {
			paginate: {
				previous: '&nbsp;',
				next: '&nbsp;'
			}
		},
		columns: [
				{ data: 'nombre' },
				{ data: 'unidad' },
				{ data: 'stock' },
				{ data: 'codbarra' },
				{ data: 'actions', className: "text-right" }
			],
		drawCallback: function( settings ) {
			feather.replace();
		}
	});

	$("#btn-save").click(function(){
		$("#btn-save").prop('disabled',true);
		isValid = $("#productoForm").valid();
		if(isValid){
			v_token = "{{ csrf_token() }}";
			var formSerialize = $('#productoForm').serialize();
			formSerialize += '&_method=POST&_token='+v_token;
			$.ajax({
				url: "{{route('producto.submit')}}",
				type: "POST",
				data: formSerialize,
				dataType: 'json',
				success: function(obj){
					if(typeof obj.message === 'object' && obj.message !== null){
						mensaje='';
						Object.values(obj.message).forEach(element => {
							mensaje+=element+'<br>';
						});
					}else{
						mensaje=obj.message;
					}
					if(obj.sw_error==1){
						Swal.fire({
							position: "bottom-end",
							icon: "warning",
							title: "Atención",
							text: mensaje,
							showConfirmButton: false,
							timer: 2500
						});
					}else{
						Swal.fire({
							position: "bottom-end",
							icon: "success",
							title: "Éxito",
							text: mensaje,
							showConfirmButton: false,
							timer: 2500
						});
						dt_ajax.api().ajax.reload();
						
						$("#modals-producto").modal('hide');
					}
					$("#btn-save").prop('disabled',false);
				}
			});
		}else{
			$("#btn-save").prop('disabled',false);
		}
	});

	$("#table-productos").on('click','.producto-show',function(){
		productoID=$(this).data('productoid');
		$("#title-modal").html('Datos del producto');
		$("#tipo_submit").val(productoID);
		v_token = "{{ csrf_token() }}";
		method = 'GET';
		$.ajax({
			url: "{{ route('productosDetalles.data') }}/"+productoID,
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
					categoria=obj.data;
					setDataModal(categoria);
					$("#productoForm").find('input,select,textarea').prop('disabled',true);
					$('.form-botones').addClass('d-none');
					$("#modals-producto").modal('show');
				}
			}
		});
		
	});

	$("#table-productos").on('click','.producto-edit', function(){
		productoID=$(this).data('productoid');
		$("#title-modal").html('Editar el producto');
		$("#tipo_submit").val(productoID);
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
					producto=obj.data;
					setDataModal(producto);
					$("#productoForm").find('input,select,textarea').prop('disabled',false);
					$("#modals-producto").modal('show');
				}
			}
		});
	});

	$("#table-productos").on('click','.producto-delete', function(){
		productoID=$(this).data('productoid');
		Swal.fire({
			title: "Estas seguro de eliminar este producto?",
			icon: "question",
			showCancelButton: true,
			confirmButtonText: "Si, eliminar!",
			customClass: {
				confirmButton: "btn btn-info",
				cancelButton: "btn btn-outline-danger ms-1"
			},
			buttonsStyling: false
		}).then((function(t) {
			if(t.isConfirmed==true){
				v_token = "{{ csrf_token() }}";
				method = 'PUT';

				$.ajax({
					url: "{{ route('producto.delete') }}/"+productoID,
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
								title: "Éxito",
								text: obj.message,
								showConfirmButton: false,
								timer: 2500
							});
							dt_ajax.api().ajax.reload();
						}
					}
				});
			}
		}))
	});

	function setDataModal(obj){
		$("#producto_nombre").val(obj.nombre);
	}
</script>
@endsection