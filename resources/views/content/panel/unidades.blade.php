@extends('layouts/contentLayoutMaster')
@section('title', 'Unidades')

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
					<button class="btn btn-info" tabindex="0" type="button" data-bs-toggle="modal" id="nuevoUnidad"><span>Nuevo unidad</span></button>
				</div>
				<div class="card-datatable table-responsive pt-0">
					<table class="user-list-table table" id="table-unidades">
						<thead class="table-light">
						<tr>
							<th>Nombre</th>
							<th>Abreviatura</th>
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
	<div class="modal fade" id="modals-unidad" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-transparent">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body pb-5 px-sm-5 pt-50">
					<div class="text-center mb-2">
						<h1 class="mb-1" id="title-modal">Nueva unidad</h1>
					</div>
					<form id="unidadForm" name="unidadForm" class="row gy-1 pt-75">
						<div class="col-12 col-md-12">
							<label class="form-label" for="unidad_nombre">Nombre</label>
							<input type="text" id="unidad_nombre" name="unidad_nombre" class="form-control" required/>
						</div>
						<input type="text" class="d-none" name="tipo_submit" id="tipo_submit" value="0" required>
						<div class="col-12 col-md-12">
							<label class="form-label" for="unidad_abreviatura">Abreviatura</label>
							<input type="text" id="unidad_abreviatura" name="unidad_abreviatura" class="form-control" required />
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
	$("#nuevoUnidad").click(function(){
		$(this).prop('disabled',true);
		$("#title-modal").html('Nueva unidad');
		$("#tipo_submit").val(0);
		$("#modals-unidad").modal('show');
	});
	$('#modals-unidad').on('hidden.bs.modal', function (e) {
		$('.form-botones').removeClass('d-none');
		$("#nuevoUnidad").prop('disabled',false);
		$("#unidadForm").trigger("reset");
	});
	dt_ajax = $("#table-unidades").dataTable({
		processing: true,
		dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
		ajax: "{{route('unidades.list')}}",
		language: {
			paginate: {
				previous: '&nbsp;',
				next: '&nbsp;'
			}
		},
		columns: [
				{ data: 'nombre' },
				{ data: 'abreviatura' },
				{ data: 'actions', className: "text-right" }
			],
		drawCallback: function( settings ) {
			feather.replace();
		}
	});

	$("#btn-save").click(function(){
		$("#btn-save").prop('disabled',true);
		isValid = $("#unidadForm").valid();
		console.log(isValid);
		if(isValid){
			v_token = "{{ csrf_token() }}";
			var formSerialize = $('#unidadForm').serialize();
			formSerialize += '&_method=POST&_token='+v_token;
			$.ajax({
				url: "{{route('unidad.submit')}}",
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
						
						$("#modals-unidad").modal('hide');
					}
					$("#btn-save").prop('disabled',false);
				}
			});
		}else{
			$("#btn-save").prop('disabled',false);
		}
	});

	$("#table-unidades").on('click','.unidad-show',function(){
		unidadID=$(this).data('unidadid');
		$("#title-modal").html('Datos de la Unidad');
		$("#tipo_submit").val(unidadID);
		v_token = "{{ csrf_token() }}";
		method = 'GET';
		$.ajax({
			url: "{{ route('unidad.data') }}/"+unidadID,
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
					unidad=obj.data;
					setDataModal(unidad);
					$("#unidadForm").find('input,select,textarea').prop('disabled',true);
					$('.form-botones').addClass('d-none');
					$("#modals-unidad").modal('show');
				}
			}
		});
		
	});

	$("#table-unidades").on('click','.unidad-edit', function(){
		unidadID=$(this).data('unidadid');
		$("#title-modal").html('Editar la Unidad');
		$("#tipo_submit").val(unidadID);
		v_token = "{{ csrf_token() }}";
		method = 'GET';
		$.ajax({
			url: "{{ route('unidad.data') }}/"+unidadID,
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
					unidad=obj.data;
					setDataModal(unidad);
					$("#unidadForm").find('input,select,textarea').prop('disabled',false);
					$("#modals-unidad").modal('show');
				}
			}
		});
	});

	$("#table-unidades").on('click','.unidad-delete', function(){
		unidadID=$(this).data('unidadid');
		Swal.fire({
			title: "Estas seguro de eliminar está unidad ?",
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
					url: "{{ route('unidad.delete') }}/"+unidadID,
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
		$("#unidad_nombre").val(obj.nombre);
		$("#unidad_abreviatura").val(obj.abreviatura);
	}
</script>
@endsection