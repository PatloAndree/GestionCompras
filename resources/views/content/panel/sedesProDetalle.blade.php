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
<div class="card">
	<div class="card-header">
	</div>
		<div class="card-body">
			<form action="" name="form-new-user" id="form-new-user" enctype="multipart/form-data">
				<div class="row">
				<input type="text" class="form-control d-none" id="user_id" value="<?php echo $sedes['id'];?>"  placeholder="" name="user_id" readonly/>
					<div class="col-12 col-md-4 mb-1">
						<label class="form-label" for="user_name">Establecimiento</label>
						<!-- <input type="text" class="form-control dt-full-name" id="user_name" value="<?php echo $sedes['nombre'];?>"  placeholder="" name="user_name" readonly/> -->
						<h3 class="""><?php echo $sedes['nombre'];?></h3>
					</div>
					<div class="col-12 col-md-3 mb-1">
						<label class="form-label" for="user_lastname">Región</label>
						<h5 class="" ><?php echo $sedes['pais'];?></h5>

					</div>
					
					<div class="col-12 col-md-4 mb-1">
						<label class="form-label" for="user_numbredocument">Departamento</label>
						<h5 class="" ><?php echo $sedes['departamento'];?></h5>

					</div>
					<div class="col-12 col-md-4 mb-1 d -none">
						<!-- <label class="form-label" for="user_dateofbirth">Provincia</label> -->
						<!-- <i data-feather="book"></i> -->
						
					</div>

					<div class="col-12 col-md-3 mb-1">
						<label class="form-label" for="user_dateofbirth">Provincia</label>
						<h5 class="""><?php echo $sedes['provincia'];?></h5>

					</div>

					<div class="col-12 col-md-4 mb-1">
						<label class="form-label" for="user_dateofbirth">Distrito</label>
						<h5 class=""><?php echo $sedes['distrito'];?></h5>

					</div>
					<div class="col-12 col-md-4 mb-1 ">
						<!-- <label class="form-label" for="user_phone">Dirección</label> -->
						
					</div>
					<div class="col-12 col-md-6 mb-1">
						<label class="form-label" for="user_phone">Dirección</label>
						<h5 class=""><?php echo $sedes['direccion'];?></h5>
					</div>
					
				</div>
				<div class="row">
					<div class="card-datatable table-responsive pt-0">
						<table class="user-list-table table" id="table-sedes">
							<thead class="table-light">
							<tr>
								<th>Código producto</th>
								<th>Nombre</th>
								<th>Cantidad</th>
								<th>Fecha Vencimiento</th>
								<!-- <th>Acciones</th> -->
							</tr>
							</thead>
						</table>
					</div>
				</div>
				<!-- <div class="row mt-3">
					<div class="col-md-12 text-right">
						<button type="button" class="btn btn-info me-1" id="add-new-user">Editar</button>
					</div>
				</div> -->
			</form>
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
<!-- <script src="{{ asset('js/scripts/multiselect/jquery.multi-select.js') }}"></script> -->
<!-- <script src="{{ asset('js/scripts/multiselect/jquery.quicksearch.min.js') }}"></script> -->

<script>

	// var flatpickredit;
	// var flatpickreditcontratacion;
	var site_url="<?php echo url('/').'/'; ?>";
	$( document ).ready(function() {

		
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
						setTimeout(() => {
							location.reload();
						}, 2500);
						

					}
				}
			});
		}
	});

	// var id_user = document.getElementById("user_id"); 
	// <?php
	// $dato = $sedes['id'];
	// ?>

	dt_ajax = $("#table-sedes").dataTable({

			processing: true,
			dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
			ajax: "{{route('sedes.listare')}}/" + $('#user_id').val(),
			language: {
				paginate: {
					previous: '&nbsp;',
					next: '&nbsp;'
				}
			},
			columns: [
					{ data: 'id' },
					{ data: 'nombre' },
					// { data: 'sede' },
					{ data: 'cantidad' },
					{ data: 'fecha_v' }
				],
			columnDefs: [
				{
					// targets: -1,
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
	// $("#selectSedes").select2(
	// {
	// 	dropdownAutoWidth: true,
	// 	width: "100%",
	// 	dropdownParent: $("#selectSedes").parent(),
	// 	containerCssClass: "select-lg"
	// });
</script>
@endsection