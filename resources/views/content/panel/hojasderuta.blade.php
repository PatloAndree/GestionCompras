@extends('layouts/contentLayoutMaster')

@section('title', 'Hojas de ruta')
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
             <!-- <h3>Hojas de ruta</h3> -->
                <div class="card-body border-bottom text-right">
				@if($tipo_user != 1)
				<a class="btn btn-info" tabindex="0" href="{{ route('hojaderuta.show','0') }}" target="_blank"><span>Nueva hoja ruta</span></a>
				@endif	
				</div>
				
            <div class="row mt-4">
				<div class="col-12">
					<div class="card-datatable table-responsive pt-0">
						<table class="user-list-table table" id="table_hojas">
							<thead class="table-light">
								<tr>
									<th>Fecha</th>
									<th>Piloto</th>
									<th>Paramedico</th>
									<th>Turno</th>
									<th>Sub base</th>
									<th>Km inicial</th>
									<th>Km final</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody id="bodyAsistencia">
							</tbody>
						</table>
					</div>
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
	var contador;
    $(window).on('load', function() {
	

        $('#table_hojas').DataTable();

	});

    dt_ajax = $("#table_hojas").dataTable({
	    processing: true,
		dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf'
        ],
        ajax: "{{route('hojasderuta.list')}}",
	
        language: {
            paginate: {
                previous: '&nbsp;',
                next: '&nbsp;'
            }
        },
	
        columns: [
                { data: 'fecha_reporte' },
                { data: 'piloto' },
                { data: 'medico' },
                { data: 'turno_horas' },
                { data: 'sub_base' },
                { data: 'km_inicial' },
                { data: 'km_final' },
                { data: 'actions' , className: 'right'  }
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
   

	$("#table_hojas").on('click','.hoja-delete',function(){
	
		var hoja = $(this).data('sedeid');
		console.log(hoja);
		Swal.fire({
			title: "Estas seguro de eliminar está hoja ?",
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
				method = 'POST';
				$.ajax({
					url: "{{ route('hojaderuta.delete') }}/"+hoja,
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
							location.reload();
						}
					}
				});
			}
		}))
    });

</script>
@endsection