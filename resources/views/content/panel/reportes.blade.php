@extends('layouts/contentLayoutMaster')

@section('title', 'Reportes')
@section('page-style')
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection
@section('content')
<!-- Kick start -->


@if (Auth::user()->type==1)
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h5>Disponibilidad</h5>
				</div>
				<div class="card-body">
					<form class="form">
						<div class="row">
							<div class="col-md-12 col-12">
								<div class="mb-1">
								<label class="form-label" for="rango_disponibilidad">Rango de fecha</label>
								<input type="text" id="rango_disponibilidad" class="form-control" placeholder="DD-MM-YYYY al DD-MM-YYYY" name="rango_disponibilidad">
								</div>
							</div>
							<div class="col-12 text-right">
								<button type="button" class="btn btn-info me-1 waves-effect waves-float waves-light" id="btn_reportedisponibilidad">Generar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endif
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>Registro de atenciones tópico por sedes</h5>
			</div>
			<div class="card-body">
				<form class="form">
					<div class="row">
						<div class="col-md-6 col-12">
							<div class="mb-1">
							<label class="form-label" for="reporte_topico_sedes">Sedes</label>
							<select id="reporte_topico_sedes" name="reporte_topico_sedes" class="form-select" required>
								<option value="0" selected>Todas</option>
								@foreach ($sedes as $sede)
									<option value="{{ $sede->id }}">{{$sede->name}}</option>
								@endforeach
							
							</select>
							</div>
						</div>
						<div class="col-md-6 col-12">
							<div class="mb-1">
							<label class="form-label" for="reporte_topico_range">Rango de fecha</label>
							<input type="text" id="reporte_topico_range" class="form-control" placeholder="DD-MM-YYYY al DD-MM-YYYY" name="reporte_topico_range">
							</div>
						</div>
						<div class="col-12 text-right">
							<button type="button" class="btn btn-info me-1 waves-effect waves-float waves-light" id="btn_reporte_topico_sede">Generar</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@if (Auth::user()->type==1)
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h5>Horas trabajadas</h5>
				</div>
				<div class="card-body">
					<form class="form">
						<div class="row">
							<div class="col-md-6 col-12">
								<div class="mb-1">
								<label class="form-label" for="reportehoras_sedes">Sedes</label>
								<select id="reportehoras_sedes" name="reportehoras_sedes" class="form-select" required>
									<option value="0" selected>Todas</option>
									@foreach ($sedes as $sede)
										<option value="{{ $sede->id }}">{{$sede->name}}</option>
									@endforeach
								</select>
								</div>
							</div>
							<div class="col-md-6 col-12">
								<div class="mb-1">
								<label class="form-label" for="reportehoras_range">Rango de fecha</label>
								<input type="text" id="reportehoras_range" class="form-control" placeholder="DD-MM-YYYY al DD-MM-YYYY" name="reportehoras_range">
								</div>
							</div>
							<div class="col-12 text-right">
								<button type="button" class="btn btn-info me-1 waves-effect waves-float waves-light" id="btn_reportehoras_sede">Generar</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
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
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
<script>
	$("#rango_disponibilidad").flatpickr({
        mode: "range",
		locale: "es"
    });	
	$("#btn_reportedisponibilidad").click(function(){
		fecha=$("#rango_disponibilidad").val().trim();
		fecha=fecha.replace(' a ','|');
		if(fecha!=''){
			window.open("{{ route('reporte.disponibilidad') }}"+"/"+fecha,'_blank');
		}else{
			Swal.fire({
				toast: true,
				position: "bottom-end",
				icon: "warning",
				text: "Debe seleccionar tanto sede, como un rango de fecha.",
				showConfirmButton: false,
				timer: 3000
			});
		}
	});
	$("#reporte_topico_range").flatpickr({
        mode: "range",
		locale: "es"
    });	
	$("#btn_reporte_topico_sede").click(function(){
		sede=$("#reporte_topico_sedes").val();
		fecha=$("#reporte_topico_range").val().trim();
		fecha=fecha.replace(' a ','|');
		if(fecha!='' & sede!=''){
			window.open("{{ route('reporte.atencionestopico') }}"+'/'+sede+"/"+fecha,'_blank');
		}else{
			Swal.fire({
				toast: true,
				position: "bottom-end",
				icon: "warning",
				text: "Debe seleccionar tanto sede, como un rango de fecha.",
				showConfirmButton: false,
				timer: 3000
			});
		}
	});
	$("#reportehoras_range").flatpickr({
        mode: "range",
		locale: "es"
    });	
	$("#btn_reportehoras_sede").click(function(){
		sede=$("#reportehoras_sedes").val();
		fecha=$("#reportehoras_range").val().trim();
		fecha=fecha.replace(' a ','|');
		if(fecha!='' & sede!=''){
			window.open("{{ route('reporte.horastrabajadas') }}"+'/'+sede+"/"+fecha,'_blank');
		}else{
			Swal.fire({
				toast: true,
				position: "bottom-end",
				icon: "warning",
				text: "Debe seleccionar tanto sede, como un rango de fecha.",
				showConfirmButton: false,
				timer: 3000
			});
		}
	});
</script>
@endsection