@extends('layouts/contentLayoutMaster')

@section('title', 'Solicitudes')
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection
@section('content')
<!-- Kick start -->
<div class="card">
  	<div class="card-body">
		 <!-- list and filter start -->
		<div class="card">
			<div class="card-body border-bottom text-right">
				<a class="btn btn-info" href="{{route('solicitud.new')}}"><span>Nueva solicitud</span></a>
			</div>
			<div class="card-datatable table-responsive pt-0">
				<table class="user-list-table table" id="table-solicitudes">
					<thead class="table-light">
						<tr>
							<th>Solicitante</th>
							<th>Sede</th>
							<th>Cantidad de productos</th>
							<th>Estado</th>
							<th>Actions</th>
						</tr>
					</thead>
				</table>
			</div>
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
<script>
	let site_url="<?php echo url('/').'/'; ?>";

dt_ajax = $("#table-solicitudes").dataTable({
	processing: true,
	ordering: false,
	dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
	ajax: "{{route('solicitudes.list')}}",
	language: {
		paginate: {
			previous: '&nbsp;',
			next: '&nbsp;'
		}
	},
	columns: [
            { data: 'solicitante'},
            { data: 'sede' },
            { data: 'cantidad_productos' },
            { data: 'estado' },
            { data: 'actions' }
        ],
	drawCallback: function( settings ) {
        feather.replace();
    }
});

</script>
@endsection