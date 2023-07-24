@extends('layouts/contentLayoutMaster')
@section('title', 'Proveedores')

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
					<button class="btn btn-info" tabindex="0" type="button" data-bs-toggle="modal" id="nuevoProveedor"><span>Nuevo proveedor</span></button>
				</div>
				<div class="card-datatable table-responsive pt-0">
					<table class="user-list-table table" id="table-proveedores">
						<thead class="table-light">
						<tr>
							<th>Nombre</th>
							<th>Documento</th>
							<th>Teléfono</th>
							<th>Correo</th>
							<th>Contacto</th>
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
	<div class="modal fade" id="modals-proveedor" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-transparent">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body pb-5 px-sm-5 pt-50">
					<div class="text-center mb-2">
						<h1 class="mb-1" id="title-modal">Nueva ficha de atención</h1>
					</div>
					<form id="proveedorForm" name="proveedorForm" class="row gy-1 pt-75">
						<div class="col-12 col-md-12">
							<label class="form-label" for="proveedor_nombre">Nombre o Razon Social</label>
							<input type="text" id="proveedor_nombre" name="proveedor_nombre" class="form-control" required/>
						</div>
						<input type="text" class="d-none" name="tipo_submit" id="tipo_submit" value="0" required>
						<div class="col-12 col-md-6">
							<label class="form-label" for="proveedor_tipo_documento">Tipo documento</label>
							<select id="proveedor_tipo_documento" name="proveedor_tipo_documento" class="form-select" aria-label="Seleccionar" required>
								<option value="">Seleccionar</option>
								<option value="1">DNI</option>
								<option value="2">RUC</option>
								<option value="3">Carnet de extranjeria</option>
							</select>
						</div>
						<div class="col-12 col-md-6">
							<label class="form-label" for="proveedor_documento">Nro de Documento</label>
							<input type="text" id="proveedor_documento" name="proveedor_documento" class="form-control" required />
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="proveedor_direccion">Dirección</label>
							<input type="text" id="proveedor_direccion" name="proveedor_direccion" class="form-control" required />
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="proveedor_contacto">Persona de contacto</label>
							<input type="text" id="proveedor_contacto" name="proveedor_contacto" class="form-control" required />
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="proveedor_telefono">Teléfono</label>
							<input type="text" id="proveedor_telefono" name="proveedor_telefono" class="form-control" required />
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="proveedor_correo">Correo</label>
							<input type="text" id="proveedor_correo" name="proveedor_correo" class="form-control" required />
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="proveedor_otros">Información adicional</label>
							<textarea class="form-control" id="proveedor_otros" rows="2" name="proveedor_otros"></textarea>
						</div>
						<div class="col-12 text-right mt-2 pt-50">
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
	$("#nuevoProveedor").click(function(){
		$(this).prop('disabled',true);
		$("#title-modal").html('Nuevo Proveedor');
		$("#tipo_submit").val(0);
		$("#modals-proveedor").modal('show');
	});
	$('#modals-proveedor').on('hidden.bs.modal', function (e) {
		$("#nuevoProveedor").prop('disabled',false);
		$("#proveedorForm").trigger("reset");
	});
	dt_ajax = $("#table-proveedores").dataTable({
		processing: true,
		dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
		ajax: "{{route('proveedores.list')}}",
		language: {
			paginate: {
				previous: '&nbsp;',
				next: '&nbsp;'
			}
		},
		columns: [
				{ data: 'nombre' },
				{ data: 'documento' },
				{ data: 'celular' },
				{ data: 'correo' },
				{ data: 'contacto' },
				{ data: 'actions' }
			],
		drawCallback: function( settings ) {
			feather.replace();
		}
	});

	$("#btn-save").click(function(){
		$("#btn-save").prop('disabled',true);
		isValid = $("#proveedorForm").valid();
		console.log(isValid);
		if(isValid){
			v_token = "{{ csrf_token() }}";
			var formSerialize = $('#proveedorForm').serialize();
			formSerialize += '&_method=POST&_token='+v_token;
			$.ajax({
				url: "{{route('proveedor.submit')}}",
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
						
						$("#modals-proveedor").modal('hide');
					}
					$("#btn-save").prop('disabled',false);
				}
			});
		}else{
			$("#btn-save").prop('disabled',false);
		}
	});

	$("#table-proveedores").on('click','.proveedor-show',function(){
		proveedorID=$(this).data('proveedorid');
		$("#title-modal").html('Datos del Proveedor');
		$("#tipo_submit").val(proveedorID);
		v_token = "{{ csrf_token() }}";
		method = 'GET';
		$.ajax({
			url: "{{ route('proveedor.data') }}/"+proveedorID,
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
					proveedor=obj.data;
					setDataModal(proveedor);
					$("#proveedorForm").find('input,select,textarea').prop('disabled',true);
					$("#modals-proveedor").modal('show');
				}
			}
		});
		
	});

	$("#table-proveedores").on('click','.proveedor-edit', function(){
		proveedorID=$(this).data('proveedorid');
		$("#title-modal").html('Editar el Proveedor');
		$("#tipo_submit").val(proveedorID);
		v_token = "{{ csrf_token() }}";
		method = 'GET';
		$.ajax({
			url: "{{ route('proveedor.data') }}/"+proveedorID,
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
					proveedor=obj.data;
					setDataModal(proveedor);
					$("#proveedorForm").find('input,select,textarea').prop('disabled',false);
					$("#modals-proveedor").modal('show');
				}
			}
		});
	});

	$("#table-proveedores").on('click','.proveedor-delete', function(){
		proveedorID=$(this).data('proveedorid');
		Swal.fire({
			title: "Estas seguro de eliminar este proveedor ?",
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
					url: "{{ route('proveedor.delete') }}/"+proveedorID,
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
		$("#proveedor_nombre").val(obj.nombre);
		$("#proveedor_tipo_documento").val(obj.document_id);
		$("#proveedor_documento").val(obj.numerodocumento);
		$("#proveedor_direccion").val(obj.direccion);
		$("#proveedor_contacto").val(obj.contacto);
		$("#proveedor_telefono").val(obj.telefono);
		$("#proveedor_correo").val(obj.correo);
		$("#proveedor_otros").html(obj.otros);
	}
</script>
@endsection