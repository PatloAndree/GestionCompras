@extends('layouts/contentLayoutMaster')

@section('title', 'Nueva ficha de atención')
@section('page-style')
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
	<style>
		hr {
			    color: #2f2f30!important;
		}
	</style>
@endsection
@section('content')
<!-- Kick start -->
<div class="card">
  	<div class="card-body">
		<div class="card">
			<div class="card-body border-bottom">
				<form id="newFichaForm" name="newFichaForm" class="row gy-1 pt-75" enctype="multipart/form-data">
					<div class="row mb-2">
						<span for=""><strong>PACIENTE</strong></span><hr>
						<div class="col-12 col-md-6">
							<label class="form-label" for="paciente_tipo_documento">Tipo documento</label>
							<select id="paciente_tipo_documento" name="paciente_tipo_documento" class="form-select" aria-label="Seleccionar" required>
								<option value="">Seleccionar</option>
								<option value="1" selected>DNI</option>
								<option value="2" class="d-none">RUC</option>
								<option value="3">Carnet de extranjeria</option>
							</select>
						</div>
						<div class="col-12 col-md-6">
							<label class="form-label" for="paciente_documento">Nro de Documento</label>
							<input type="text" id="paciente_documento" name="paciente_documento" class="form-control modal-edit-tax-id" placeholder="111111111"required />
						</div>
						<div class="col-12 col-md-6">
							<label class="form-label" for="paciente_name">Nombres</label>
							<input type="text" id="paciente_name" name="paciente_name" class="form-control" placeholder="Nombre" data-msg="Ingrese sus nombres" required/>
						</div>
						<div class="col-12 col-md-6">
							<label class="form-label" for="paciente_last_name">Apellidos</label>
							<input type="text" id="paciente_last_name" name="paciente_last_name" class="form-control" placeholder="Apellidos" data-msg="Ingrese sus apellidos" required/>
						</div>
						<div class="col-12 col-md-6">
							<label class="form-label" for="paciente_age">Edad</label>
							<input type="text" id="paciente_age" name="paciente_age" class="form-control" required/>
						</div>
						<div class="col-12 col-md-6">
							<label class="form-label" for="paciente_sex">Genero</label>
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
							<input type="text" id="paciente_phone" class="form-control" placeholder="999 999 999" name="paciente_phone"/>
						</div>
						<div class="col-12 col-md-6">
							<label class="form-label" for="email">Correo</label>
							<input type="email" id="email" class="form-control dt-email" placeholder="john.doe@example.com" name="email"/>
						</div>
						<div class="col-12 col-md-6 d-none div-proxy">
							<label class="form-label" for="proxy_type_document">Tipo documento apoderado</label>
							<select id="proxy_type_document" name="proxy_type_document" class="form-select" aria-label="Seleccionar">
								<option value="" selected>Seleccionar</option>
								<option value="1">DNI</option>
								<option value="2" class="d-none">RUC</option>
								<option value="3">Carnet de extranjeria</option>
							</select>
						</div>
						<div class="col-12 col-md-6 d-none div-proxy">
							<label class="form-label" for="proxy_document">Nro de Documento apoderado</label>
							<input type="text" id="proxy_document" name="proxy_document" class="form-control modal-edit-tax-id" />
						</div>
						<div class="col-12 col-md-12 d-none div-proxy">
							<label class="form-label" for="proxy">Nombre apoderado</label>
							<input type="text" id="proxy" class="form-control" placeholder="" name="proxy"/>
						</div>
						<div class="col">
							<label class="form-label" for="paciente_tipo">Tipo de cliente</label>
							<select id="paciente_tipo" name="paciente_tipo" class="form-select" aria-label="Seleccionar">
								<option value="1" selected>Cliente</option>
								<option value="2">No Cliente</option>
							</select>
						</div>
						<div class="col-12 col-md-12 d-none div-paciente-tipo">
							<label class="form-label" for="paciente_tipo_nombre">Nombre tipo de cliente</label>
							<input type="text" id="paciente_tipo_nombre" class="form-control" name="paciente_tipo_nombre"/>
						</div>
					</div>
					<div class="row">
						<span><strong>ATENCIÓN</strong></span><hr>
						<div class="col-12 col-md-6">
							<label class="form-label" for="date_of_attention">Fecha de atención</label>
							<input type="date" id="date_of_attention" name="date_of_attention" class="form-control" placeholder="DD-MM-YYYY" required/>
						</div>
						<div class="col-12 col-md-3">
							<label class="form-label" for="hour_of_attention_start">Hora inicio</label>
							<input type="time" id="hour_of_attention_start" name="hour_of_attention_start" class="form-control" placeholder="HH:MM" required/>
						</div>
						<div class="col-12 col-md-3">
							<label class="form-label" for="hour_of_attention_end">Hora fin</label>
							<input type="time" id="hour_of_attention_end" name="hour_of_attention_end" class="form-control" placeholder="HH:MM" required/>
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="sede_id">Sede</label>
							<select class="form-select" name="sede_id" id="sede_id" disabled required>
								<option value="">Seleccionar</option>
							</select>
						</div>
						<div class="col">
							<label class="form-label" for="type_of_attention">Tipo de atención</label>
							<select id="type_of_attention" name="type_of_attention" class="form-select" aria-label="Seleccionar" required>
								<option value="">Seleccionar</option>
								<option value="1">Consulta</option>
								<option value="2">Urgencia</option>
								<option value="3">Emergencia</option>
								<option value="4">Accidente</option>
							</select>
						</div>
						<div class="col-12 col-md-8 div-lugar-atencion d-none">
							<label class="form-label" for="accident_location">Lugar del accidente</label>
							<input type="text" id="accident_location" name="accident_location" class="form-control"/>
						</div>
					</div>
					<div class="row mb-2">
						<div class="col-12 col-md-12">
							<label class="form-label" for="first_aid">Causa de la atención de primeros auxilios</label>
							<input type="text" id="first_aid" name="first_aid" class="form-control" required/>
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="allergies">Alergias a medicamentos</label>
							<input type="text" id="allergies" name="allergies" class="form-control" required/>
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="personal_history">Antecedentes personales</label>
							<input type="text" id="personal_history" name="personal_history" class="form-control" required/>
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="anamesis">Anamesis (Descripción de lo susedido):</label>
							<textarea class="form-control" id="anamesis" rows="2" placeholder="Ingresar tratamiento" name="anamesis" required></textarea>
						</div>
					</div>
					<div class="row mb-2">
						<span><strong>EVALUACIÓN PRIMARIA</strong></span><hr>
						<div class="col">
							<label class="form-label" for="blood_pressure_start">PA (mmHg)</label>
							<input type="text" id="blood_pressure_start" name="blood_pressure_start" class="form-control" required/>
						</div>
						<div class="col">
							<label class="form-label" for="temperature_start">T° (°C)</label>
							<input type="text" id="temperature_start" name="temperature_start" class="form-control" required/>
						</div>
						<div class="col">
							<label class="form-label" for="oxygen_saturation_start">SPO (%)</label>
							<input type="text" id="oxygen_saturation_start" name="oxygen_saturation_start" class="form-control" required/>
						</div>
						<div class="col">
							<label class="form-label" for="heart_rate_start">FC (x min)</label>
							<input type="text" id="heart_rate_start" name="heart_rate_start" class="form-control" required/>
						</div>
						<div class="col">
							<label class="form-label" for="breathing_frequency_start">FR (x min)</label>
							<input type="text" id="breathing_frequency_start" name="breathing_frequency_start" class="form-control" required/>
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="presumptive_diagnosis">Diagnóstico presuntivo</label>
							<textarea class="form-control" id="presumptive_diagnosis" rows="2" name="presumptive_diagnosis" required></textarea>
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="treatment">Tratamiento</label>
							<textarea class="form-control" id="treatment" rows="2" name="treatment" required></textarea>
						</div>
					</div>
					<div class="row mb-2">
						<span><strong>EVALUACIÓN SECUNDARIA</strong></span><hr>
						<div class="col">
							<label class="form-label" for="blood_pressure_end">PA (mmHg)</label>
							<input type="text" id="blood_pressure_end" name="blood_pressure_end" class="form-control" required/>
						</div>
						<div class="col">
							<label class="form-label" for="temperature_end">T° (°C)</label>
							<input type="text" id="temperature_end" name="temperature_end" class="form-control" required/>
						</div>
						<div class="col">
							<label class="form-label" for="oxygen_saturation_end">SPO (%)</label>
							<input type="text" id="oxygen_saturation_end" name="oxygen_saturation_end" class="form-control" required/>
						</div>
						<div class="col">
							<label class="form-label" for="heart_rate_end">FC (x min)</label>
							<input type="text" id="heart_rate_end" name="heart_rate_end" class="form-control" required/>
						</div>
						<div class="col">
							<label class="form-label" for="breathing_frequency_end">FR (x min)</label>
							<input type="text" id="breathing_frequency_end" name="breathing_frequency_end" class="form-control" required/>
						</div>
						<div class="col-12 mt-1 mb-1">
							<label>Traslado : </label>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="transfer_sw" id="transfer_sw_no" value="0" checked="">
								<label class="form-check-label" for="transfer_sw_no">NO</label>
							</div>	
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="transfer_sw" id="transfer_sw_si" value="1">
								<label class="form-check-label" for="transfer_sw_si">SI</label>
							</div>
						</div>
						<div class="col-12 col-md-6 divtraslado d-none">
							<div class="form-group">
								<label class="form-label" for="transfer_destiny">Destino</label>
								<select class="form-select" name="transfer_destiny" id="transfer_destiny">
									<option value="">Seleccionar</option>
									<option value="1">Hospital</option>
									<option value="2">Clínica afiliada</option>
									<option value="3">Clínica particular </option>
								</select>
							</div>
						</div>
						<div class="col-12 col-md-6 divtraslado d-none">
							<div class="form-group">
								<label class="form-label" for="transfer_external_support">Apoyo externo</label>
								<select class="form-select" name="transfer_external_support" id="transfer_external_support" >
									<option value="">Seleccionar</option>
									<option value="1">Bomberos</option>
									<option value="2">Particular</option>
									<option value="3">Taxí</option>
									<option value="4">Ambulancia Perú Medical</option>
								</select>
							</div>
						</div>
						<div class="col-12 col-md-12">
							<label class="form-label" for="observation">Observación</label>
							<textarea class="form-control" id="observation" rows="2" placeholder="Ingresar observacion" name="observation"></textarea>
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
					</div>
				</form>
			</div>
		</div>
  	</div>
</div>
@endsection
@section('page-script')
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script>
	let site_url="<?php echo url('/').'/'; ?>";
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
						window.location.href = "{{route('fichas.index')}}";
						$("#modals-add-ficha").modal('hide');
					}
				}
			});
		}
	});
	$('input[type=radio][name=transfer_sw]').change(function() {
		valor=$(this).val();
		if(valor==1){
			$(".divtraslado").removeClass('d-none');
			$("#transfer_destiny").prop('required',true);
			$("#transfer_external_support").prop('required',true);
		}else{
			$(".divtraslado").addClass('d-none');
			$("#transfer_destiny").prop('required',false);
			$("#transfer_external_support").prop('required',false);
		}
	})
	$("#type_of_attention").on('change',function(){
		valorInput=$(this).val();
		if(valorInput==4){
			$(".div-lugar-atencion").removeClass('d-none');
			$("#accident_location").prop('required',true);
		}else{
			$(".div-lugar-atencion").addClass('d-none');
			$("#accident_location").prop('required',false);
		}
	});
	$("#paciente_tipo").on('change',function(){
		if($(this).val()==2){
			$(".div-paciente-tipo").removeClass('d-none');
			$("#paciente_tipo_nombre").prop('required',true);
		}else{
			$(".div-paciente-tipo").addClass('d-none');
			$("#paciente_tipo_nombre").prop('required',false);
		}
	});
	$("#paciente_tipo_documento,#paciente_documento").on('change',function(){
		documento = $("#paciente_tipo_documento").val();
		ndocumento = $("#paciente_documento").val().trim();
		if((documento=='1' &&  ndocumento.length==8) || (documento=='2' &&  ndocumento.length>=7)){
			getCliente();
		}
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
					$("#edit_type_of_attention").val(ficha.type_of_attention);
					editflatpickdateattention.setDate(ficha.date_of_attention);
					$("#edit_paciente_diagnostico").val(ficha.diagnosis);
					$("#edit_treatment").val(ficha.treatment);
					$("#edit_observation").val(ficha.observation);

					$("#editFichaForm").find('input,select,textarea').prop('disabled',true);

					$("#edit_paciente_diagnostico,#edit_treatment").prop('disabled',false);
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

	$("#date_of_attention").on('blur',function(){
		dateStr=$(this).val().trim();
		if(dateStr!=''){
			v_token = "{{ csrf_token() }}";
			method = 'GET';
			$.ajax({
				url: "{{ route('asignaciondiaria.getfecha') }}/"+dateStr,
				type: "GET",
				data: {_token:v_token,_method:method},
				dataType: 'json',
				success: function(obj){
					if(obj.length==1){
						$("#sede_id").html(`<option value="${obj[0].id}" selected>${obj[0].nombre}</option>`);
						$("#sede_id").prop('disabled',false);
					}else if(obj.length>1){
						htmlOption = `<option value="" selected>Seleccionar</option>`;
						obj.forEach(element => {
							htmlOption+=`<option value="${element.id}" selected>${element.nombre}</option>`;
						});
						$("#sede_id").html(htmlOption);
						$("#sede_id").prop('disabled',false);
					}else{
						$("#sede_id").html('<option value="" selected>Seleccionar</option>');
						$("#sede_id").prop('disabled',true);
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

	function getCliente(){
		documento = $("#paciente_tipo_documento").val();
		ndocumento = $("#paciente_documento").val().trim();
		$.ajax({
			url: "{{route('paciente.data')}}"+"/"+documento+"/"+ndocumento,
			type: "GET",
			data: {},
			dataType: 'json',
			success: function(obj){
				if(obj){
					$("#paciente_name").val(obj.name);
					$("#paciente_last_name").val(obj.last_name);
					$("#paciente_age").val(obj.age);
					$("#paciente_sex").val(obj.sex);
					$("#paciente_address").val(obj.address);
					$("#paciente_phone").val(obj.phone);
					$("#email").val(obj.email);
				}else{
					Swal.fire({
						toast: true,
						position: "bottom-end",
						icon: "warning",
						text: "cliente no identificado.",
						showConfirmButton: false,
						timer: 2500
					});
				}
			}
		});
	}
	function getApoderado(){
		documento = $("#proxy_type_document").val();
		ndocumento = $("#proxy_document").val().trim();
		$.ajax({
			url: "{{route('paciente.data')}}"+"/"+documento+"/"+ndocumento,
			type: "GET",
			data: {},
			dataType: 'json',
			success: function(obj){
				if(obj){
					$("#proxy").val(obj.name+' '+obj.last_name);
				}else{
					Swal.fire({
						toast: true,
						position: "bottom-end",
						icon: "warning",
						text: "Apoderado no identificado.",
						showConfirmButton: false,
						timer: 2500
					});
				}
			}
		});
	}

	$('#modals-add-ficha').on('hidden.bs.modal', function () {
		$("#newFichaForm").trigger('reset');
	});
	$('#modals-showedit-ficha').on('hidden.bs.modal', function () {
		$("#editFichaForm").trigger('reset');
	});
	$("#paciente_age").on('change',function(){
		valor=$(this).val();
		if(valor!='' && valor<18){
			$(".div-proxy").removeClass('d-none');
			$(".div-proxy").find('input').prop('required',true);
			$(".div-proxy").find('select').prop('required',true);
		}else{
			$(".div-proxy").addClass('d-none');
			$(".div-proxy").find('input').prop('required',false);
			$(".div-proxy").find('select').prop('required',false);
		}
	});
	$("#proxy_type_document,#proxy_document").on('change',function(){
		documento = $("#proxy_type_document").val();
		ndocumento = $("#proxy_document").val().trim();
		if((documento=='1' &&  ndocumento.length==8) || (documento=='2' &&  ndocumento.length>=7)){
			getApoderado();
		}
	});

</script>
@endsection