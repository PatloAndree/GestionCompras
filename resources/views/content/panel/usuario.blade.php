@extends('layouts/contentLayoutMaster')

	@section('page-style')
		<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
		<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
		<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
	@endsection
@section('content')
<!-- Kick start -->
<div class="card">
	<div class="card-header">
		@if ($user_id==0)
			<h2>Creación de usuario</h2>
		@else
			<h2>Edición de usuario</h2>
		@endif
	</div>
	@if ($user_id==0)
		<div class="card-body">
			<form action="" name="form-new-user" id="form-new-user" enctype="multipart/form-data">
				<div class="row">
					<div class="col-12 col-md-6 mb-1">
						<label class="form-label" for="user_name">Nombres</label>
						<input type="text" class="form-control dt-full-name" id="user_name" placeholder="Ingrese sus nombres" name="user_name" required/>
					</div>
					<div class="col-12 col-md-6 mb-1">
						<label class="form-label" for="user_lastname">Apellidos</label>
						<input type="text" id="user_lastname" class="form-control dt-uname" placeholder="Ingrese sus apellidos" name="user_lastname" required/>
					</div>
					<div class="col-12 col-md-6 mb-1">
						<label class="form-label" for="user_document">Documento</label>
						<select id="user_document" name="user_document" class="form-select" required>
							<option value="">Seleccionar</option>
							<option value="1">DNI</option>
							<option value="2" class="d-none">RUC</option>
							<option value="3">Carnet de extranjeria</option>
						</select>
					</div>
					<div class="col-12 col-md-6 mb-1">
						<label class="form-label" for="user_numbredocument">Numero documento</label>
						<input type="text" id="user_numbredocument" class="form-control dt-uname" placeholder="Ingrese su numero de documento" name="user_numbredocument" required/>
					</div>
					<div class="col-12 col-md-6 mb-1">
						<label class="form-label" for="user_dateofbirth">Fecha de nacimiento</label>
						<input type="text" id="user_dateofbirth" name="user_dateofbirth" class="form-control" placeholder="DD-MM-YYYY" required/>
					</div>
					<div class="col-12 col-md-6 mb-1">
						<label class="form-label" for="user_sex">Sexo</label>
						<select id="user_sex" name="user_sex" class="form-select" required>
							<option value="">Seleccionar</option>
							<option value="1">Masculino</option>
							<option value="2">Femenino</option>
						</select>
					</div>
					<div class="col-12 mb-1">
						<label class="form-label" for="user_address">Dirección</label>
						<textarea class="form-control" id="user_address" rows="2" placeholder="Ingresar dirección" name="user_address" required></textarea>
					</div>
					<div class="col-12 col-md-6 mb-1">
						<label class="form-label" for="user_phone">Celular</label>
						<input type="text" id="user_phone" class="form-control" placeholder="999 999 999" name="user_phone" required/>
					</div>
					<div class="col-12 col-md-6 mb-1">
						<label class="form-label" for="email">Correo</label>
						<input type="email" id="email" class="form-control dt-email" placeholder="john.doe@example.com" name="email" required/>
					</div>
					<div class="col-12 mb-1">
						<label class="form-label" for="user_hiring">Fecha de contratación</label>
						<input type="text" id="user_hiring" name="user_hiring" class="form-control" placeholder="DD-MM-YYYY" required/>
					</div>
					<div class="col-12 col-md-6 mb-1">
						<label class="form-label" for="user_type">Tipo Usuario</label>
						<select id="user_type" name="user_type" class="form-select" required>
							<option value="">Seleccionar</option>
							<option value="1">Administrador</option>
							<option value="6">Supervisor</option>
							<option value="5">Call center</option>
							<option value="2">Enfermero</option>
							<option value="3">Doctor</option>
							<option value="4">Conductor</option>
						</select>
					</div>
					<div class="col-12 col-md-6 mb-1">
						<label class="form-label" for="user_factor">Factor</label>
						<input type="text" id="user_factor" class="form-control" name="user_factor" required/>
					</div>
					<div class="col-12 col-md-6 mb-1">
						<label class="form-label" for="user_cuentabancaria">Cuenta bancaria</label>
						<input type="text" id="user_cuentabancaria" class="form-control" name="user_cuentabancaria"/>
					</div>
					<div class="col-12 col-md-6 mb-1">
						<label class="form-label" for="user_cuentainterbancaria">Cuenta Interbancaria</label>
						<input type="text" id="user_cuentainterbancaria" class="form-control" name="user_cuentainterbancaria"/>
					</div>
					<div class="col-12 mb-1">
						<label class="form-label" for="user_documents">Documentos adicionales</label>
						<input class="form-control" type="file" name="user_documents[]" id="user_documents" multiple />
					</div>
					<div class="col-md-12 mb-1">
						<div id="accordionSedes" class="accordion accordion-border" data-toggle-hover="true">
							<div class="accordion-item">
								<h2 class="accordion-header text-body d-flex justify-content-between">
								<button type="button" class="accordion-button" aria-controls="divsedes" aria-expanded="true">
									<strong>Asignar Sedes</strong>
								</button>
								</h2>

								<div id="divsedes" class="accordion-collapse collapse show" >
									<div class="accordion-body">
										<select class="select2-size-lg form-select" multiple="multiple" name="sedesusuarios[]" id="selectSedes">
											@foreach ($sedes as $sede)
												<option value="{{$sede['id']}}" >{{$sede['provincia'].', '.$sede['distrito'].' ['.$sede['name'].']'}}</option>
											@endforeach
										</select>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-md-12 text-right">
						<button type="button" class="btn btn-info me-1" id="add-new-user">Guardar</button>
					</div>
				</div>
			</form>
		</div>
	@else
		<div class="card-body">
			<form class="modal-content pt-0" name="form-update-user" id="form-update-user"  enctype="multipart/form-data">
				<div class="modal-body flex-grow-1">
					<div class="row">
						<div class="col-12 col-md-6 mb-1">
							<label class="form-label" for="edit_user_name">Nombres</label>
							<input type="text" class="form-control dt-full-name" id="edit_user_name" placeholder="Ingrese sus nombres" value="<?php echo $user['name'];?>" name="user_name" required/>
						</div>
						<div class="col-12 col-md-6 mb-1">
							<label class="form-label" for="edit_user_lastname">Apellidos</label>
							<input type="text" id="edit_user_lastname" class="form-control dt-uname" placeholder="Ingrese sus apellidos" value="<?php echo $user['last_name'];?>" name="user_lastname" required/>
						</div>
						<div class="col-12 col-md-6 mb-1">
							<label class="form-label" for="edit_user_document">Documento</label>
							<select id="edit_user_document" name="user_document" class="form-select" required>
								<option value="">Seleccionar</option>
								<option value="1" <?php if($user['document_id'] == 1){ echo 'selected';}?>>DNI</option>
								<option value="2" class="d-none" <?php if($user['document_id'] == 2){ echo 'selected';}?>>RUC</option>
								<option value="3" <?php if($user['document_id'] == 3) {echo 'selected';}?>>Carnet de extranjeria</option>
							</select>
						</div>
						<div class="col-12 col-md-6 mb-1">
							<label class="form-label" for="edit_user_numbredocument">Numero documento</label>
							<input type="text" id="edit_user_numbredocument" class="form-control dt-uname" placeholder="Ingrese su numero de documento" value="<?php echo $user['number_document'];?>" name="user_numbredocument" required/>
						</div>
						<div class="col-12 col-md-6 mb-1">
							<label class="form-label" for="edit_user_dateofbirth">Fecha de nacimiento</label>
							<input type="text" id="edit_user_dateofbirth" name="user_dateofbirth" class="form-control" placeholder="DD-MM-YYYY" value="<?php echo $user['date_of_birth'];?>" required/>
						</div>
						<div class="col-12 col-md-6 mb-1">
							<label class="form-label" for="edit_user_sex">Sexo</label>
							<select id="edit_user_sex" name="user_sex" class="form-select" required>
								<option value="">Seleccionar</option>
								<option value="1" <?php if($user['sex'] == 1) {echo 'selected';}?>>Masculino</option>
								<option value="2" <?php if($user['sex'] == 2) {echo 'selected';}?>>Femenino</option>
							</select>
						</div>
						<div class="col-12 mb-1">
							<label class="form-label" for="edit_user_address">Dirección</label>
							<textarea class="form-control" id="edit_user_address" rows="2" placeholder="Ingresar dirección" name="user_address" required><?php echo $user['address'];?></textarea>
						</div>
						<div class="col-12 col-md-6 mb-1">
							<label class="form-label" for="edit_user_phone">Celular</label>
							<input type="text" id="edit_user_phone" class="form-control" placeholder="999 999 999" value="<?php echo $user['phone'];?>" name="user_phone" required/>
						</div>
						<div class="col-12 col-md-6 mb-1">
							<label class="form-label" for="edit_email">Correo</label>
							<input type="email" id="edit_email" class="form-control dt-email" placeholder="john.doe@example.com" value="<?php echo $user['email'];?>" name="email" required/>
						</div>
						
						<div class="col-12 mb-1">
							<label class="form-label" for="edit_user_hiring">Fecha de contratación</label>
							<input type="text" id="edit_user_hiring" name="user_hiring" class="form-control" placeholder="DD-MM-YYYY" value="<?php echo $user['date_of_hiring'];?>" required/>
						</div>
						<div class="col-12 col-md-6 mb-1">
							<label class="form-label" for="edit_user_type">Tipo Usuario</label>
							<select id="edit_user_type" name="user_type" class="form-select" required>
								<option value="">Seleccionar</option>
								<option value="1" <?php if($user['type'] == 1) {echo 'selected';}?>>Administrador</option>
								<option value="6" <?php if($user['type'] == 6) {echo 'selected';}?>>Supervisor</option>
								<option value="5" <?php if($user['type'] == 5) {echo 'selected';}?>>Call center</option>
								<option value="2" <?php if($user['type'] == 2) {echo 'selected';}?>>Enfermero</option>
								<option value="3" <?php if($user['type'] == 3) {echo 'selected';}?>>Doctor</option>
								<option value="4" <?php if($user['type'] == 4) {echo 'selected';}?>>Conductor</option>
							</select>
						</div>
						<div class="col-12 col-md-6 mb-1">
							<label class="form-label" for="edit_user_factor">Factor</label>
							<input type="text" id="edit_user_factor" class="form-control" name="user_factor" value="<?php echo $user['factor'];?>" required/>
						</div>
						<div class="col-12 mb-1">
							<label class="form-check-label mb-50" for="edit_user_sw_factor_variant">Variante de factor</label>
							<div class="form-check form-check-info form-switch">
								<input type="checkbox" class="form-check-input" name="user_sw_factor_variant" id="edit_user_sw_factor_variant" <?php if($user['sw_factor_variant'] == 1) {echo 'checked';}?>/>
							</div>
						</div>
						<div class="col-12 <?php if($user['sw_factor_variant']==0){ echo 'd-none';}?>" id="divfactor_variante">
							<label class="form-label" for="edit_user_factor_variant">Factor variante</label>
							<input type="text" id="edit_user_factor_variant" class="form-control" name="user_factor_variant" value="<?php echo $user['factor_variant'];?>" required/>
						</div>
						<div class="col-12 d-none">
							<label class="form-label" for="edit_user_id">ID</label>
							<input type="text" id="edit_user_id" class="form-control" value="<?php echo $user['id'];?>" required/>
						</div>
						<div class="col-12 col-md-6 mb-1">
							<label class="form-label" for="edit_user_cuentabancaria">Cuenta bancaria</label>
							<input type="text" id="edit_user_cuentabancaria" class="form-control" value="<?php echo $user['cuentabancaria'];?>" name="user_cuentabancaria"/>
						</div>
						<div class="col-12 col-md-6 mb-1">
							<label class="form-label" for="edit_user_cuentainterbancaria">Cuenta Interbancaria</label>
							<input type="text" id="edit_user_cuentainterbancaria" class="form-control" value="<?php echo $user['cuentainterbancaria'];?>" name="user_cuentainterbancaria"/>
						</div>
						
						<div class="col-12 mb-1">
							<label class="form-label" for="edit_user_documents">Documentos adicionales</label>
							<input class="form-control" type="file" name="user_documents[]" id="edit_user_documents" multiple />
						</div>
						@if (count($user['archivos'])>0)
							<div class="col-md-12 mb-1">
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
														@foreach ($user['archivos'] as $archivo)
															<tr>
																<td><?php echo $archivo->titulo;?></td>
																<td class="text-right">
																	<div class="d-inline-flex">
																		<a href="<?php echo asset('storage/files/'.$archivo->archivo.'');?>" target="_blank"><i data-feather="eye"></i></a>
																	</div>
																</td>
															</tr>
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						@endif

						<div class="col-md-12 mb-1">
							<div id="accordionSedes" class="accordion accordion-border" data-toggle-hover="true">
								<div class="accordion-item">
									<h2 class="accordion-header text-body d-flex justify-content-between">
									<button type="button" class="accordion-button" aria-controls="divsedes" aria-expanded="true">
										<strong>Asignar Sedes</strong>
									</button>
									</h2>

									<div id="divsedes" class="accordion-collapse collapse show" >
										<div class="accordion-body">
											<select class="select2-size-lg form-select" multiple="multiple" name="sedesusuarios[]" id="selectSedes">
												@foreach ($sedes as $sede)
													<option value="{{$sede['id']}}" <?php if(in_array($sede['id'], $user['sedes'])) { echo 'selected';}?> >{{$sede['provincia'].', '.$sede['distrito'].' ['.$sede['name'].']'}}</option>
												@endforeach
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 mb-1">
						<label class="form-check-label mb-50" for="user_sw_factor_activo">Desactivar usuario</label>
						<div class="form-check form-check-info form-switch">
							<input type="checkbox" class="form-check-input" name="user_sw_factor_activo" id="user_sw_factor_activo"
							<?php if($user['activo'] == 0) {echo 'checked';}?>
							/>
						</div>
					</div>
					<div class="row mt-3">
						
						<div class="col-md-4 text-right">
							<img src="{{ URL::to('/') }}/images/loading.gif" alt="cargando" width="20px" class="d-none" id="loader-bienvenido">
							<button type="button" class="btn btn-info me-1" id="sendBienvenida">Mensaje de bienvenida</button>
						</div>
						<div class="col-md-4 text-right">
							<button type="button" class="btn btn-primary me-1" id="update-user">Guardar</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	@endif
	
</div>
@endsection
@section('page-script')
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
<script>
	var flatpickredit;
	var flatpickreditcontratacion;
	var site_url="<?php echo url('/').'/'; ?>";
	var chekiado ;
	$( document ).ready(function() {
		$("#user_dateofbirth").flatpickr({
			locale: "es",
			altInput: true,
			altFormat: "d-m-Y"
		});

		$("#user_hiring").flatpickr({
			locale: "es",
			altInput: true,
			altFormat: "d-m-Y"
		});
		flatpickredit = $("#edit_user_dateofbirth").flatpickr({
			locale: "es",
			altInput: true,
			altFormat: "d-m-Y"
		});
		flatpickreditcontratacion = $("#edit_user_hiring").flatpickr({
			locale: "es",
			altInput: true,
			altFormat: "d-m-Y"
		});
	});
	$('#user_sw_factor_activo').on('change', function () {
		if($("#user_sw_factor_activo").prop('checked')){
			chekiado = 0;
		}else{
			chekiado = 1;
		}	
	});

	$("#add-new-user").on('click',function(){
		isValid = $("#form-new-user").valid();
		if(isValid){
			var formSerialize = $('#form-new-user').serialize();
			v_token = "{{ csrf_token() }}";
			formData = new FormData(document.getElementById("form-new-user"));
			formData.append("_method", "POST");
			formData.append("_token", v_token);
			$.ajax({
				url: "{{route('usuario.create')}}",
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
						setTimeout(() => {
							window.location.href = "{{route('usuarios.index')}}";
						}, 2500);
						

					}
				}
			});
		}
	});

	$("#update-user").on('click',function(){
		userID=$("#edit_user_id").val();
		isValid = $("#form-update-user").valid();
		var nuevoCheck = chekiado;
		console.log(nuevoCheck);
		if($('#edit_user_sw_factor_activo').attr('checked')){
			var desactivado = 0;
			alert(desactivado);
		}
		if(isValid){
			var formSerialize = $('#form-update-user').serialize();
			v_token = "{{ csrf_token() }}";
			formSerialize += '&_method=PUT&_token='+v_token;
			formData = new FormData(document.getElementById("form-update-user"));
			formData.append("_method", "PUT");
			formData.append("_token", v_token);
			formData.append("chekiado", nuevoCheck);

			$.ajax({
				url: "{{route('usuario.update')}}/"+userID,
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
						setTimeout(() => {
							location.reload();
						}, 2500);
						

					}
				}
			});
		}
	});

	$("#sendBienvenida").on('click',function(){
		$("#sendBienvenida").prop('disabled',true);
		$("#loader-bienvenido").removeClass('d-none');
		v_token = "{{ csrf_token() }}";
		method = 'POST';
		userID=$("#edit_user_id").val();
		$.ajax({
			url: "{{route('usuario.sendbienvenida')}}/"+userID,
			type: "POST",
			data: {_token:v_token,_method:method},
			dataType: 'json',
			success: function(obj){
				if(obj.sw_error==1){
					Swal.fire({
						position: "bottom-end",
						icon: "warning",
						title: "Atención",
						text: obj.mensaje,
						showConfirmButton: false,
						timer: 2500
					});
				}else{
					Swal.fire({
						position: "bottom-end",
						icon: "success",
						title: "Éxito",
						text: obj.mensaje,
						showConfirmButton: false,
						timer: 2500
					});
				}
				$("#sendBienvenida").prop('disabled',false);
				$("#loader-bienvenido").addClass('d-none');
			}
		});
	});

	$("#table-users").on('click','.user-delete',function(){
		//console.log($(this));
		userID=$(this).data('userid');
		nombre = $(this).data('nombre');
		Swal.fire({
			title: "Estas seguro de eliminar a "+nombre+" ?",
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
					url: "{{ route('usuario.delete') }}/"+userID,
					type: "POST",
					data: {_token:v_token,_method:method},
					dataType: 'json',
					success: function(obj){
						console.log(obj);
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
						}
					}
				});
			}
			console.log(t);
		}))
	});

	$("#tablearchivos").on('click','.archive-delete',function(){
		//console.log($(this));
		archivoid=$(this).data('archiveid');
		userID=$(this).data('usuarioid');
		Swal.fire({
			title: "Estas seguro de eliminar el archivo ?",
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
					url: "{{ route('archivos.delete') }}/"+archivoid+"/"+userID,
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
							archivos=obj.archivos;
							htmlarchivos="";
							if(archivos.length>0){
								
								archivos.forEach(element => {
									htmlarchivos+=`<tr>
										<td>${element.titulo}</td>
										<td class="text-right">
											<div class="d-inline-flex">
												<a href="${site_url+element.archivo}" target="_blank"><i data-feather="eye"></i></a>
											</div>
											<div class="d-inline-flex">
												<a href="javascript:;" class="archive-delete" data-archiveid="${element.id}" data-usuarioid="${element.user_id}"><i data-feather="trash-2" color="red"></i></a>
											</div>
										</td>	
									</tr>`;
								});
								
							}
							$("#bodyarchivos").html(htmlarchivos);
							
							feather.replace();
						}
					}
				});
			}
			console.log(t);
		}))
	});

	$('#edit_user_sw_factor_variant').on('change', function () {
		if($("#edit_user_sw_factor_variant").prop('checked')){
			$("#edit_user_factor_variant").prop('required',true);
			$("#divfactor_variante").removeClass('d-none');
		}else{
			$("#divfactor_variante").addClass('d-none');
			$("#edit_user_factor_variant").prop('required',false);
		}
	});
	$("#selectSedes").wrap('<div class="position-relative"></div>');
	$("#selectSedes").select2(
	{
		dropdownAutoWidth: true,
		width: "100%",
		dropdownParent: $("#selectSedes").parent(),
		containerCssClass: "select-lg"
	});
</script>
@endsection