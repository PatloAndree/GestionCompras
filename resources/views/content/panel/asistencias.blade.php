@extends('layouts/contentLayoutMaster')

@section('title', 'Asistencia del Personal')
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
							<label class="form-label" for="asistencia-date">Fecha</label>
							<input type="text" id="asistencia-date" name="asistencia_date" class="form-control" placeholder="DD-MM-YYYY" />
							<input type="hidden" value="" id="valFechaAsistencia">
						</div>
					</div>
					<div class="col-md-4 col-sm-12" style="text-align: start;display: block;margin-top: auto;">
						<div class="mb-1" >
							<button class="btn btn-info" type="button" id="btnAsistencia"><span>Consultar</span></button>
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
									<th>Fecha ingreso</th>
									<th>Hora ingreso</th>
									<th>Fecha salida</th>
									<th>Hora salida</th>
								</tr>
							</thead>
							<tbody id="bodyAsistencia">
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-12 mt-3 text-right">
					<button class="btn btn-success d-none" type="button" id="btnGuardarAsistencia"><span>Guardar</span></button>
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
	var asistenciaDate;
	$( document ).ready(function() {
		asistenciaDate=$("#asistencia-date").flatpickr({
			locale: "es",
			altInput: true,
			altFormat: "d-m-Y"
		});

		$("#asistencia-date").on('change',function(){
			fecha = $(this).val();
			$("#valFechaAsistencia").val(fecha);
		})
		$("#btnAsistencia").click(function(){
			fecha=$("#valFechaAsistencia").val();
			if(fecha!=''){
				v_token = "{{ csrf_token() }}";
				method = 'GET';
				$.ajax({
					url: "{{ route('asistencia.date') }}/"+fecha,
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
							$("#bodyAsistencia").html('');
							$("#btnGuardarAsistencia").addClass('d-none');
						}else{
							$("#bodyAsistencia").html(obj.data);
							
							$("#btnGuardarAsistencia").removeClass('d-none');
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

		$("#btnGuardarAsistencia").click(function(){
			btn=$(this);
			btn.prop('disabled','true');

			data=$('.trEditable');
			
			candidad = data.length;
			arrAsistencia=[];
			fecha = $("#valFechaAsistencia").val();
			if(candidad>0){
				data.each(function(element,obj){
					columnas=$(obj).find('td');
					id=$(columnas[0]).text();
					usuario_id=$(columnas[1]).text();
					fechaAsignada=fecha;
					fechaIngreso=$(columnas[4]).find('input').val();
					horaIngreso=$(columnas[5]).find('input').val();
					fechaSalida=$(columnas[6]).find('input').val();
					horaSalida=$(columnas[7]).find('input').val();
					
					if(fechaIngreso!='' && horaIngreso!=''){
						arrAsistencia.push(
							{
								"asistencia_id": id,
								"usuario_id": usuario_id,
								"fecha_asignada":fechaAsignada,
								"fecha_ingreso":fechaIngreso,
								"hora_ingreso":horaIngreso,
								"fecha_salida":fechaSalida,
								"hora_salida":horaSalida,
								"delete":0
							}
						)
					}

					if((fechaIngreso=='' && horaIngreso=='' && fechaSalida=='' && horaSalida=='') && id!='0'){
						arrAsistencia.push(
							{
								"asistencia_id": id,
								"usuario_id": usuario_id,
								"fecha_asignada":fechaAsignada,
								"fecha_ingreso":fechaIngreso,
								"hora_ingreso":horaIngreso,
								"fecha_salida":fechaSalida,
								"hora_salida":horaSalida,
								"delete":1
							}
						)
					}
					
				});
			}

			if(arrAsistencia.length>0){
				v_token = "{{ csrf_token() }}";
				method = 'POST';
				$.ajax({
					url: "{{ route('asistencia.create') }}",
					type: "POST",
					data: {_token:v_token,_method:method,datos:arrAsistencia},
					dataType: 'json',
					success: function(obj){

						asistenciaDate.setDate(fecha);
						$("#btnAsistencia").trigger('click');
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
	});
</script>
@endsection