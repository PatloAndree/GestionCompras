@extends('layouts/contentLayoutMaster')

@section('title', 'Sedes')
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection
@section('content')
<!-- Kick start -->
<div class="card">
  	<div class="card-body">
		 <!-- list and filter start -->
		<div class="card">
			<div class="card-body border-bottom">
				<!-- <button class="btn btn-info" tabindex="0" type="button" data-bs-toggle="modal" data-bs-target="#modal-sedes-new"><span>Nueva sede</span></button> -->
				<a class="btn btn-info" tabindex="0" href="{{ route('sedes.show','0') }}" target="_blank"><span>Nueva sede</span></a>

			</div>
			<div class="card-datatable table-responsive pt-0">
				<table class="user-list-table table" id="table-sedes">
					<thead class="table-light">
					<tr>
						<th>Nombre</th>
						<th>Pais</th>
						<th>Departamento</th>
						<th>Provincia</th>
						<th>Distrito</th>
						<th>Dirección</th>
						<th>Acciones</th>
					</tr>
					</thead>
				</table>
			</div>
			<!-- Modal to add new sede starts-->
			<div class="modal modal-slide-in new-sede-modal fade" id="modal-sedes-new">
				<div class="modal-dialog">
					<form class="add-new-sede modal-content pt-0" id="form-add-sede">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
						<div class="modal-header mb-1">
							<h5 class="modal-title" id="exampleModalLabel">Nueva Sede</h5>
						</div>
						<div class="modal-body flex-grow-1">
							<div class="mb-1">
								<label class="form-label" for="sede_name">Nombre</label>
								<input type="text" class="form-control dt-full-name" id="sede_name" placeholder="Ingrese nombre de la sede" name="sede_name" required/>
							</div>
							<div class="mb-1">
								<label class="form-label" for="sede_departamento">Departamento</label>
								<select id="sede_departamento" name="sede_departamento" class="form-select" required>
									<option value="">Seleccionar</option>
									@foreach ($departamentos as $departamento)
										<option value="{{$departamento->id}}">{{$departamento->nombre_ubigeo}}</option>
									@endforeach
								</select>
							</div>
                            <div class="mb-1">
								<label class="form-label" for="sede_provincia">Provincia</label>
								<select id="sede_provincia" name="sede_provincia" class="form-select" disabled required>
									<option value=""></option>
								</select>
							</div>
                            <div class="mb-1">
								<label class="form-label" for="sede_distrito">Distrito</label>
								<select id="sede_distrito" name="sede_distrito" class="form-select" disabled required>
									<option value=""></option>
								</select>
							</div>
							
							<div class="mb-1">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="sede_sw_ambulancia" name="sede_sw_ambulancia" value="checked" >
									<label class="form-check-label" for="sede_sw_ambulancia">¿Es una ambulancia?</label>
								</div>
							</div>
							<div class="mb-1">
								<label class="form-label" for="sede_apertura">Apertura</label>
								<input type="text" id="sede_apertura" name="sede_apertura" class="form-control" placeholder="HH:mm" required/>
							</div>
							<div class="mb-1">
								<label class="form-label" for="sede_cierre">Cierre</label>
								<input type="text" id="sede_cierre" name="sede_cierre" class="form-control" placeholder="HH:mm" required/>
							</div>
							<div class="mb-1">
								<label class="form-label" for="sede_direccion">Dirección</label>
								<textarea class="form-control" id="sede_direccion" rows="2" placeholder="Ingresar dirección" name="sede_direccion" required></textarea>
							</div>
							<button type="button" class="btn btn-info me-1" id="add-sede">Guardar</button>
							<button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
						</div>
					</form>
				</div>
			</div>

			<div class="modal modal-slide-in new-sede-modal fade" id="modal-sedes-update">
				<div class="modal-dialog">
					<form class="add-new-sede modal-content pt-0" id="form-update-sede">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
						
						<div class="modal-header mb-1" id="show-title-modal">
							<h5 class="modal-title">Detalle de la sede</h5>
						</div>
						<div class="modal-header mb-1" id="edit-title-modal">
							<h5 class="modal-title">Editar la sede</h5>
						</div>
						<div class="modal-body flex-grow-1">
							<div class="mb-1">
								<label class="form-label" for="update_sede_name">Nombre</label>
								<input type="text" class="form-control dt-full-name" id="update_sede_name" name="sede_name" required/>
							</div>
							<div class="mb-1">
								<label class="form-label" for="update_sede_departamento">Departamento</label>
								<select id="update_sede_departamento" name="sede_departamento" class="form-select" required>
									<option value="">Seleccionar</option>
									@foreach ($departamentos as $departamento)
										<option value="{{$departamento->id}}">{{$departamento->nombre_ubigeo}}</option>
									@endforeach
								</select>
							</div>
                            <div class="mb-1">
								<label class="form-label" for="update_sede_provincia">Provincia</label>
								<select id="update_sede_provincia" name="sede_provincia" class="form-select" required>
									<option value=""></option>
								</select>
							</div>
                            <div class="mb-1">
								<label class="form-label" for="update_sede_distrito">Distrito</label>
								<select id="update_sede_distrito" name="sede_distrito" class="form-select" required>
									<option value=""></option>
								</select>
							</div>
							<div class="mb-1">
								<label class="form-label" for="update_sede_direccion">Dirección</label>
								<textarea class="form-control" id="update_sede_direccion" rows="2" placeholder="Ingresar dirección" name="sede_direccion"></textarea>
							</div>
							<div class="mb-1">
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="checkbox" id="update_sede_sw_ambulancia" name="sede_sw_ambulancia" value="checked" >
									<label class="form-check-label" for="update_sede_sw_ambulancia">¿Es una ambulancia?</label>
								</div>
							</div>
							<div class="mb-1">
								<label class="form-label" for="update_sede_apertura">Apertura</label>
								<input type="text" id="update_sede_apertura" name="sede_apertura" class="form-control" placeholder="HH:mm" required/>
							</div>
							<div class="mb-1">
								<label class="form-label" for="update_sede_cierre">Cierre</label>
								<input type="text" id="update_sede_cierre" name="sede_cierre" class="form-control" placeholder="HH:mm" required/>
							</div>
							<div class="mb-1 d-none">
								<label class="form-label" for="update_sede_id">ID</label>
								<input type="text" id="update_sede_id" class="form-control" required/>
							</div>
							<button type="button" class="btn btn-info me-1" id="btn-guardar-edit">Guardar</button>
							<button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
  <!-- list and filter end -->
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
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script>
var aperturaFlatpickr;
var cierreFlatpickr;
$(window).on('load', function() {
	$('#table-users').DataTable();
	$("#sede_apertura").flatpickr({
        enableTime: !0,
        noCalendar: !0
	});
	$("#sede_icerre").flatpickr({
        enableTime: !0,
        noCalendar: !0
	});

	aperturaFlatpickr = $("#update_sede_apertura").flatpickr({
        enableTime: !0,
        noCalendar: !0
	});
	cierreFlatpickr = $("#update_sede_cierre").flatpickr({
        enableTime: !0,
        noCalendar: !0
	});
});

$("#sede_departamento").change(function(){
	deparment_id = $(this).val();
	if(deparment_id!=''){
		v_token = "{{ csrf_token() }}";
		method = 'GET';
		$.ajax({
			url: "{{ route('ubigeo.padre') }}/"+deparment_id,
			type: "POST",
			data: {_token:v_token,_method:method},
			dataType: 'json',
			success: function(obj){
				provincias = obj.provincias;
				if(provincias.length>0){
					htmlOptions = '<option value="">Seleccionar</option>';
					provincias.forEach(element => {
						htmlOptions+=`<option value="${element.id}">${element.nombre_ubigeo}</option>`;
					});
					$("#sede_provincia").html(htmlOptions);
					$("#sede_provincia").prop('disabled',false);
					$("#sede_distrito").prop('disabled',true);
					$("#sede_distrito").html('<option value=""></option>');
				}
			}
		});
	}else{
		$("#sede_provincia").prop('disabled',true);
		$("#sede_provincia").html('<option value=""></option>');
		$("#sede_distrito").prop('disabled',true);
		$("#sede_distrito").html('<option value=""></option>');
	}
});

$("#sede_provincia").change(function(){
	deparment_id = $(this).val();
	if(deparment_id!=''){
		v_token = "{{ csrf_token() }}";
		method = 'GET';
		$.ajax({
			url: "{{ route('ubigeo.padre') }}/"+deparment_id,
			type: "POST",
			data: {_token:v_token,_method:method},
			dataType: 'json',
			success: function(obj){
				provincias = obj.provincias;
				if(provincias.length>0){
					htmlOptions = '<option value="">Seleccionar</option>';
					provincias.forEach(element => {
						htmlOptions+=`<option value="${element.id}">${element.nombre_ubigeo}</option>`;
					});
					$("#sede_distrito").html(htmlOptions);
					$("#sede_distrito").prop('disabled',false);
				}
			}
		});
	}else{
		$("#sede_distrito").prop('disabled',true);
		$("#sede_distrito").html('<option value=""></option>');
	}
});

$("#add-sede").on('click',function(){
	isValid = $("#form-add-sede").valid();
	if(isValid){
		var formSerialize = $('#form-add-sede').serialize();
		v_token = "{{ csrf_token() }}";
		formSerialize += '&_method=POST&_token='+v_token;

		$.ajax({
			url: "{{route('sede.create')}}",
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
					
					$("#modal-sedes-new").modal('hide');
				}
			}
		});
	}
});
$("#btn-guardar-edit").on('click',function(){
	sedeID=$("#update_sede_id").val();
	isValid = $("#form-update-sede").valid();
	if(isValid){
		var formSerialize = $('#form-update-sede').serialize();
		v_token = "{{ csrf_token() }}";
		formSerialize += '&_method=PUT&_token='+v_token;

		$.ajax({
			url: "{{route('sede.update')}}/"+sedeID,
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
					$("#modal-sedes-update").modal('hide');
				}
			}
		});
	}
});

dt_ajax = $("#table-sedes").dataTable({
	processing: true,
	dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
	ajax: "{{route('sedes.list')}}",
	language: {
		paginate: {
			previous: '&nbsp;',
			next: '&nbsp;'
		}
	},
	columns: [
            { data: 'nombre' },
            { data: 'pais' },
            { data: 'departamento' },
            { data: 'provincia' },
            { data: 'distrito' },
            { data: 'direccion' },
            { data: 'actions' }
        ],
	columnDefs: [
		{
			targets: 6,
			className: "text-center"
		}
	],
	drawCallback: function( settings ) {
        feather.replace();
    }
});

$("#table-sedes").on('click','.sede-show',function(){
	sedeID=$(this).data('sedeid');
	v_token = "{{ csrf_token() }}";
	method = 'GET';
	$.ajax({
		url: "{{ route('sedes.show') }}/"+sedeID,
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
				sede=obj.sede;
				$("#btn-guardar-edit").addClass('d-none');
				$("#edit-title-modal").addClass("d-none");
				$("#show-title-modal").removeClass("d-none");

				$("#update_sede_id").val(sede.id);
				$("#update_sede_name").val(sede.nombre);
				$("#update_sede_departamento").val(sede.departamento_id);
				provincias=sede.provincias;
				provinciasHtml = '<option value="">Seleccionar</option>';
				provincias.forEach(element => {
					provinciasHtml+=`<option value="${element.id}">${element.nombre_ubigeo}</option>`;
				});
				$("#update_sede_provincia").html(provinciasHtml);
				$("#update_sede_provincia").val(sede.provincias_id);
				distritos=sede.distritos;
				distritosHtml = '<option value="">Seleccionar</option>';
				distritos.forEach(element => {
					distritosHtml+=`<option value="${element.id}">${element.nombre_ubigeo}</option>`;
				});

				aperturaFlatpickr.setDate(sede.apertura);
				cierreFlatpickr.setDate(sede.cierre);

				$("#update_sede_distrito").html(distritosHtml);
				$("#update_sede_distrito").val(sede.distrito_id);
				$("#update_sede_direccion").val(sede.direccion);
				
				$("#form-update-sede").find('input,select,textarea').prop('disabled',true);
				$("#modal-sedes-update").modal("show");
			}
		}
	});
});
// $("#table-sedes").on('click','.sede-edit',function(){
// 	sedeID=$(this).data('sedeid');
// 	v_token = "{{ csrf_token() }}";
// 	method = 'GET';
// 	$.ajax({
// 		url: "{{ route('sedes.show') }}/"+sedeID,
// 		type: "GET",
// 		data: {_token:v_token,_method:method},
// 		dataType: 'json',
// 		success: function(obj){
// 			if(obj.sw_error==1){
// 				Swal.fire({
// 					position: "bottom-end",
// 					icon: "warning",
// 					title: "Atención",
// 					text: obj.message,
// 					showConfirmButton: false,
// 					timer: 2500
// 				});
// 			}else{
// 				sede=obj.sede;
// 				$("#btn-guardar-edit").removeClass('d-none');
// 				$("#edit-title-modal").removeClass("d-none");
// 				$("#show-title-modal").addClass("d-none");

// 				$("#update_sede_id").val(sede.id);
// 				$("#update_sede_name").val(sede.nombre);
// 				$("#update_sede_departamento").val(sede.departamento_id);
// 				provincias=sede.provincias;
// 				provinciasHtml = '<option value="">Seleccionar</option>';
// 				provincias.forEach(element => {
// 					provinciasHtml+=`<option value="${element.id}">${element.nombre_ubigeo}</option>`;
// 				});
// 				$("#update_sede_provincia").html(provinciasHtml);
// 				$("#update_sede_provincia").val(sede.provincias_id);
// 				distritos=sede.distritos;
// 				distritosHtml = '<option value="">Seleccionar</option>';
// 				distritos.forEach(element => {
// 					distritosHtml+=`<option value="${element.id}">${element.nombre_ubigeo}</option>`;
// 				});

// 				aperturaFlatpickr.setDate(sede.apertura);
// 				cierreFlatpickr.setDate(sede.cierre);
				
				
// 				$("#update_sede_apertura").prop('checked',false);
// 				if(sede.sw_ambulancia==1){
// 					$("#update_sede_apertura").prop('checked',true);
// 				}
// 				$("#update_sede_distrito").html(distritosHtml);
// 				$("#update_sede_distrito").val(sede.distrito_id);
// 				$("#update_sede_direccion").val(sede.direccion);
				
// 				$("#form-update-sede").find('input,select,textarea').prop('disabled',false);
// 				$("#modal-sedes-update").modal("show");
// 			}
// 		}
// 	});
// });
$("#table-sedes").on('click','.sede-delete',function(){
	//console.log($(this));
	sedeID=$(this).data('sedeid');
	nombre = $(this).data('nombre');
	Swal.fire({
		title: "Estas seguro de eliminar la sede "+nombre+" ?",
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
				url: "{{ route('sede.delete') }}/"+sedeID,
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
</script>
@endsection