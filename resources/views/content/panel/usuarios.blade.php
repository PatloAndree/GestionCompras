@extends('layouts/contentLayoutMaster')

@section('title', 'Usuarios')
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection
@section('content')
<!-- Kick start -->
<div class="card">
	<div class="card-body">
		<div class="card">
			<img class="d-none" src="{{ asset('storage/files/user_archive_16569977720.jpeg') }}" height="30px" width="30px">

			<div class="card-body border-bottom">
				<a class="btn btn-info" tabindex="0" href="{{ route('usuario.show','0') }}" target="_blank"><span>Nuevos usuario</span></a>
			</div>
			<div class="card-datatable table-responsive pt-0">
				<table class="user_list-table table" id="table-users">
					<thead class="table-light">
						<tr>
							<th>Nombres</th>
							<th>Documento</th>
							<th>Fecha de nacimiento</th>
							<th>Correo</th>
							<th>Telefono</th>
							<th>Tipo usuario</th>
							<th>Acciones</th>
						</tr>
					</thead>
				</table>
			</div>
			<!-- Modal to add new user starts-->
			<div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in">
				<div class="modal-dialog sidebar-xl">
					<form class="modal-content pt-0" name="form-new-user" id="form-new-user" enctype="multipart/form-data">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
						<div class="modal-header mb-1">
							<h5 class="modal-title" id="exampleModalLabel">Nuevo Usuario</h5>
						</div>
						<div class="modal-body flex-grow-1">
							<div class="row">
								<div class="col-12 col-md-6 mb-1">
									<label class="form-label" for="user_name">Nombres L</label>
									<input type="text" class="form-control dt-full-name" id="user_name" placeholder="Ingrese sus nombres L" name="user_name" required/>
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
							</div>
							<div class="row mt-3">
								<div class="col-md-12 text-right">
									<button type="button" class="btn btn-info me-1" id="add-new-user">Guardar</button>
									<button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<!-- Modal to add new user Ends-->
			<!-- Modal to edit user starts-->
			<div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in-update">
				<div class="modal-dialog sidebar-xl">
					<form class="modal-content pt-0" name="form-update-user" id="form-update-user"  enctype="multipart/form-data">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
						<div class="modal-header mb-1" id="show-title-modal">
							<h5 class="modal-title">Detalle del usuario</h5>
						</div>
						<div class="modal-header mb-1" id="edit-title-modal">
							<h5 class="modal-title">Editar el usuario</h5>
						</div>
						<div class="modal-body flex-grow-1">
							<div class="row">
								<div class="col-12 col-md-6 mb-1">
									<label class="form-label" for="edit_user_name">Nombres L</label>
									<input type="text" class="form-control dt-full-name" id="edit_user_name" placeholder="Ingrese sus nombres fda" name="user_name" required/>
								</div>
								<div class="col-12 col-md-6 mb-1">
									<label class="form-label" for="edit_user_lastname">Apellidos</label>
									<input type="text" id="edit_user_lastname" class="form-control dt-uname" placeholder="Ingrese sus apellidos" name="user_lastname" required/>
								</div>
								<div class="col-12 col-md-6 mb-1">
									<label class="form-label" for="edit_user_document">Documento</label>
									<select id="edit_user_document" name="user_document" class="form-select" required>
										<option value="">Seleccionar</option>
										<option value="1">DNI</option>
										<option value="2" class="d-none">RUC</option>
										<option value="3">Carnet de extranjeria</option>
									</select>
								</div>
								<div class="col-12 col-md-6 mb-1">
									<label class="form-label" for="edit_user_numbredocument">Numero documento</label>
									<input type="text" id="edit_user_numbredocument" class="form-control dt-uname" placeholder="Ingrese su numero de documento" name="user_numbredocument" required/>
								</div>
								<div class="col-12 col-md-6 mb-1">
									<label class="form-label" for="edit_user_dateofbirth">Fecha de nacimiento</label>
									<input type="text" id="edit_user_dateofbirth" name="user_dateofbirth" class="form-control" placeholder="DD-MM-YYYY" required/>
								</div>
								<div class="col-12 col-md-6 mb-1">
									<label class="form-label" for="edit_user_sex">Sexo</label>
									<select id="edit_user_sex" name="user_sex" class="form-select" required>
										<option value="">Seleccionar</option>
										<option value="1">Masculino</option>
										<option value="2">Femenino</option>
									</select>
								</div>
								<div class="col-12 mb-1">
									<label class="form-label" for="edit_user_address">Dirección</label>
									<textarea class="form-control" id="edit_user_address" rows="2" placeholder="Ingresar dirección" name="user_address" required></textarea>
								</div>
								<div class="col-12 col-md-6 mb-1">
									<label class="form-label" for="edit_user_phone">Celular</label>
									<input type="text" id="edit_user_phone" class="form-control" placeholder="999 999 999" name="user_phone" required/>
								</div>
								<div class="col-12 col-md-6 mb-1">
									<label class="form-label" for="edit_email">Correo</label>
									<input type="email" id="edit_email" class="form-control dt-email" placeholder="john.doe@example.com" name="email" required/>
								</div>
								
								<div class="col-12 mb-1">
									<label class="form-label" for="edit_user_hiring">Fecha de contratación</label>
									<input type="text" id="edit_user_hiring" name="user_hiring" class="form-control" placeholder="DD-MM-YYYY" required/>
								</div>
								<div class="col-12 col-md-6 mb-1">
									<label class="form-label" for="edit_user_type">Tipo Usuario</label>
									<select id="edit_user_type" name="user_type" class="form-select" required>
										<option value="">Seleccionar</option>
										<option value="1">Administrador</option>
										<option value="5">Call center</option>
										<option value="2">Enfermero</option>
										<option value="3">Doctor</option>
										<option value="4">Conductor</option>
									</select>
								</div>
								<div class="col-12 col-md-6 mb-1">
									<label class="form-label" for="edit_user_factor">Factor</label>
									<input type="text" id="edit_user_factor" class="form-control" name="user_factor" required/>
								</div>
								<div class="col-12 mb-1">
									<label class="form-check-label mb-50" for="edit_user_sw_factor_variant">Variante de factor</label>
									<div class="form-check form-check-info form-switch">
										<input type="checkbox" class="form-check-input" name="user_sw_factor_variant" id="edit_user_sw_factor_variant" />
									</div>
								</div>
								<div class="col-12" id="divfactor_variante">
									<label class="form-label" for="edit_user_factor_variant">Factor variante</label>
									<input type="text" id="edit_user_factor_variant" class="form-control" name="user_factor_variant" required/>
								</div>
								<div class="col-12 d-none">
									<label class="form-label" for="edit_user_id">ID</label>
									<input type="text" id="edit_user_id" class="form-control" required/>
								</div>
								<div class="col-12 col-md-6 mb-1">
									<label class="form-label" for="edit_user_cuentabancaria">Cuenta bancaria</label>
									<input type="text" id="edit_user_cuentabancaria" class="form-control" name="user_cuentabancaria"/>
								</div>
								<div class="col-12 col-md-6 mb-1">
									<label class="form-label" for="edit_user_cuentainterbancaria">Cuenta Interbancaria</label>
									<input type="text" id="edit_user_cuentainterbancaria" class="form-control" name="user_cuentainterbancaria"/>
								</div>
								
								<div class="col-12 mb-1">
									<label class="form-label" for="edit_user_documents">Documentos adicionales</label>
             	 					<input class="form-control" type="file" name="user_documents[]" id="edit_user_documents" multiple />
								</div>
								<div class="col-md-12">
									<div id="accordionIcon" class="accordion accordion-without-arrow" data-toggle-hover="true">
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
							</div>
							<div class="row mt-3">
								<div class="col-md-12 text-right">
									<button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
									<button type="button" class="btn btn-info me-1" id="update-user">Guardar</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<!-- Modal to edit user Ends-->
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
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
<script>
	var flatpickredit;
	var flatpickreditcontratacion;
	var site_url="<?php echo url('/').'/'; ?>";
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
						dt_ajax.api().ajax.reload();
						
						$("#modals-slide-in").modal('hide');
					}
				}
			});
		}
	});

	$("#update-user").on('click',function(){
		userID=$("#edit_user_id").val();
		isValid = $("#form-update-user").valid();
		if(isValid){
			var formSerialize = $('#form-update-user').serialize();
			v_token = "{{ csrf_token() }}";
			formSerialize += '&_method=PUT&_token='+v_token;
			formData = new FormData(document.getElementById("form-update-user"));
			formData.append("_method", "PUT");
			formData.append("_token", v_token);
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
						
						dt_ajax.api().ajax.reload();
						$("#modals-slide-in-update").modal('hide');
					}
				}
			});
		}
	});

	dt_ajax = $("#table-users").dataTable({
		processing: true,
		dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
		ajax: "{{route('usuarios.list')}}",
		language: {
			paginate: {
				previous: '&nbsp;',
				next: '&nbsp;'
			}
		},
		columns: [
				{ data: 'nombres' },
				{ data: 'documento' },
				{ data: 'nacimiento' },
				{ data: 'correo' },
				{ data: 'telefono' },
				{ data: 'role' },
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
							dt_ajax.api().ajax.reload();
						}
					}
				});
			}
			console.log(t);
		}))
	});

	$("#table-users").on('click','.user-show',function(){
		userID=$(this).data('userid');
		v_token = "{{ csrf_token() }}";
		method = 'GET';
		$.ajax({
			url: "{{ route('usuarios.data') }}/"+userID,
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
					user=obj.user;
					$("#update-user").addClass('d-none');
					$("#edit_user_id").val(user.id);
					$("#edit-title-modal").addClass("d-none");
					$("#show-title-modal").removeClass("d-none");
					$("#edit_user_name").val(user.name);
					$("#edit_user_lastname").val(user.last_name);
					$("#edit_user_document").val(user.document_id);
					$("#edit_user_numbredocument").val(user.number_document);
					flatpickredit.setDate(user.date_of_birth);
					$("#edit_user_dateofbirth").val(user.date_of_birth);
					flatpickreditcontratacion.setDate(user.date_of_hiring);
					$("#edit_user_hiring").val(user.date_of_hiring);
					$("#edit_user_sex").val(user.sex);
					$("#edit_user_address").html(user.address);
					$("#edit_user_cuentabancaria").val(user.cuentabancaria);
					$("#edit_user_cuentainterbancaria").val(user.cuentainterbancaria);
					archivos=user.archivos;
					htmlarchivos="";
					if(archivos.length>0){
						
						archivos.forEach(element => {
							url="{{ route('usuarios.data') }}"
							htmlarchivos+=`<tr>
								<td>${element.titulo}</td>
								<td class="text-right">
									<div class="d-inline-flex">
										<a href="${site_url+element.archivo}" target="_blank"><i data-feather="eye"></i></a>
							  		</div>
								</td>	
							</tr>`;
						});
						
					}
					$("#bodyarchivos").html(htmlarchivos);
					feather.replace();
					$("#edit_user_phone").val(user.phone);
					$("#edit_email").val(user.email);
					$("#edit_user_type").val(user.type);
					$("#edit_user_factor").val(user.factor);
					if(user.sw_factor_variant==0){
						$("#edit_user_sw_factor_variant").prop('checked',false).change();
						$("#divfactor_variante").addClass("d-none");
					}else{
						$("#edit_user_sw_factor_variant").prop('checked',true).change();
						$("#divfactor_variante").removeClass("d-none");
					}
					$("#edit_user_factor_variant").val(user.factor_variant);
					$("#form-update-user").find('input,select,textarea').prop('disabled',true);
					$("#modals-slide-in-update").modal("show");
				}
			}
		});
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
							dt_ajax.api().ajax.reload();
						}
					}
				});
			}
			console.log(t);
		}))
	});

	

	$("#table-users").on('click','.user-edit',function(){
		userID=$(this).data('userid');
		v_token = "{{ csrf_token() }}";
		method = 'GET';
		$.ajax({
			url: "{{ route('usuarios.data') }}/"+userID,
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
					user=obj.user;
					flatpickredit.setDate(user.date_of_birth);
					
					flatpickreditcontratacion.setDate(user.date_of_hiring);
					$("#edit_user_hiring").val(user.date_of_hiring);
					$("#update-user").removeClass('d-none');
					$("#edit_user_id").val(user.id);
					$("#edit-title-modal").removeClass("d-none");
					$("#show-title-modal").addClass("d-none");
					$("#edit_user_name").val(user.name);
					$("#edit_user_lastname").val(user.last_name);
					$("#edit_user_document").val(user.document_id);
					$("#edit_user_numbredocument").val(user.number_document);
					$("#edit_user_dateofbirth").val(user.date_of_birth);
					$("#edit_user_sex").val(user.sex);
					$("#edit_user_address").html(user.address);
					$("#edit_user_cuentabancaria").val(user.cuentabancaria);
					$("#edit_user_cuentainterbancaria").val(user.cuentainterbancaria);
					$("#edit_user_phone").val(user.phone);
					$("#edit_email").val(user.email);
					$("#edit_user_type").val(user.type);
					$("#edit_user_factor").val(user.factor);
					htmlarchivos="";
					archivos=user.archivos;
					if(archivos.length>0){
						
						archivos.forEach(element => {
							url="{{ route('usuarios.data') }}"
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
					if(user.sw_factor_variant==0){
						$("#edit_user_sw_factor_variant").prop('checked',false).change();
						$("#divfactor_variante").addClass("d-none");
					}else{
						$("#edit_user_sw_factor_variant").prop('checked',true).change();
						$("#divfactor_variante").removeClass("d-none");
					}
					$("#edit_user_factor_variant").val(user.factor_variant);
					$("#form-update-user").find('input,select,textarea').prop('disabled',false);
					$("#edit_email").prop('disabled',true);
					$("#modals-slide-in-update").modal("show");
				}
			}
		});
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
</script>
@endsection