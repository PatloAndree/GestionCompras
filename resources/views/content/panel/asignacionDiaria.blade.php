@extends('layouts/contentLayoutMaster')

@section('title', 'Asignación Diaria')
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
	<style>
		
		.select2-container--default .select2-selection--single .select2-selection__arrow {
			display: none;
		}
	</style>
@endsection
@section('content')
<!-- Kick start -->
<div class="card">
  	<div class="card-body">
		 <!-- list and filter start -->
		<div class="card">
			<div class="card-body border-bottom">
				<div class="row">
					<div class="col-md-4">
						<div class="mb-1">
							<label class="form-label" for="asignacion-date">Fecha</label>
							<input type="text" id="asignacion-date" name="asignacion_date" class="form-control" placeholder="DD-MM-YYYY" />
							<input type="hidden" value="" id="valFechaAsignacion">
						</div>
					</div>

					<div class="col-md-4 col-sm-12" style="text-align: start;display: block;margin-top: auto;">
						<div class="mb-1" >
							<button class="btn btn-info" type="button" id="btnAsignacion"><span>Consultar</span></button>
						</div>
					</div>
				</div>
				
				
			</div>
			<div class="row">
				<div class="col-12">
					<div class="card-datatable table-responsive pt-0">
						<table class="user-list-table table" id="table-asignaciondiaria">
							<thead class="table-light">
								<tr>
									<th class="d-none">ID</th>
									<th class="d-none">UsuarioID</th>
									<th>Usuario</th>
									<th>Fecha asignada</th>
									<th>Sede</th>
									<th>Horarios</th>
								</tr>
							</thead>
							<tbody id="bodyAsignacion">
								
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-12 mt-3 text-right">
					<button class="btn btn-success d-none" type="button" id="btnGuardarAsignacion"><span>Guardar</span></button>
				</div>
			</div>
		</div>
  <!-- list and filter end -->
  	</div>
</div>
<div class="card">
	<div class="card-body">
	   <!-- list and filter start -->
	  <div class="card">
		  <div class="card-body border-bottom">
			  <div class="row">
				  <div class="col-md-4">
					  <div class="mb-1">
						  <label class="form-label" for="asignacion_date_by_sede">Fecha</label>
						  <input type="text" id="asignacion_date_by_sede" name="asignacion_date_by_sede" class="form-control" placeholder="DD-MM-YYYY" />
					  </div>
				  </div>
				  
				  <div class="col-md-4 col-sm-12">
					<div class="mb-1">
						<label for="sedes" class="form-label" >Sedes</label>
						<select name="sedes" id="sedes" class="form-control">
							<option value="">Seleccionar</option>
							<?php foreach ($sedes as $sede) {?>
								<option value="<?php echo $sede->id;?>"><?php echo $sede->name;?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				  <div class="col-md-4 col-sm-12" style="text-align: start;display: block;margin-top: auto;">
					  <div class="mb-1" >
						  <button class="btn btn-info" type="button" id="btnGetUsersBySede"><span>Consultar</span></button>
					  </div>
				  </div>
			  </div>
			  
			  
		  </div>
		  <div class="row">
			  <div class="col-12">
				  <div class="card-datatable table-responsive pt-0">
					  <table class="user-list-table table" id="table_asignaciondiaria_sedes">
						  <thead class="table-light">
							  <tr>
								  <th class="d-none">ID</th>
								  <th class="d-none">UsuarioID</th>
								  <th>Usuario</th>
								  <th>Fecha asignada</th>
								  <th>Sede</th>
								  <th>Horarios</th>
							  </tr>
						  </thead>
						  <tbody id="bodyAsignacionSedes">
							  
						  </tbody>
					  </table>
				  </div>
			  </div>
			  <div class="col-12 mt-3 text-right">
				  <button class="btn btn-success d-none" type="button" id="btnGuardarAsignacionBySede"><span>Guardar</span></button>
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
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
<script>
	var asignacionDate;
	var asignacionDateSede;
	$( document ).ready(function() {
		asignacionDate=$("#asignacion-date").flatpickr({
			locale: "es",
			altInput: true,
			altFormat: "d-m-Y"
		});

		asignacionDateSede=$("#asignacion_date_by_sede").flatpickr({
			locale: "es",
			altInput: true,
			altFormat: "d-m-Y"
		});


		$("#asignacion-date").on('change',function(){
			fecha = $(this).val();
			$("#valFechaAsignacion").val(fecha);
		});

		$("#btnAsignacion").click(function(){
			fecha=$("#valFechaAsignacion").val();
			if(fecha!=''){
				v_token = "{{ csrf_token() }}";
				method = 'GET';
				$.ajax({
					url: "{{ route('asignaciondiaria.users') }}/"+fecha,
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
							$("#bodyAsignacion").html('');
							$("#btnGuardarAsignacion").addClass('d-none');
						}else{
							$("#bodyAsignacion").html(obj.data);
							
							$("#btnGuardarAsignacion").removeClass('d-none');
						}
					}
				});
			}else{
				Swal.fire({
					position: "bottom-end",
					icon: "warning",
					title: "Atención",
					text: 'Debe seleccionar una fecha.',
					showConfirmButton: false,
					timer: 2500
				});
			}
		});

		$("#btnGuardarAsignacion").click(function(){
			btn=$(this);
			btn.prop('disabled','true');

			data=$('.trEditable');
			
			candidad = data.length;
			arrAsignaciones=[];
			fecha = $("#valFechaAsignacion").val();
			if(candidad>0){
				data.each(function(element,obj){
					columnas=$(obj).find('td');
					id=$(columnas[0]).text();
					usuario_id=$(columnas[1]).text();
					sede = $(columnas[4]).find('select').val();
					horario = $(columnas[5]).find('select').val();
					if(sede!='' && horario!=''){
						arrAsignaciones.push(
							{
								"asignacion_id": id,
								"usuario_id": usuario_id,
								"sede":sede,
								"horario":horario,
								"fecha":fecha,
								"delete":0
							}
						)
					}

					if((sede=='' || horario=='') && id!='0'){
						arrAsignaciones.push(
							{
								"asignacion_id": id,
								"usuario_id": usuario_id,
								"sede":sede,
								"horario":horario,
								"fecha":fecha,
								"delete":1
							}
						)
					}
					
				});
			}

			if(arrAsignaciones.length>0){
				v_token = "{{ csrf_token() }}";
				method = 'POST';
				$.ajax({
					url: "{{ route('asignaciondiaria.create') }}",
					type: "POST",
					data: {'_token':v_token,'_method':method,"datos":arrAsignaciones},
					dataType: 'json',
					success: function(obj){
						asignacionDate.setDate(fecha);
						$("#btnAsignacion").trigger('click');
						Swal.fire({
							position: "bottom-end",
							icon: "success",
							title: "Atención",
							text: obj.message,
							showConfirmButton: false,
							timer: 2500
						});
						btn.prop('disabled',false);
					}
				});
			}else{
				Swal.fire({
					position: "bottom-end",
					icon: "warning",
					title: "Atención",
					text: 'No hay datos para actualizar.',
					showConfirmButton: false,
					timer: 2500
				});
				btn.prop('disabled',false);
			}
		});


		$("#table-asignaciondiaria").on('change','.sede_horario',function(){
				// $(this).data("horario")
				// fecha = $(this).data('horario');
				// var idBoton = $(this).data("");
				inputHorario=$(this).parent().parent().find('.id_horario');

				data=$(this).find(':selected').data('horario');
				console.log(data);
				inputHorario.html("");

				

				htmlOptions = '<option value="" data-horario="[]">Seleccionar</option>';
				if(data.length>0){
					data.forEach(element => {
						htmlOptions+=`<option value="${element.horarios.id}">${element.horarios.entrada}-${element.horarios.salida}</option>`;
					});
				}
					
				inputHorario.html(htmlOptions);
		});
		
	});
	//
	$("#btnGetUsersBySede").on('click',function(){
		sedeid=$("#sedes").val();
		fecha=$("#asignacion_date_by_sede").val();
		if(fecha.trim()!=''){
			if(sedeid.trim()!='' && sedeid>0){
				v_token = "{{ csrf_token() }}";
				method = 'POST';
				$.ajax({
					url: "{{ route('asignaciondiaria.usersbysede') }}",
					type: "POST",
					data: {'_token':v_token,'_method':method,"fecha":fecha.trim(),"sedeid":sedeid},
					dataType: 'json',
					success: function(obj){
						
						if(obj.length>0){
							$("#btnGuardarAsignacionBySede").removeClass('d-none');
						}else{
							$("#btnGuardarAsignacionBySede").addClass('d-none');
						}

						let htmlTable='';
						const date = new Date(fecha.replace(/-/g, ','));
						obj.forEach(function(element){
							usuario=element.usuario;
							horarios=element.sede.horarios;
							idAsignacion=(usuario.asignaciondiaria.length>0) ? usuario.asignaciondiaria[0].id : '0';
							idAsignacionHorario=(usuario.asignaciondiaria.length>0) ? usuario.asignaciondiaria[0].horario_id : '0';
							htmlHorario='<option value="">Seleccionar</option>';
							horarios.forEach(function(data){
								htmlHorario+=`<option value="${data.horarios.id}" ${(idAsignacionHorario==data.horarios.id) ? 'selected':''}>${data.horarios.entrada+" - "+data.horarios.salida}</option>`
							});

							editableTr='trEditable2';
							disabledTr='';
							if(idAsignacion>0 && usuario.asignaciondiaria[0].sw_asistencia==0){
								editableTr='';
								disabledTr='disabled';
							}
							htmlTable+=`<tr class="${editableTr}">
								<td class="d-none">${idAsignacion}</td>
								<td class="d-none">${usuario.id}</td>
								<td>${usuario.name+' '+usuario.last_name}</td>
								<td>${date.toLocaleDateString('es-Es')}</td>
								<td>
									<select class="form-select sede_horario" disabled>
										<option value="${element.sede.id}">${element.sede.name}</option>
									</select>
								</td>
								<td>
									<select class="form-select id_horario" ${disabledTr}>
										${htmlHorario}
									</select>
								</td>
							</tr>';`;

						});

						
						$("#bodyAsignacionSedes").html(htmlTable);
					}
				});
			}
		}else{
			Swal.fire({
				position: "bottom-end",
				icon: "warning",
				title: "Atención",
				text: 'Debe selecionar una fecha de referencia.',
				showConfirmButton: false,
				timer: 2500
			});
		}
		
	})

	$("#btnGuardarAsignacionBySede").click(function(){
			btn=$(this);
			btn.prop('disabled','true');

			data=$('.trEditable2');
			
			candidad = data.length;
			arrAsignaciones=[];
			fecha = $("#asignacion_date_by_sede").val();
			if(candidad>0){
				data.each(function(element,obj){
					columnas=$(obj).find('td');
					id=$(columnas[0]).text();
					usuario_id=$(columnas[1]).text();
					sede = $(columnas[4]).find('select').val();
					horario = $(columnas[5]).find('select').val();
					if(horario!=''){
						arrAsignaciones.push(
							{
								"asignacion_id": id,
								"usuario_id": usuario_id,
								"sede":sede,
								"horario":horario,
								"fecha":fecha,
								"delete":0
							}
						)
					}

					if(horario=='' && id!='0'){
						arrAsignaciones.push(
							{
								"asignacion_id": id,
								"usuario_id": usuario_id,
								"sede":sede,
								"horario":horario,
								"fecha":fecha,
								"delete":1
							}
						)
					}
					
				});
			}

			if(arrAsignaciones.length>0){
				v_token = "{{ csrf_token() }}";
				method = 'POST';
				$.ajax({
					url: "{{ route('asignaciondiaria.create2') }}",
					type: "POST",
					data: {'_token':v_token,'_method':method,"datos":arrAsignaciones},
					dataType: 'json',
					success: function(obj){
						asignacionDate.setDate(fecha);
						$("#btnGetUsersBySede").trigger('click');
						Swal.fire({
							position: "bottom-end",
							icon: obj.type,
							title: obj.titulo,
							text: obj.message,
							showConfirmButton: false,
							timer: 2500
						});
						btn.prop('disabled',false);
					}
				});
			}else{
				Swal.fire({
					position: "bottom-end",
					icon: "warning",
					title: "Atención",
					text: 'No hay datos para actualizar.',
					showConfirmButton: false,
					timer: 2500
				});
				btn.prop('disabled',false);
			}
		});
</script>
@endsection