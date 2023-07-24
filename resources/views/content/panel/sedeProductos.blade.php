@extends('layouts/contentLayoutMaster')

	@section('page-style')
		<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
		<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
		<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
		<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
   	 	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">

		<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
		<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
		<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
		<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
		<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
	@endsection
@section('content')
<!-- Kick start -->

	@if ($sede_id!=0)
		<div class="card">
			<div class="card-header">
			<h2>Editar Sede</h2>

			</div>
				<div class="card-body">
					<form action="" name="form-update" id="form-update" enctype="multipart/form-data">
						<div class="row">
						<input type="text" class="form-control d-none" id="sede_id" value="<?php echo $sedes['id'];?>"  placeholder="" name="sede_id" readonly/>
							
									<div class="col-md-6 mb-1">
										<label class="form-label" for="update_sede_name">Nombre</label>
										<input type="text" class="form-control dt-full-name" id="update_sede_name" name="sede_name"
										value="<?php echo $sedes['nombre'];?>"
										required/>
									</div>

									<div class="col-md-6 mb-1">
										<label class="form-label" for="sede_departamento">Departamento</label>
										<select id="sede_departamento" name="sede_departamento" class="form-select" required>
											<option value="">Seleccionar</option>
											@foreach ($departamentos as $departamento)
												<option value="{{$departamento->id}}"  <?php if($departamento->id ==  $sedes['departamento_id']) { echo 'selected';}?>>{{$departamento->nombre_ubigeo}}</option>
											@endforeach
										</select>
									</div>
									
									<div class="col-md-6 mb-1">
										<label class="form-label" for="sede_provincia">Provincia</label>
										<select id="sede_provincia" name="sede_provincia" class="form-select" required>
											<option value="">Seleccionar</option>
											@foreach ($provincias as $provincia)
												<option value="{{$provincia->id}}" 
												<?php if($provincia->id ==  $sedes['provincias_id']) { echo 'selected';}?>
												>{{$provincia->nombre_ubigeo}}</option>

											@endforeach
										</select>
									</div>	
									<div class="col-md-6 mb-1">
										<label class="form-label" for="sede_distrito">Distrito</label>
										<select id="sede_distrito" name="sede_distrito" class="form-select" required>
											<option value="">Seleccionar</option>
											@foreach ($distritos as $distrito)
												<option value="{{$distrito->id}}" 
												<?php if($distrito->id ==  $sedes['distritos_id']) { echo 'selected';}?>
												>{{$distrito->nombre_ubigeo}}</option>
											@endforeach

										</select>
									</div>
									<div class="mb-1">
										<label class="form-label" for="update_sede_direccion">Dirección</label>
										<textarea class="form-control" id="update_sede_direccion" rows="2" placeholder="Ingresar dirección" 
										name="sede_direccion"> <?php echo $sedes['direccion'];?>
									</textarea>
									</div>
									<div class="mb-1">
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="checkbox" id="update_sede_sw_ambulancia" name="sede_sw_ambulancia" value="checked" >
											<label class="form-check-label" for="update_sede_sw_ambulancia">¿Es una ambulancia?</label>
										</div>
									</div>
									<div class="col-md-6 mb-1">
										<label class="form-label" for="sede_apertura1">Apertura</label>
										<input type="text" id="sede_apertura1" name="sede_apertura1" class="form-control" placeholder="HH:mm" 
										value="<?php echo $sedes['apertura'];?>"
										required/>
									</div>
									<div class="col-md-6 mb-1">
										<label class="form-label" for="sede_cierre1">Cierre</label>
										<input type="text" id="sede_cierre1" name="sede_cierre1" class="form-control" placeholder="HH:mm"
										value="<?php echo $sedes['cierre'];?>"	
										required/>
									</div>

									<div class="col-md-12 mb-1">
										<div id="accordionSedes" class="accordion accordion-border" data-toggle-hover="true">
											<div class="accordion-item">
												<h2 class="accordion-header text-body d-flex justify-content-between">
												<button type="button" class="accordion-button" aria-controls="divsedes" aria-expanded="true">
													<strong>Asignar horarios</strong>
												</button>
												</h2>

												<div id="divsedes" class="accordion-collapse collapse show" >
													<div class="accordion-body">
														<select class="select2-size-lg form-select" multiple="multiple" name="sedesHorarios[]" id="selectHorarios">
															@foreach ($horarios as $horario)
																<option value="{{$horario['id']}}" <?php if(in_array($horario['id'],$sedes['horaid'])) { echo 'selected';}?> >{{$horario['entrada'].' - '.$horario['salida'] }}</option>
															@endforeach
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
							<div class="mb-1 d-none">
								<label class="form-label" for="update_sede_id">ID</label>
								<input type="text" id="update_sede_id" class="form-control" required/>
							</div>	
					
						</div>
					
						<div class="row mt-3">
							<div class="col-md-12 text-right">
								<button type="button" class="btn btn-info me-1" id="update-sede">Editar</button>
							</div>
						</div>
					</form>
		</div>
	@else
	<div class="card">
			<div class="card-header">
				<h2>Crear Sede</h2>
			</div>
				<div class="card-body">
					<form action="" name="form-new-user" id="form-update-sede" enctype="multipart/form-data">
						<div class="row">

						<input type="text" class="form-control d-none" id="user_id" value=""  placeholder="" name="user_id" readonly/>
							
									<div class="col-md-6 mb-1">
										<label class="form-label" for="sede_name">Nombre</label>
										<input type="text" class="form-control dt-full-name" id="sede_name" name="sede_name"
										value=""
										required/>
									</div>

									<div class="col-md-6 mb-1">
										<label class="form-label" for="sede_departamento">Departamento</label>
										<select id="sede_departamento" name="sede_departamento" class="form-select" required>
											<option value="">Seleccionar</option>
											@foreach ($departamentos as $departamento)
												<option value="{{$departamento->id}}">{{$departamento->nombre_ubigeo}}</option>
											@endforeach
											
										</select>
									</div>
									
									
									<div class="col-md-6 mb-1">
										<label class="form-label" for="sede_provincia">Provincia</label>
										<select id="sede_provincia" name="sede_provincia" class="form-select" disabled required>
											<option value="">Seleccionar</option>
											
										</select>
									</div>
									<div class="col-md-6 mb-1">
										<label class="form-label" for="sede_distrito">Distrito</label>
										<select id="sede_distrito" name="sede_distrito" class="form-select"  disabled required>
											<option value="">Seleccionar</option>
										

										</select>
									</div>
									<div class="mb-1">
										<label class="form-label" for="sede_direccion">Dirección</label>
										<textarea class="form-control" id="sede_direccion" rows="2" placeholder="Ingresar dirección" 
										name="sede_direccion"> 
									</textarea>
									</div>
									<div class="mb-1">
										<div class="form-check form-check-inline">
											<input class="form-check-input" type="checkbox" id="sede_sw_ambulancia" name="sede_sw_ambulancia" value="checked" >
											<label class="form-check-label" for="sede_sw_ambulancia">¿Es una ambulancia?</label>
										</div>
									</div>
									<div class="col-md-6 mb-1">
										<label class="form-label" for="sede_apertura">Apertura</label>
										<input type="text" id="sede_apertura" name="sede_apertura" class="form-control" placeholder="HH:mm" 
										value=""
										required/>
									</div>
									<div class="col-md-6 mb-1">
										<label class="form-label" for="sede_cierre">Cierre</label>
										<input type="text" id="sede_cierre" name="sede_cierre" class="form-control" placeholder="HH:mm"
										value=""	
										required/>
									</div>

									<div class="col-md-12 mb-1">
										<div id="accordionSedes" class="accordion accordion-border" data-toggle-hover="true">
											<div class="accordion-item">
												<h2 class="accordion-header text-body d-flex justify-content-between">
												<button type="button" class="accordion-button" aria-controls="divsedes" aria-expanded="true">
													<strong>Asignar horarios</strong>
												</button>
												</h2>

												<div id="divsedes" class="accordion-collapse collapse show" >
													<div class="accordion-body">
														<select class="select2-size-lg form-select" multiple="multiple" name="sedesHorarios[]" id="selectHorarios">
															@foreach ($horarios as $horario)
																<option value="{{$horario['id']}}" >{{$horario['entrada'].' - '.$horario['salida'] }}</option>
															@endforeach
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>

							<div class="mb-1 d-none">
								<label class="form-label" for="update_sede_id">ID</label>
								<input type="text" id="update_sede_id" class="form-control" required/>
							</div>	
					
						</div>
					
						<div class="row mt-3">
							<div class="col-md-12 text-right">
								<button type="button" class="btn btn-info me-1" id="add-new-sede">Guardar</button>
							</div>
						</div>
				</form>
	</div>
		@endif
@endsection
@section('page-script')
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>


<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>


<!-- <script src="{{ asset('js/scripts/multiselect/jquery.multi-select.js') }}"></script> -->
<!-- <script src="{{ asset('js/scripts/multiselect/jquery.quicksearch.min.js') }}"></script> -->

<script>

	// var flatpickredit;
	// var flatpickreditcontratacion;
	
	$(window).on('load', function() {
	$('#table-users').DataTable();

	$("#sede_apertura").flatpickr({
        enableTime: !0,
        noCalendar: !0
	});
	$("#sede_cerre").flatpickr({
        enableTime: !0,
        noCalendar: !0
	});
	$("#sede_apertura1").flatpickr({
        enableTime: !0,
        noCalendar: !0
	});
	$("#sede_cerre1").flatpickr({
        enableTime: !0,
        noCalendar: !0
	});

	aperturaFlatpickr = $("#sede_apertura").flatpickr({
        enableTime: !0,
        noCalendar: !0
	});
	cierreFlatpickr = $("#sede_cierre").flatpickr({
        enableTime: !0,
        noCalendar: !0
	});
	aperturaFlatpickr = $("#sede_apertura1").flatpickr({
        enableTime: !0,
        noCalendar: !0
	});
	cierreFlatpickr = $("#sede_cierre1").flatpickr({
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

	$("#add-new-sede").on('click',function(){
		isValid = $("#form-update-sede").valid();
		if(isValid){
			var formSerialize = $('#form-update-sede').serialize();
			v_token = "{{ csrf_token() }}";
			formData = new FormData(document.getElementById("form-update-sede"));
			formData.append("_method", "POST");
			formData.append("_token", v_token);
			$.ajax({
				url: "{{route('sede.create')}}",
				type: "POST",
				data: formData,
				cache:false,
				contentType: false,
				processData: false,
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
						console.log("saliendo");
						setTimeout(() => {
							window.location.href = "{{route('sedes.index')}}";
						}, 2500);
						

					}
				}
			});
		}
	});

	$("#update-sede").on('click',function(){
		sedeID=$("#sede_id").val();
		console.log(sedeID);
		isValid = $("#form-update").valid();
		if(isValid){
			var formSerialize = $('#form-update').serialize();
			v_token = "{{ csrf_token() }}";
			formData = new FormData(document.getElementById("form-update"));
			console.log(formData);
			formData.append("_method", "POST");
			formData.append("_token", v_token);
			$.ajax({
				url: "{{ route('sede.update') }}/"+sedeID,
				type: "POST",
				data: formData,
				cache:false,
				contentType: false,
				processData: false,
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
						
						setTimeout(() => {
							window.location.href = "{{route('sedes.index')}}";
						}, 2500);
						

					}
				}
			});
		}
	});

	$("#table-users").on('click','.sede-delete', function(){
		sedeID=$("#sede_id").val();
		Swal.fire({
			title: "Estas seguro de eliminar está sede ?",
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
							location.reload();
						}
					}
				});
			}
		}))
	});


	$("#selectSedes").wrap('<div class="position-relative"></div>');
	// $("#selectSedes").select2(
	// {
	// 	dropdownAutoWidth: true,
	// 	width: "100%",
	// 	dropdownParent: $("#selectSedes").parent(),
	// 	containerCssClass: "select-lg"
	// });

	$("#selectHorarios").wrap('<div class="position-relative"></div>');
	$("#selectHorarios").select2(
	{
		dropdownAutoWidth: true,
		width: "100%",
		dropdownParent: $("#selectHorarios").parent(),
		containerCssClass: "select-lg"
	});

	


</script>
@endsection