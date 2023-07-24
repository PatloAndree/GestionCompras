@extends('layouts/contentLayoutMaster')

@section('title', 'Cronograma')
@section('page-style')

	<!--link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css"-->
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/calendars/fullcalendar.min.css')) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/base/pages/app-calendar.css') }}">

@endsection
@section('content')
<section>
	<div class="app-calendar overflow-hidden border">
		<div class="row">
			<div class="card">
				<div class="card-body">
					<ul class="nav nav-tabs nav-justified" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="asignacion-cronograma" data-bs-toggle="tab" href="#asignacion_cronograma" role="tab" aria-controls="asignacion_cronograma" aria-selected="true">Asignar fechas</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="micronograma" data-bs-toggle="tab" href="#mi-cronograma" role="tab" aria-controls="mi-cronograma" aria-selected="true">Mi cronograma</a>
						</li>
					</ul>
					<div class="tab-content pt-1">
						<div class="tab-pane active" id="asignacion_cronograma" role="tabpanel" aria-labelledby="asignacion-cronograma">
							<div class="row">
								<div class="col app-calendar-sidebar flex-grow-0 overflow-hidden d-flex flex-column" id="app-calendar-sidebar">
									<div class="sidebar-wrapper">
										<div class="card-body pb-0">
											<h3 class="mt-1 mb-1">Disponibilidad</h3>
											<div id="external-events">
												<div class="mt-2 mb-1">
													<div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event alert alert-danger" data-title="Tiempo completo" data-jornada="1" role="alert">
														<div class="alert-body"><strong>Tiempo completo</strong></div>
													</div>
												</div>
												<div class="mb-1">
													<div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event alert alert-warning" data-title="Día" data-jornada="2" role="alert">
														<div class="alert-body"><strong>Día</strong></div>
													</div>
												</div>
												<div class="mb-1">
													<div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event alert alert-success" data-title="Noche" data-jornada="3" role="alert">
														<div class="alert-body"><strong>Noche</strong></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- Calendar -->
								<div class="col position-relative">
									<div class="card shadow-none border-0 mb-0 rounded-0">
										<div class="card-body pb-0">
											<div id="calendar"></div>
										</div>
									</div>
								</div>
								<!-- /Calendar -->
								<div class="body-content-overlay"></div>
							</div>
						</div>
						<div class="tab-pane" id="mi-cronograma" role="tabpanel" aria-labelledby="micronograma">
							<div class="row">
								<!-- Calendar -->
								<div class="col position-relative">
									<div class="card shadow-none border-0 mb-0 rounded-0">
										<div class="card-body pb-0">
											<div id="calendar-horario"></div>
										</div>
									</div>
								</div>
								<!-- /Calendar -->
								<div class="body-content-overlay"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row g-0">
			
		</div>
	</div>
  <!-- Calendar Add/Update/Delete event modal-->
  <div class="modal modal-slide-in event-sidebar fade" id="modals-slide-in">
	<div class="modal-dialog sidebar-lg">
	  <div class="modal-content p-0">
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
		<div class="modal-header mb-1">
		  <h5 class="modal-title">Registrar dia laboral</h5>
		</div>
		<div class="modal-body flex-grow-1 pb-sm-0 pb-3">
		  <form class="event-form needs-validation" id="form-cronograma-add">
			<div class="mb-1">
			  <label for="fecha" class="form-label">Fecha</label>
			  <input type="text" class="form-control" id="fecha" name="fecha" readonly required />
			</div>
			<div class="mb-1">
				<label for="jornadalaboral" class="form-label">Jornada laboral</label>
				<select class="form-select" name="jornadalaboral" id="jornadalaboral" required>
					<option value="" selected>Seleccionar</option>
					<option value="1">Tiempo completo</option>
					<option value="2">Día</option>
					<option value="3">Noche</option>
				</select>
			</div>
			<div class="mb-1 d-flex text-right">
				<button type="button" id="saveCronograma" class="btn btn-primary add-event-btn me-1">Guardar</button>
				<button type="button" class="btn btn-outline-secondary btn-cancel" data-bs-dismiss="modal">Cancel</button>
			</div>
		  </form>
		</div>
	  </div>
	</div>
  </div><!-- Calendar Add/Update/Delete event modal-->
  <div class="modal modal-slide-in event-sidebar fade" id="modals-slide-update">
	<div class="modal-dialog sidebar-lg">
	  <div class="modal-content p-0">
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
		<div class="modal-header mb-1">
		  <h5 class="modal-title">Dia laboral registrado</h5>
		</div>
		<div class="modal-body flex-grow-1 pb-sm-0 pb-3">
		  <form class="event-form needs-validation" id="form-cronograma-update">
			<div class="mb-1">
			  <label for="fecha_update" class="form-label">Fecha</label>
			  <input type="text" class="form-control" id="fecha_update" name="fecha" readonly required />
			</div>
			<div class="mb-1">
				<label for="jornadalaboral_update" class="form-label">Jornada laboral</label>
				<select class="form-select" name="jornadalaboral" id="jornadalaboral_update" disabled required>
					<option value="1">Tiempo completo</option>
					<option value="2">Día</option>
					<option value="3">Noche</option>
				</select>
			</div>
			<input type="text" name="cronograma_id" id="cronograma_id" value="" class="d-none">
			<div class="mb-1 d-flex text-right" id="divUpdate">
				<button type="button" id="deleteCronograma" class="btn btn-danger add-event-btn me-1">Eliminar</button>
				<button type="button" class="btn btn-outline-secondary btn-cancel" data-bs-dismiss="modal">Cancel</button>
			</div>
		  </form>
		</div>
	  </div>
	</div>
  </div>
  <div class="modal modal-slide-in event-sidebar fade" id="modals-slide-asignado">
	<div class="modal-dialog sidebar-lg">
	  <div class="modal-content p-0">
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
		<div class="modal-header mb-1">
		  <h5 class="modal-title">Dia laboral registrado</h5>
		</div>
		<div class="modal-body flex-grow-1 pb-sm-0 pb-3">
		  <form class="event-form needs-validation" id="form-cronograma-asignado">
			<div class="mb-1">
			  <label for="fecha_update_asignado" class="form-label">Fecha</label>
			  <input type="text" class="form-control" id="fecha_update_asignado" name="fecha" readonly required />
			</div>
			<div class="mb-1">
				<label for="jornadalaboral_update_asignado" class="form-label">Jornada laboral</label>
				<select class="form-select" name="jornadalaboral" id="jornadalaboral_update_asignado" disabled required>
					<option value="1">Tiempo completo</option>
					<option value="2">Día</option>
					<option value="3">Noche</option>
				</select>
			</div>
			<div class="mb-1">
			  <label for="sede_update_asignado" class="form-label">Sede</label>
			  <input type="text" class="form-control" id="sede_update_asignado" name="sede" readonly required />
			</div>
			<div class="mb-1 d-flex text-right" id="divUpdate">
				<button type="button" class="btn btn-outline-secondary btn-cancel" data-bs-dismiss="modal">Cerrar</button>
			</div>
		  </form>
		</div>
	  </div>
	</div>
  </div>
  <!--/ Calendar Add/Update/Delete event modal-->
</section>
@endsection
@section('page-script')
<script src="{{ asset(mix('vendors/js/extensions/moment.min.js')) }}"></script>
<!--script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script-->
<script src="{{ asset(mix('vendors/js/calendar/fullcalendar.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
<script src="{{ asset(mix('vendors/js/calendar/es.js')) }}"></script>
<script>
	var calendar;
	var calendarhorario;//
	document.addEventListener('DOMContentLoaded', function() {
		var Calendar = FullCalendar.Calendar;
		var Draggable = FullCalendar.Draggable;

		var containerEl = document.getElementById('external-events');
		var calendarEl = document.getElementById('calendar');

		var calendarElHorario = document.getElementById('calendar-horario');

		new Draggable(containerEl, {
			itemSelector: '.fc-event',
			eventData: function(eventEl) {
				return {
					title: eventEl.innerText
				};
			}
		});
		
		calendarhorario = new Calendar(calendarElHorario, {
			locale: 'es',
			initialView: 'dayGridMonth',
			headerToolbar: {
				start: "sidebarToggle, prev,next, title",
				end: "dayGridMonth,timeGridWeek,timeGridDay"
			},
			events: {
				url: "{{route('cronograma.datamihorario')}}"
			},
			initialDate: new Date,
			dayMaxEvents: 1,
			editable:false,
			droppable: false,
			eventClick: function(event) {
				v_token = "{{ csrf_token() }}";
				method = 'GET';
				$.ajax({
					url: "{{route('cronograma.fecha_asignada')}}"+"/"+event.event.startStr+"/"+event.event.id,
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
							$("#sedes_update_asignado").find('option').prop('selected',false);
							$("#sedes_update_asignado").trigger('change');
							$("#fecha_update_asignado").val(obj.datos.fecha);
							$("#jornadalaboral_update_asignado").val(obj.datos.jornada);
							$("#sede_update_asignado").val(obj.datos.sede.name);
							$("#modals-slide-asignado").modal('show');
						}
					}
				});
			},
			eventContent: function( info ) {
				return {html: info.event.title};
			}
		});
		calendar = new Calendar(calendarEl, {
			locale: 'es',
			initialView: 'dayGridMonth',
			customButtons: {
				sidebarToggle: {
					text: "Sidebar"
				}
			},
			headerToolbar: {
				start: "sidebarToggle, prev,next, title",
				end: "dayGridMonth,timeGridWeek,timeGridDay"
			},
			events: {
				url: "{{route('cronograma.data')}}" 
			},
			initialDate: new Date,
			dayMaxEvents: 1,
			editable:false,
			droppable: false,
			validRange: {
				start: '<?php echo date("Y-m-01");?>',//start date here
				end: '<?php echo date("Y-m-t",strtotime(date("d-m-Y")."+ 1 month")); ;?>' //end date here
			},
			dateClick: function(date) {
				var myDate = moment().format('YYYY-MM-DD');
				if (date.dateStr >= myDate){
					v_token = "{{ csrf_token() }}";
					method = 'GET';
					$.ajax({
						url: "{{route('cronograma.dataday')}}"+"/"+date.dateStr,
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
								$("#fecha").val(date.dateStr);
								$("#modals-slide-in").modal('show');
							}
						}
					});
				}
			},
			eventClick: function(event) {
				v_token = "{{ csrf_token() }}";
					method = 'GET';
				$.ajax({
					url: "{{route('cronograma.event')}}"+"/"+event.event.startStr+"/"+event.event.id,
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
							$("#sedes_update").find('option').prop('selected',false);
							$("#sedes_update").trigger('change');
							$("#fecha_update").val(obj.datos.fecha);
							$("#jornadalaboral_update").val(obj.datos.jornada);
							$("#cronograma_id").val(event.event.id);
							if (obj.datos.sw_asignado==0){
								$("#divUpdate").removeClass('d-none');
							}else{
								$("#divUpdate").addClass('d-none');

							}
							$("#modals-slide-update").modal('show');
						}
					}
				});
			},
			eventReceive: function(element) {
				fechaSeleccionada=element.event.startStr;
				dataEvent=element.draggedEl.dataset;
				v_token = "{{ csrf_token() }}";
				method = 'POST';
				$.ajax({
					url: "{{route('cronograma.disponibilidad')}}",
					type: "POST",
					data: {_token:v_token,_method:method,jornada:dataEvent.jornada,fecha:fechaSeleccionada},
					dataType: 'json',
					success: function(obj){
							element.revert();
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
							calendar.refetchEvents()
						}
					}
				});
			},
			
		});
		
		
		calendar.render();
		calendarhorario.render();
		
	});
$("#sedes").select2({
	dropdownAutoWidth: true,
	width: "100%",
	dropdownParent: $("#sedes").parent()
});
$("#sedes_update").select2({
	dropdownAutoWidth: true,
	width: "100%",
	dropdownParent: $("#sedes_update").parent()
})
$('#modals-slide-in').on('hidden.bs.modal', function () {
	$("#modals-slide-in").trigger('reset');
});
$('#modals-slide-update').on('hidden.bs.modal', function () {
	$("#modals-slide-update").trigger('reset');
	$("#sedes_update").find('option').prop('selected',false);
	$("#sedes_update").trigger('change');
});
$("#saveCronograma").on('click',function(){
	isValid = $("#form-cronograma-add").valid();
	if(isValid){
		var formSerialize = $('#form-cronograma-add').serialize();
		v_token = "{{ csrf_token() }}";
		formSerialize += '&_method=POST&_token='+v_token;
		$.ajax({
			url: "{{route('cronograma.create')}}",
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
					$("#modals-slide-in").modal('hide');
					location.reload();

				}
			}
		});
	}
});

$("#micronograma").on('click',function(){
	calendar.destroy();
	calendarhorario.render();
});
$("#asignacion-cronograma").on('click',function(){
	calendarhorario.destroy();
	calendar.render();
});

$("#deleteCronograma").on('click',function(){
	Swal.fire({
		title: 'Estás seguro de eliminar?',
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Si, eliminar!'
	}).then((result) => {
		cronograma_id=$("#cronograma_id").val();
		_token = "{{ csrf_token() }}";
		method = 'POST';
		$.ajax({
			url: "{{route('cronograma.delete')}}"+'/'+cronograma_id,
			type: "POST",
			data: {_token:_token,method:method},
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
					$("#modals-slide-update").modal('hide');
					location.reload();
				}
			}
		});
	})
	/*isValid = $("#form-cronograma-update").valid();
	if(isValid){
		
		var formSerialize = $('#form-cronograma-update').serialize();
		v_token = "{{ csrf_token() }}";
		formSerialize += '&_method=PUT&_token='+v_token;
		$.ajax({
			url: "{{route('cronograma.update')}}"+'/'+cronograma_id,
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
					$("#modals-slide-update").modal('hide');
					

				}
			}
		});
	}*/
});
</script>
@endsection