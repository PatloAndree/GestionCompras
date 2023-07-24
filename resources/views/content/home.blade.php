@extends('layouts/contentLayoutMaster')

@section('title', 'Inicio')
@section('page-style')
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/pickadate/pickadate.css')) }}">
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css')) }}">
@endsection
@section('content')
<!-- Kick start -->
<style>
	.feather {
		height: 1.4rem !important;
		width: 1.4rem !important;
	}
</style>
<div class="row">
	<div class="col-lg-3 col-sm-6">
		<div class="card">
		<div class="card-body d-flex align-items-center justify-content-between">
			<div>
			<span>Total Clientes </span>
			<h3 class="fw-bolder mb-75">{{$usuarios}} </h3>
			</div>
			<div class="avatar bg-light-primary p-50">
				
			<span class="avatar-content">
				<i data-feather='users'></i>
			</span>
			</div>
		</div>
		</div>
	</div>
	<div class="col-lg-3 col-sm-6">
		<div class="card">
		<div class="card-body d-flex align-items-center justify-content-between">
			<div>
			<span>Total Productos</span>
			<h3 class="fw-bolder mb-75">{{$productos}} </h3>

			</div>
			<div class="avatar bg-light-success p-50">
			<span class="avatar-content">
				<i data-feather='package'></i>
			</span>
			</div>
		</div>
		</div>
	</div>
	<div class="col-lg-3 col-sm-6">
		<div class="card">
		<div class="card-body d-flex align-items-center justify-content-between">
			<div>
			<span>Total ventas</span>
			<h3 class="fw-bolder mb-75">{{$ventas}} </h3>

			</div>
			<div class="avatar bg-light-warning p-50">
			<span class="avatar-content">
				

				<i data-feather='credit-card'></i>
			</span>
			</div>
		</div>
		</div>
	</div>
	<div class="col-lg-3 col-sm-6">
		<div class="card">
		<div class="card-body d-flex align-items-center justify-content-between">
			<div>
			<h3 class="fw-bolder mb-75"></h3>
			<span>---</span>
			</div>
			<div class="avatar bg-light-danger p-50">
			<span class="avatar-content">
				<i data-feather='user-x'></i>
			</span>
			</div>
		</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header d-flex justify-content-between align-items-sm-center align-items-start flex-sm-row flex-column">
				<div class="header-left">
					<h4 class="card-title">Ventas realizadas (mes actual)</h4>
				</div>
			</div>
		<div class="card-body">
		  	<canvas class="bar-chart-ex chartjs" id="chartjs" data-height="400"></canvas>
		</div>
	  </div>
	</div>
</div>

@endsection
@section('page-script')
<script src="{{ asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/charts/chart.min.js')) }}"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

<script>
	const graficoData = [];
	$("#rangoPagosMes").flatpickr({
		mode: "range",
		defaultDate: ["2019-05-01", "2019-05-10"],
		locale: "es"
	});
	var ctx = document.getElementById("chartjs").getContext("2d");
const cfg = {
  type: 'bar',
data: {
        labels: graficoData.fechas,
        datasets: [{
            label: 'Ventas',
            data:graficoData.montos,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
};
	var myChart = new Chart(ctx, cfg);

</script>
@endsection
