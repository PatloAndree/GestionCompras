@extends('layouts/contentLayoutMaster')

@section('title', 'Ficha de atención')
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
			<div class="card-body border-bottom text-right">
				<a class="btn btn-info" href="{{route('fichas.nueva')}}"><span>Nueva ficha de atención</span></a>
				<button class="btn btn-info d-none" tabindex="0" type="button" data-bs-toggle="modal" data-bs-target="#modals-add-ficha"><span>Nueva ficha de atención</span></button>
			</div>
			<div class="card-datatable table-responsive pt-0">
				<table class="user-list-table table" id="table-fichas">
					<thead class="table-light">
						<tr>
							<th>Paciente</th>
							<th>Documento</th>
							<th>Fecha de atención</th>
							<th>Tipo de atención</th>
							<th>Usuario</th>
							<th>Actions</th>
						</tr>
					</thead>
				</table>
			</div>
			<!-- Modal to add new asignacion starts-->
			
			<!-- Modal to add new sede Ends-->
		</div>
		{{-- Modal --}}
		<div class="modal fade" id="modals-add-ficha" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered modal-new-ficha">
				<div class="modal-content">
				<div class="modal-header bg-transparent">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body pb-5 px-sm-5 pt-50">
					<div class="text-center mb-2">
					<h1 class="mb-1">Nueva ficha de atención</h1>
					</div>
					<form id="newFichaForm" name="newFichaForm" class="row gy-1 pt-75" enctype="multipart/form-data">
					<span for="">PACIENTE</span><hr>
					<div class="col-12 col-md-6">
						<label class="form-label" for="paciente_name">Nombres</label>
						<input type="text" id="paciente_name" name="paciente_name" class="form-control" placeholder="Nombre" data-msg="Ingrese sus nombres" required/>
					</div>
					<div class="col-12 col-md-6">
						<label class="form-label" for="paciente_last_name">Apellidos</label>
						<input type="text" id="paciente_last_name" name="paciente_last_name" class="form-control" placeholder="Apellidos" data-msg="Ingrese sus apellidos" required/>
					</div>
					<div class="col-12 col-md-6">
						<label class="form-label" for="paciente_tipo_documento">Tipo documento</label>
						<select id="paciente_tipo_documento" name="paciente_tipo_documento" class="form-select" aria-label="Seleccionar" required>
							<option value="">Seleccionar</option>
							<option value="1">DNI</option>
							<option value="2" class="d-none">RUC</option>
							<option value="3">Carnet de extranjeria</option>
						</select>
					</div>
					<div class="col-12 col-md-6">
						<label class="form-label" for="paciente_documento">Nro de Documento</label>
						<input type="text" id="paciente_documento" name="paciente_documento" class="form-control modal-edit-tax-id" placeholder="111111111"required />
					</div>
					<div class="col-12 col-md-6">
						<label class="form-label" for="paciente_dateofbirth">Fecha de nacimiento</label>
						<input type="text" id="paciente_dateofbirth" name="paciente_dateofbirth" class="form-control" placeholder="DD-MM-YYYY" required/>
					</div>
					<div class="col-12 col-md-6">
						<label class="form-label" for="paciente_sex">Sexo</label>
						<select id="paciente_sex" name="paciente_sex" class="form-select" required>
							<option value="">Seleccionar</option>
							<option value="1">Masculino</option>
							<option value="2">Femenino</option>
						</select>
					</div>
					<div class="col-12 col-md-12">
						<label class="form-label" for="paciente_address">Dirección</label>
						<textarea class="form-control" id="paciente_address" rows="2" placeholder="Ingresar dirección" name="paciente_address" required></textarea>
					</div>
					<div class="col-12 col-md-6">
						<label class="form-label" for="paciente_phone">Celular</label>
						<input type="text" id="paciente_phone" class="form-control" placeholder="999 999 999" name="paciente_phone" required/>
					</div>
					<div class="col-12 col-md-6">
						<label class="form-label" for="email">Correo</label>
						<input type="email" id="email" class="form-control dt-email" placeholder="john.doe@example.com" name="email"/>
					</div>
						<span>ATENCIÓN</span><hr>

					<div class="col-12 col-md-12">
						<label class="form-label" for="paciente_tipo_atencion">Tipo de atención</label>
						<select id="paciente_tipo_atencion" name="paciente_tipo_atencion" class="form-select" aria-label="Seleccionar" required>
							<option value="">Seleccionar</option>
							<option value="1">Consulta</option>
							<option value="2">Urgencia</option>
							<option value="3">Emergencia</option>
							<option value="4">Accidente</option>
						</select>
					</div>
					<div class="col-12 col-md-6">
						<label class="form-label" for="paciente_fechatencion">Fecha de atención</label>
						<input type="text" id="paciente_fechatencion" name="paciente_fechatencion" class="form-control" placeholder="DD-MM-YYYY" required/>
					</div>
					<div class="col-12 col-md-6">
						<label class="form-label" for="paciente_horatencion">Hora de atención</label>
						<input type="time" id="paciente_horatencion" name="paciente_horatencion" class="form-control" placeholder="HH:MM" required/>
					</div>
					<div class="col-12 col-md-12">
						<label class="form-label" for="sedeatencion">Sede</label>
						<select class="form-select" name="sedeatencion" id="sedeatencion" required>
							<option value="">Seleccionar</option>
						</select>
					</div>
					<div class="col-12 col-md-12">
						<label class="form-label" for="paciente_diagnostico">Diagnóstico</label>
						<textarea class="form-control" id="paciente_diagnostico" rows="2" placeholder="Ingresar diagnostico" name="paciente_diagnostico" required></textarea>
					</div>
					<div class="col-12 col-md-12">
						<label class="form-label" for="paciente_tratamiento">Tratamiento</label>
						<textarea class="form-control" id="paciente_tratamiento" rows="2" placeholder="Ingresar tratamiento" name="paciente_tratamiento" required></textarea>
					</div>
					<div class="col-12 col-md-12">
						<label class="form-label" for="paciente_observacion">Observación</label>
						<textarea class="form-control" id="paciente_observacion" rows="2" placeholder="Ingresar observacion" name="paciente_observacion" required></textarea>
					</div>
					<div class="col-12 mb-1">
						<label class="form-label" for="documentos">Documentos adicionales</label>
						<input class="form-control" type="file" name="documentos[]" id="documentos" multiple="">
					</div>
					<div class="col-12 text-right mt-2 pt-50">
						<button type="button" id="btn-create-ficha" class="btn btn-info me-1">Guardar</button>
						<button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-label="Close">
						Cancelar
						</button>
					</div>
					</form>
				</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="modals-showedit-ficha" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog modal-lg modal-dialog-centered modal-showedit-ficha">
				<div class="modal-content">
				<div class="modal-header bg-transparent">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body pb-5 px-sm-5 pt-50">
					<div class="text-center mb-2">
					<h1 class="mb-1">ficha de atención</h1>
					</div>
					<form id="editFichaForm" name="editFichaForm" class="row gy-1 pt-75">
						<input type="text" class="d-none" id="ficha_id" name="ficha_id">
						<span for="">PACIENTE</span><hr>
						<div class="col-12 col-md-6">
							<label class="form-label" for="edit_paciente_name">Nombres</label>
							<input type="text" id="edit_paciente_name" name="paciente_name" class="form-control" placeholder="Nombre" data-msg="Ingrese sus nombres" required/>
						</div>
						<div class="col-12 col-md-6">
							<label class="form-label" for="edit_paciente_last_name">Apellidos</label>
							<input type="text" id="edit_paciente_last_name" name="paciente_last_name" class="form-control" placeholder="Apellidos" data-msg="Ingrese sus apellidos" required/>
						</div>
						<div class="col-12 col-md-6">
							<label class="form-label" for="edit_paciente_tipo_documento">Tipo documento</label>
							<select id="edit_paciente_tipo_documento" name="paciente_tipo_documento" class="form-select" aria-label="Seleccionar" required>
								<option value="">Seleccionar</option>
								<option value="1">DNI</option>
								<option value="2" class="d-none">RUC</option>
								<option value="3">Carnet de extranjeria</option>
							</select>
						</div>
						<div class="col-12 col-md-6">
							<label class="form-label" for="edit_paciente_documento">Nro de Documento</label>
							<input type="text" id="edit_paciente_documento" name="paciente_documento" class="form-control modal-edit-tax-id" placeholder="111111111"required />
						</div>
						<div class="col-12 col-md-6">
							<label class="form-label" for="edit_paciente_dateofbirth">Fecha de nacimiento</label>
							<input type="text" id="edit_paciente_dateofbirth" name="paciente_dateofbirth" class="form-control" placeholder="DD-MM-YYYY" required/>
						</div>
						<div class="col-12 col-md-6">
							<label class="form-label" for="edit_paciente_sex">Sexo</label>
							<select id="edit_paciente_sex" name="paciente_sex" class="form-select" required>
								<option value="">Seleccionar</option>
								<option value="1">Masculino</option>
								<option value="2">Femenino</option>
							</select>
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="edit_paciente_address">Dirección</label>
							<textarea class="form-control" id="edit_paciente_address" rows="2" placeholder="Ingresar dirección" name="paciente_address" required></textarea>
						</div>
						<div class="col-12 col-md-6">
							<label class="form-label" for="edit_paciente_phone">Celular</label>
							<input type="text" id="edit_paciente_phone" class="form-control" placeholder="999 999 999" name="paciente_phone" required/>
						</div>
						<div class="col-12 col-md-6">
							<label class="form-label" for="edit_email">Correo</label>
							<input type="email" id="edit_email" class="form-control dt-email" placeholder="john.doe@example.com" name="email" required/>
						</div>
							<span>ATENCIÓN</span><hr>

						<div class="col-12 col-md-6">
							<label class="form-label" for="edit_paciente_tipo_atencion">Tipo de atención</label>
							<select id="edit_paciente_tipo_atencion" name="paciente_tipo_atencion" class="form-select" aria-label="Seleccionar" required>
								<option value="">Seleccionar</option>
								<option value="1">Consulta</option>
								<option value="2">Urgencia</option>
								<option value="3">Emergencia</option>
							<option value="4">Accidente</option>
							</select>
						</div>
						<div class="col-12 col-md-6">
							<label class="form-label" for="edit_paciente_fechatencion">Fecha de atención</label>
							<input type="text" id="edit_paciente_fechatencion" name="paciente_fechatencion" class="form-control" placeholder="DD-MM-YYYY" required/>
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="edit_paciente_diagnostico">Diagnóstico</label>
							<textarea class="form-control" id="edit_paciente_diagnostico" rows="2" placeholder="Ingresar diagnostico" name="paciente_diagnostico" required></textarea>
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="edit_paciente_tratamiento">Tratamiento</label>
							<textarea class="form-control" id="edit_paciente_tratamiento" rows="2" placeholder="Ingresar tratamiento" name="paciente_tratamiento" required></textarea>
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="edit_paciente_observacion">Observación</label>
							<textarea class="form-control" id="edit_paciente_observacion" rows="2" placeholder="Ingresar observacion" name="paciente_observacion" required></textarea>
						</div>
						<div class="col-md-12 mb-1 d-none" id="archivosContainer">
							<div id="accordionIcon" class="accordion accordion-border" data-toggle-hover="true">
								<div class="accordion-item">
									<h2 class="accordion-header text-body d-flex justify-content-between" id="acordionarchives">
									<button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#divArchivos" aria-controls="divArchivos" aria-expanded="false">
										Archivos
									</button>
									</h2>

									<div id="divArchivos" class="accordion-collapse collapse" data-bs-parent="#accordionIcon" style="">
										<div class="accordion-body">
											<table class="table" id="tablearchivos">
												<thead>
													<tr>
														<th>Nombre</th>
														<th>Actions</th>
													</tr>
												</thead>
												<tbody id="bodyarchivos">
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12" id="acorddionModificaciones">
							<div class="accordion accordion-margin"  data-toggle-hover="true">
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingModificaciones">
									<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionModificaciones" aria-expanded="false" aria-controls="accordionModificaciones">
										Modificaciones
									</button>
									</h2>
									<div id="accordionModificaciones" class="accordion-collapse collapse" aria-labelledby="headingModificaciones" data-bs-parent="#accordionMargin" style="">
									<div class="accordion-body">
										<div class="table-responsive">
											<table class="table">
												<thead>
													<tr>
														<th>Fecha</th>
														<th>Campo</th>
														<th>Previo</th>
														<th>Nuevo</th>
														<th>Usuario</th>
													</tr>
												</thead>
												<tbody id="table-modificaciones">
												</tbody>
											</table>
										</div>
									</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 text-right mt-2 pt-50" id="actions-modal">
							<button type="button" id="btn-editar-ficha" class="btn btn-info me-1">Guardar</button>
							<button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-label="Close">
							Cancelar
							</button>
						</div>
					</form>
				</div>
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
	var flatpickdateofbirth;
	var flatpickdateattention;
	var editflatpickdateofbirth;
	var editflatpickdateattention;
	let site_url="<?php echo url('/').'/'; ?>";
$( document ).ready(function() {
	$('#table-users').DataTable();
	flatpickdateofbirth=$("#paciente_dateofbirth").flatpickr({
		altInput: true,
		altFormat: "d-m-Y"
	});
	flatpickdateattention=$("#paciente_fechatencion").flatpickr({
		altInput: true,
		altFormat: "d-m-Y",
		onChange: function(selectedDates, dateStr, instance) {
			v_token = "{{ csrf_token() }}";
			method = 'GET';
			$.ajax({
				url: "{{ route('asignaciondiaria.getfecha') }}/"+dateStr,
				type: "GET",
				data: {_token:v_token,_method:method},
				dataType: 'json',
				success: function(obj){
					if(obj.length==1){
						$("#sedeatencion").html(`<option value="${obj[0].id}" selected>${obj[0].nombre}</option>`);
					}else if(obj.length>1){
						htmlOption = `<option value="" selected>Seleccionar</option>`;
						obj.forEach(element => {
							htmlOption+=`<option value="${element.id}" selected>${element.nombre}</option>`;
						});
						$("#sedeatencion").html(htmlOption);
					}else{
						$("#sedeatencion").html('<option value="" selected>Seleccionar</option>');
						Swal.fire({
							toast: true,
							position: "bottom-end",
							icon: "warning",
							text: "No cuenta con sede asignada en la fecha "+dateStr+".",
							showConfirmButton: false,
							timer: 2500
						});
					}
				}
			});
		}
	});
	
	editflatpickdateofbirth=$("#edit_paciente_dateofbirth").flatpickr({
		altInput: true,
		altFormat: "d-m-Y"
	});
	editflatpickdateattention=$("#edit_paciente_fechatencion").flatpickr({
		altInput: true,
		altFormat: "d-m-Y"
	});
});

dt_ajax = $("#table-fichas").dataTable({
	processing: true,
	ordering: false,
	dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
	ajax: "{{route('fichas.list')}}",
	language: {
		paginate: {
			previous: '&nbsp;',
			next: '&nbsp;'
		}
	},
	columns: [
            { data: 'paciente'},
            { data: 'documento' },
            { data: 'fecha_atencion' },
            { data: 'tipo_atencion' },
            { data: 'usuario' },
            { data: 'actions' }
        ],
	columnDefs: [
		{
			targets: 5,
			className: "text-center"
		}
	],
	drawCallback: function( settings ) {
        feather.replace();
    }
});
$("#btn-create-ficha").on('click',function(){
	isValid = $("#newFichaForm").valid();
	if(isValid){
		var formSerialize = $('#newFichaForm').serialize();
		v_token = "{{ csrf_token() }}";
		formData = new FormData(document.getElementById("newFichaForm"));
		formData.append("_method", "POST");
		formData.append("_token", v_token);
		//v_token = "{{ csrf_token() }}";
		//formSerialize += '&_method=POST&_token='+v_token;
		$.ajax({
			url: "{{route('ficha.create')}}",
			type: "POST",
			data: formData,
			cache:false,
			contentType: false,
			processData: false,
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
					
					$("#modals-add-ficha").modal('hide');
				}
			}
		});
	}
});

$("#paciente_tipo_documento,#paciente_documento").on('change',function(){
	documento = $("#paciente_tipo_documento").val();
	ndocumento = $("#paciente_documento").val().trim();
	if((documento=='1' &&  ndocumento.length==8) || (documento=='2' &&  ndocumento.length>=7)){
		getCliente();
	}
});

$("#table-fichas").on('click','.ficha-show',function(){
	fichaID=$(this).data('fichaid');
	v_token = "{{ csrf_token() }}";
	method = 'GET';
	$.ajax({
		url: "{{ route('ficha.data') }}/"+fichaID,
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
				ficha=obj.ficha;
				$("#actions-modal").addClass('d-none');

				$("#ficha_id").val(ficha.id);
				
				$("#edit_paciente_name").val(ficha.name);
				$("#edit_paciente_last_name").val(ficha.last_name);
				$("#edit_paciente_tipo_documento").val(ficha.document_id);
				$("#edit_paciente_documento").val(ficha.number_document);
				editflatpickdateofbirth.setDate(ficha.date_of_birth);
				$("#edit_paciente_sex").val(ficha.sex);
				$("#edit_paciente_address").val(ficha.address);
				$("#edit_paciente_phone").val(ficha.phone);
				$("#edit_email").val(ficha.email);

				$("#edit_paciente_tipo_atencion").val(ficha.type_of_attention);
				editflatpickdateattention.setDate(ficha.date_of_attention);
				$("#edit_paciente_diagnostico").val(ficha.diagnosis);
				$("#edit_paciente_tratamiento").val(ficha.treatment);
				$("#edit_paciente_observacion").val(ficha.observation);
				archivosFicha=ficha.archivos;
				if(archivosFicha.length>0){
					$("#archivosContainer").removeClass('d-none');
					htmlArchivos=``;
					archivosFicha.forEach(element=>{
						htmlArchivos+=`<tr>
											<td>${element.titulo}</td>
											<td class="text-right">
												<div class="d-inline-flex">
													<a href="${site_url+element.archivo}" target="_blank"><i data-feather="eye"></i></a>
												</div>
											</td>
										</tr>`;
					});
					$("#bodyarchivos").html(htmlArchivos);
					feather.replace();
				}else{
					$("#archivosContainer").addClass('d-none');
					$("#bodyarchivos").html("");
				}

				modificaciones=ficha.modificaciones;
				if(modificaciones.length>0){
					$("#accordionModificaciones").collapse('hide');
					$("#acorddionModificaciones").removeClass('d-none');
					htmlModificaciones = ``;
					modificaciones.forEach(element => {
						htmlModificaciones+=`<tr><td>${element.fecha}</td><td>${element.campo}</td><td>${element.previo}</td><td>${element.nuevo}</td><td>${element.usuario}</td></tr>`
					});
					$("#table-modificaciones").html(htmlModificaciones);
				}else{
					$("#acorddionModificaciones").addClass('d-none');
					$("#table-modificaciones").html('');
				}

				$("#editFichaForm").find('input,select,textarea').prop('disabled',true);
				$("#modals-showedit-ficha").modal("show");
			}
		}
	});
});

$("#table-fichas").on('click','.ficha-edit',function(){
	fichaID=$(this).data('fichaid');
	v_token = "{{ csrf_token() }}";
	method = 'GET';
	$.ajax({
		url: "{{ route('ficha.data') }}/"+fichaID,
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
				ficha=obj.ficha;
				$("#actions-modal").removeClass('d-none');
				$("#ficha_id").val(ficha.id);
				$("#edit_paciente_name").val(ficha.name);
				$("#edit_paciente_last_name").val(ficha.last_name);
				$("#edit_paciente_tipo_documento").val(ficha.document_id);
				$("#edit_paciente_documento").val(ficha.number_document);
				editflatpickdateofbirth.setDate(ficha.date_of_birth);
				$("#edit_paciente_sex").val(ficha.sex);
				$("#edit_paciente_address").val(ficha.address);
				$("#edit_paciente_phone").val(ficha.phone);
				$("#edit_email").val(ficha.email);

				modificaciones=ficha.modificaciones;
				if(modificaciones.length>0){
					$("#accordionModificaciones").collapse('hide');
					$("#acorddionModificaciones").removeClass('d-none');
					htmlModificaciones = ``;
					modificaciones.forEach(element => {
						htmlModificaciones+=`<tr><td>${element.fecha}</td><td>${element.campo}</td><td>${element.previo}</td><td>${element.nuevo}</td><td>${element.usuario}</td></tr>`
					});
					$("#table-modificaciones").html(htmlModificaciones);
				}else{
					$("#acorddionModificaciones").addClass('d-none');
					$("#table-modificaciones").html('');
				}
				$("#edit_paciente_tipo_atencion").val(ficha.type_of_attention);
				editflatpickdateattention.setDate(ficha.date_of_attention);
				$("#edit_paciente_diagnostico").val(ficha.diagnosis);
				$("#edit_paciente_tratamiento").val(ficha.treatment);
				$("#edit_paciente_observacion").val(ficha.observation);

				$("#editFichaForm").find('input,select,textarea').prop('disabled',true);

				$("#edit_paciente_diagnostico,#edit_paciente_tratamiento").prop('disabled',false);
				$("#modals-showedit-ficha").modal("show");
			}
		}
	});
});
$("#btn-editar-ficha").on('click',function(){
	fichaID=$("#ficha_id").val();
	isValid = $("#editFichaForm").valid();
	if(isValid){
		var formSerialize = $('#editFichaForm').serialize();
		v_token = "{{ csrf_token() }}";
		formSerialize += '&_method=PUT&_token='+v_token;

		$.ajax({
			url: "{{route('ficha.update')}}/"+fichaID,
			type: "POST",
			data: formSerialize,
			dataType: 'json',
			success: function(obj){
				if(typeof obj.message === 'object' && obj.message !== null){
					mensaje='';
					Object.values(obj.message).forEach(element => {
						console.log(element);
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
					$("#modals-showedit-ficha").modal('hide');
				}
			}
		});
	}
});




$('#modals-add-ficha').on('hidden.bs.modal', function () {
	$("#newFichaForm").trigger('reset');
});
$('#modals-showedit-ficha').on('hidden.bs.modal', function () {
	$("#editFichaForm").trigger('reset');
});

</script>
@endsection