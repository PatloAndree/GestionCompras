@extends('layouts/contentLayoutMaster')

@section('title', 'Horarios')
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
	<!-- <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}"> -->
	<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet" />
	<link href="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/style.css" rel="stylesheet" />
@endsection
@section('content')
<!-- Kick start -->
    <div class="card">
        <div class="card-body">
            <!-- list and filter start -->
            <div class="card">
                <div class="card-body border-bottom">
                    <button class="btn btn-info" tabindex="0" type="button" data-bs-toggle="modal" data-bs-target="#modal-sedes-new" id="fecha_new"><span>Nueva fecha</span></button>
                </div>
                <div class="card-datatable table-responsive pt-0">
                    <table class="user-list-table table" id="table-fechas">
                        <thead class="table-light">
                        <tr>
                            <th>Sede</th>
                            <th>Hora de entrada</th>
                            <th>Hora de salida</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-slide-in new-sede-modal fade" id="modal_fechas_new">
        <div class="modal-dialog">
            <form class="add-new-sede modal-content pt-0" id="form-add-sede">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">Nueva Fecha</h5>
                </div>
                <div class="modal-body flex-grow-1">
                    
                    <div class="mb-1">
                        <label class="form-label" for="sede_name">Hora de entrada</label>
                        <!-- <input type="date" class="form-control dt-full-name" id="fecha_entrada"  name="fecha_entrada" required/> -->
						<input class="flatpickr flatpickr-input active form-control" type="text" placeholder="Select Date.." id="fecha_entrada"  name="fecha_entrada" readonly="readonly">
                    </div>

                    <div class="mb-1">
                        <label class="form-label" for="sede_name">Hora de salida</label>
                        <!-- <input type="date" class="form-control dt-full-name" id="fecha_salida" name="fecha_salida" required/> -->
						<input class="flatpickr flatpickr-input active form-control" type="text" placeholder="Select Date.." id="fecha_salida"  name="fecha_salida" readonly="readonly">
                    </div>
    
                    <button type="button" class="btn btn-info me-1" id="guardar_fecha">Guardar</button>
                    <button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    
    <div class="modal modal-slide-in new-sede-modal fade" id="modal_edit_fechas">
        <div class="modal-dialog">
            <form class="add-new-sede modal-content pt-0" id="form-add-sede">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                <div class="modal-header mb-1">
                    <h5 class="modal-title" id="exampleModalLabel">Nueva Fecha</h5>
                </div>
                <div class="modal-body flex-grow-1">
                    
					<input type="text" class="d-none" id="idFecha" value="">
                    <div class="mb-1">
                        <label class="form-label" for="sede_name">Hora de  Entrada</label>

						<input class="flatpickr flatpickr-input active form-control" type="text" placeholder="Select Date.." id="fecha_editentrada"  name="fecha_editentrada" readonly="readonly">
                    </div>

                    <div class="mb-1">
                        <label class="form-label" for="sede_name">Hora de Salida</label>

						<input class="flatpickr flatpickr-input active form-control" type="text" placeholder="Select Date.." id="fecha_editsalida"  name="fecha_editsalida" readonly="readonly">
                    </div>
    
                    <button type="button" class="btn btn-info me-1" id="editar_fecha">Editar</button>
                    <button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </form>
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
<!-- <script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script> -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/index.js"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

<script>
var aperturaFlatpickr;
var cierreFlatpickr;

// $(document).ready(function () {
// 	$('#table-fechas').DataTable();
    
// });
$( '#fecha_entrada' ).flatpickr({
  	noCalendar: true,
    enableTime: true,
	dateFormat: "H:i",
	defaultDate: "08:00"
  });

  $( '#fecha_salida' ).flatpickr({
  	noCalendar: true,
    enableTime: true,
	dateFormat: "H:i",
	defaultDate: "08:00"
	
  });

  $( '#fecha_editentrada' ).flatpickr({
  	noCalendar: true,
    enableTime: true,
	dateFormat: "H:i",
	defaultDate: "08:00"
  });

  $( '#fecha_editsalida' ).flatpickr({
  	noCalendar: true,
    enableTime: true,
	dateFormat: "H:i",
	defaultDate: "08:00"
	
  });


//   flatpickr('#fecha_entrada',{
// 		locale: "es",
// 		altInput: true,
// 		altFormat: "m.Y",
// 		plugins: [
// 			new monthSelectPlugin({
// 				shorthand: true, 
// 				dateFormat: "m.Y", 
// 			})
// 		]
// 	});

// 	flatpickr('#fecha_entrada',{
// 		locale: "es",
// 		altInput: true,
// 		altFormat: "m.Y",
// 		plugins: [
// 			new monthSelectPlugin({
// 				shorthand: true, 
// 				dateFormat: "m.Y", 
// 			})
// 		]
// 	});


$(window).on('load', function() {
	$('#table-fechas').DataTable();

	$("#sede_apertura").flatpickr({
        enableTime: !0,
        noCalendar: !0
	});

});

// $("#sede_departamento").change(function(){
// 	deparment_id = $(this).val();
// 	if(deparment_id!=''){
// 		v_token = "{{ csrf_token() }}";
// 		method = 'GET';
// 		$.ajax({
// 			url: "{{ route('ubigeo.padre') }}/"+deparment_id,
// 			type: "POST",
// 			data: {_token:v_token,_method:method},
// 			dataType: 'json',
// 			success: function(obj){
// 				provincias = obj.provincias;
// 				if(provincias.length>0){
// 					htmlOptions = '<option value="">Seleccionar</option>';
// 					provincias.forEach(element => {
// 						htmlOptions+=`<option value="${element.id}">${element.nombre_ubigeo}</option>`;
// 					});
// 					$("#sede_provincia").html(htmlOptions);
// 					$("#sede_provincia").prop('disabled',false);
// 					$("#sede_distrito").prop('disabled',true);
// 					$("#sede_distrito").html('<option value=""></option>');
// 				}
// 			}
// 		});
// 	}else{
// 		$("#sede_provincia").prop('disabled',true);
// 		$("#sede_provincia").html('<option value=""></option>');
// 		$("#sede_distrito").prop('disabled',true);
// 		$("#sede_distrito").html('<option value=""></option>');
// 	}
// });

// $("#sede_provincia").change(function(){
// 	deparment_id = $(this).val();
// 	if(deparment_id!=''){
// 		v_token = "{{ csrf_token() }}";
// 		method = 'GET';
// 		$.ajax({
// 			url: "{{ route('ubigeo.padre') }}/"+deparment_id,
// 			type: "POST",
// 			data: {_token:v_token,_method:method},
// 			dataType: 'json',
// 			success: function(obj){
// 				provincias = obj.provincias;
// 				if(provincias.length>0){
// 					htmlOptions = '<option value="">Seleccionar</option>';
// 					provincias.forEach(element => {
// 						htmlOptions+=`<option value="${element.id}">${element.nombre_ubigeo}</option>`;
// 					});
// 					$("#sede_distrito").html(htmlOptions);
// 					$("#sede_distrito").prop('disabled',false);
// 				}
// 			}
// 		});
// 	}else{
// 		$("#sede_distrito").prop('disabled',true);
// 		$("#sede_distrito").html('<option value=""></option>');
// 	}
// });

$("#fecha_new").on('click',function(){
    $("#modal_fechas_new").modal("show");
});

$( "#guardar_fecha").click(function() {
		var fecha_Inicio = $("#fecha_entrada").val();
		var fecha_Fin = $("#fecha_salida").val();
		_token = "{{ csrf_token() }}";
		method = 'POST';
		$.ajax({
			url: "{{route('horarios.save')}}",
			type: "POST",
			data: {_token:_token,method:method,fecha_Inicio:fecha_Inicio,fecha_Fin:fecha_Fin},
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


// $("#btn-guardar-edit").on('click',function(){
// 	sedeID=$("#update_sede_id").val();
// 	isValid = $("#form-update-sede").valid();
// 	if(isValid){
// 		var formSerialize = $('#form-update-sede').serialize();
// 		v_token = "{{ csrf_token() }}";
// 		formSerialize += '&_method=PUT&_token='+v_token;

// 		$.ajax({
// 			url: "{{route('sede.update')}}/"+sedeID,
// 			type: "POST",
// 			data: formSerialize,
// 			dataType: 'json',
// 			success: function(obj){
// 				if(typeof obj.message === 'object' && obj.message !== null){
// 					mensaje='';
// 					Object.values(obj.message).forEach(element => {
// 						mensaje+=element+'<br>';
// 					});
// 				}else{
// 					mensaje=obj.message;
// 				}
// 				if(obj.sw_error==1){
// 					Swal.fire({
// 						position: "bottom-end",
// 						icon: "warning",
// 						title: "Atención",
// 						text: mensaje,
// 						showConfirmButton: false,
// 						timer: 2500
// 					});
// 				}else{
// 					Swal.fire({
// 						position: "bottom-end",
// 						icon: "success",
// 						title: "Éxito",
// 						text: mensaje,
// 						showConfirmButton: false,
// 						timer: 2500
// 					});
					
// 					dt_ajax.api().ajax.reload();
// 					$("#modal-sedes-update").modal('hide');
// 				}
// 			}
// 		});
// 	}
// });



    dt_ajax = $("#table-fechas").dataTable({
		processing: true,
		dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
		ajax: "{{route('horarios.listar')}}",
		language: {
			paginate: {
				previous: '&nbsp;',
				next: '&nbsp;'
			}
		},
		columns: [
                { data: 'id' },
                { data: 'entrada' },
                { data: 'salida' },
                { data: 'actions' }
			],
		drawCallback: function( settings ) {
			feather.replace();
		}
	});



$("#table-fechas").on('click','.fechas_edit',function(){

	// fechaId = $('.fechas_edit').attr('data-fechaid');
	fechaId = $(this).data('fechaid');
	
	v_token = "{{ csrf_token() }}";
	method = 'GET';
	$.ajax({
		url: "{{ route('horarios.getFecha') }}/"+fechaId,
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
				// sede=obj.etrada;
				// console.log("entrando");
				$("#fecha_editentrada").val(obj.obj[0].entrada);
				var hol = $("#fecha_editsalida").val(obj.obj[0].salida);
				$("#idFecha").val(obj.obj[0].id);

				
				// console.log(hol);
				$("#modal_edit_fechas").modal("show");
			}
		}
	});

});



$("#editar_fecha").click(function(){
		var fechaId = $("#idFecha").val();
		console.log(fechaId);
		var fecha_Inicio = $("#fecha_editentrada").val();
		var fecha_Fin = $("#fecha_editsalida").val();
		_token = "{{ csrf_token() }}";
		method = 'POST';
		$.ajax({
			url: "{{route('horarios.update')}}",
			type: "POST",
			data: {_token:_token,method:method,fecha_Inicio:fecha_Inicio,fecha_Fin:fecha_Fin,fechaId:fechaId},
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


	$("#table-fechas").on('click','.fechas_delete',function(){
		fechaId = $(this).data('fechaid');
		v_token = "{{ csrf_token() }}";
		method = 'POST';
		$.ajax({
			url: "{{ route('horarios.delete') }}/"+fechaId,
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
					// sede=obj.etrada;
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