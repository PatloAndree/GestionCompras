@extends('layouts/contentLayoutMaster')

@section('title', 'Calendario')
@section('page-style')

	<!-- <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}"> -->
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/base/pages/app-calendar.css') }}">
	<!-- <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}"> -->
	<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
	<link href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/style.css" rel="stylesheet" />
	<style>
		.table th:first-child {
			position: sticky;
			left: 0;
			width:24px;
			background-color: #0081C9;
			color: #ffff;
		}
	</style>

@endsection
@section('content')
<section>
	<div class="app-calendar overflow-hidden border">
		<div class="row">
			<div class="card">
				<div class="card-body">
					<div class="row card-body border-bottom ">
						<div class="col-md-4">
							<div class="mb-1">
								<label class="form-label" for="asistencia-date">Fecha</label>
								<input type="text" id="asistencia-date" name="asistencia_date" value="<?php echo date('m.y'); ?>" class="form-control" placeholder="DD-MM-YYYY" />
								<input type="hidden" value="" id="valFechaAsistencia">
							</div>
						</div>
						<div class="col-md-4 col-sm-12" style="text-align: start;display: block;margin-top: auto;">
								<div class="mb-1" >
									<button class="btn btn-info" type="button" id="btnFecha"><span>Consultar</span></button>
								</div>
							</div> 
						</div>
						<div class="card-datatable table-responsive pt-0">
							
							<table class="user-list-table table" id="table-productos">
								<thead class="table-light">
								<tr>
									<th></th>
									<th>01</th>
									<th>02</th>
									<th>03</th>
									<th>04</th>
									<th>05</th>
									<th>06</th>
									<th>07</th>
									<th>08</th>
									<th>09</th>
									<th>10</th>
									<th>11</th>
									<th>12</th>
									<th>13</th>
									<th>14</th>
									<th>15</th>
									<th>16</th>
									<th>17</th>
									<th>18</th>
									<th>19</th>
									<th>20</th>
									<th>21</th>
									<th>22</th>
									<th>23</th>
									<th>24</th>
									<th>25</th>
									<th>26</th>
									<th>27</th>
									<th>28</th>
									<th>29</th>
									<th>30</th>
									<th>31</th>

								</tr>
								</thead>

								<tbody>
								<tr  id="fechas_array"></tr>
								</tbody>

							</table>
						</div>

						<input type="text" class="d-none" value="0"  id="sw_aceptado" >

						<div class="col-md-12 mt-2">
								<label class="form-label" for="asistencia-date">Observación</label>
								<textarea name="observacion_date" id="observacion_date" rows="10" class="form-control"  cols="30" placeholder="Escribe alguna observación"></textarea>
						</div>

						<div class="col-md-3 mt-2" id="div_guardar" >
							<button class="btn btn-primary " id="guardar">Guardar</button>
							<!-- <button class="btn btn-success "id="aceptar" value="1">Aceptar</button> -->
						</div>

					</div> 
				</div> 
			</div>
		</div>
	</div>
  <!-- Calendar Add/Update/Delete event modal-->

  <!--/ Calendar Add/Update/Delete event modal-->
</section>
@endsection
@section('page-script')
<script src="{{ asset(mix('vendors/js/extensions/moment.min.js')) }}"></script>
<!--script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script-->
<script src="{{ asset(mix('vendors/js/calendar/fullcalendar.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/index.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>



<script>
	
	$( document ).ready(function() {
		$('#btnFecha').trigger('click');
        
    });

	flatpickr('#asistencia-date',{
		locale: "es",
		altInput: true,
		altFormat: "m.Y",
		plugins: [
			new monthSelectPlugin({
				shorthand: true, 
				dateFormat: "m.Y", 
			})
		]
	});


	$("#btnFecha").on('click',function(){
		$("#fechas_array").html("");	
		var fechita = $("#asistencia-date").val();
		v_token = "{{ csrf_token() }}";
		var formSerialize = $('#productoForm').serialize();
		formSerialize += '&_method=POST&_token='+v_token;
		$.ajax({
			url: "{{route('calendario.list')}}/"+fechita,
			type: "POST",
			data: formSerialize,
			dataType: 'json',
			success: function(data){
			
				if(data['data'].length>0){	

						$("#fechas_array").append('<th>Dia</th>');
						var datos = data['data'];
						console.log(datos);
						
						
						$(datos).each(function(key,element) {
							// $(".checkbox").attr('data-id',fecha);
							$("#fechas_array").append(
							'<th>	<div class="form-check form-check-inline"> <input class="form-check-input checkbox" data-fecha="'+element.fecha+'" data-id="'+element.id+'" type="checkbox"  '+element.checked+' '+data['estado']+' > <label class="form-check-label" for="inlineCheckbox2"></label> </div> </th>'
							);
						});
						$("#sw_aceptado").val(data['aceptado']);
						$("#observacion_date").text(data['observacion']);
						$("#guardar").removeClass('d-none');

						if(data['estado'] != ""){
							$("#guardar").html('Aceptar horario');
							$("#observacion_date").prop('disabled',true);
							if(data['aceptado'] == 1){
								$("#guardar").addClass('d-none');
							}
						}else{
							$("#guardar").html('Guardar');
							$("#observacion_date").prop('disabled',false);
						}
				}
			}
			});
	});


	$( "#guardar").click(function() {
		
		var arreglo = [];
		var fechita = $("#asistencia-date").val();
		var sw_aceptado =0;
		console.log(sw_aceptado);
		$('.checkbox:checked').each(function() {
			arreglo.push($(this).attr("data-fecha"));
		});
		var observacion = $("#observacion_date").val();
		_token = "{{ csrf_token() }}";
		method = 'POST';
		$.ajax({
			url: "{{route('calendario.save')}}",
			type: "POST",
			data: {_token:_token,method:method,fechas:arreglo,observacion:observacion,fechita:fechita,sw_aceptado:sw_aceptado},
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
	});

	
	
</script>
@endsection