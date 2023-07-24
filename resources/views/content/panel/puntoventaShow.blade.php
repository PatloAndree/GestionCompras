@extends('layouts/contentLayoutMaster')
@section('title', 'Ver venta')

@section('page-style')
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/multiselect/multi-select.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    
	<style>
		.ms-container{
			width: 100%;
		}
		.ms-container{
			width: 100%;
		}
		.select2-container--default .select2-selection--single .select2-selection__arrow {
			display: none;
		}
	</style>
	
@endsection

@section('content')
	
    <div class="card">
        <div class="card-body">
            <div class="row">
                <form id="comprasForm" name="comprasForm" class="row gy-1 " enctype="multipart/form-data">

					{{-- CARD LADO IZQUIERDO --}}
                    <div class="col-12 col-md-9" style="border-right: 1px solid #d6dce1;">
                        
                        <div class="row">
                            {{-- <div class="col-md-12 text-left mb-1">
                                <button class="btn btn-flat-success align-self-start" tabindex="0" type="button" data-bs-toggle="modal" id="añadirProducto">
                                    <i data-feather="plus-circle"></i> producto
                                    </button>
                            </div> --}}
                            <div class="col-md-12 pb-2 ">
                                {{-- <a class="btn btn-outline-danger" href="{{route('puntoventa.index')}}">Cancelar</a> --}}
                                <a id="btn_save_compra" class="btn btn-outline-dark" href="{{route('puntoventa.index')}}" >Volver</a>
                            </div>
                            <div class="col-12 col-md-4 mb-1">
                                <label class="form-label" for="compra_proveedor">Dni</label>
                                <input type="number" class="form-control" name="dni_cliente" value="{{$venta['dni_cliente']}}" id="dni_cliente" readonly>
                            </div>
                            <div class="col-12 col-md-8 mb-1">
                                <label class="form-label" for="nombres_cliente">Cliente</label>
                                <input type="text" class="form-control" name="nombres_cliente" id="nombres_cliente" value="{{$venta['nombres_cliente']}}" readonly>
                            </div>
                            <div class="col-12 col-md-12 mb-1">
                                <label class="form-label" for="searchProducto">Lista de productos</label>
                                {{-- <select id="searchProducto" name="searchProducto" class="form-control"></select> --}}
                            </div>
                            <div class="col-12 col-md-12 mb-1">
                                <div class="card-datatable table-responsive pt-0">
                                    <table class="table" id="table-productos">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-left">Producto</th>
                                                <th class="text-center">Cantidad</th>
                                                {{-- <th>Stock</th> --}}
                                                <th class="text-center">Precio </th>
                                                <th class="text-center">Total</th>
                                                {{-- <th>Acción</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody id="table-productos-body">
                                            @foreach ($productos as $producto)
                                            <tr>

                                                <th class="text-left">{{$producto['producto_nombre']}}</th>
                                                <th class="text-center">{{$producto['cantidad']}} </th>
                                                <th  class="text-center">{{$producto['precio']}} </th>
                                                <th  class="text-center">{{$producto['precio_total']}} </th>
                                            </tr>
                                            @endforeach 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                          
                        </div>
                    </div>
                    {{-- <textarea name="" id="" cols="30" rows="10">
                        {{json_encode($productos)}}
                    </textarea> --}}
					{{-- CARD LADO DERECHO --}}
                    <div class="col-12 col-md-3">
                        <div class="row">
                            <div class="col-12 col-md-12 mb-1">
                                <label class="form-label" for="compra_fecha">Fecha de venta(*)</label>
                                <input type="date"  name="compra_fecha" value="{{$venta['fecha_venta']}}" class="form-control" readonly/>
                            </div>
                            <div class="col-12 col-md-12 mb-1">
                                <label class="form-label" for="compra_codigo">Codigo de venta</label>
                                <input type="text" id="compra_codigo" name="compra_codigo"readonly  value="{{$venta['codigo_venta']}}" class="form-control"/>
                            </div>
                            <div class="col-12 col-md-12 mb-1">
                                <label class="form-label" for="compra_comprobante">Boleta o Factura (*)</label>
                                {{-- <input type="text" id="compra_comprobante" name="compra_comprobante" class="form-control"/> --}}
								<select class="form-select" aria-label="Default select example"  id="compra_comprobante"  disabled name="compra_comprobante" required>
									{{-- <option selected>Seleccionar</option> --}}
                                    {{-- {{$venta['comprobamte']}} --}}
									<option value=""> {{$venta['comprobante'] == "1" ? "Boleta" : "Factura" }} </option>
									{{-- <option value="2">Factura</option> --}}

								</select>
                            </div>
                            <div class="col-12 col-md-12 mb-1">
                                <label class="form-label" for="compra_adicional">Información </label>
                                <textarea class="form-control" id="compra_adicional"  name="compra_adicional" readonly style="resize: none">----</textarea>
                            </div>
                            <div class="col-12 col-md-6 mb-1">
                                <label class="form-label" for="compra_monto">Sub Total </label>
                                <input type="text" id="compra_monto" name="compra_monto" class="form-control" value="{{$venta['subtotal']}}" readonly/>
                            </div>
							<div class="col-12 col-md-6 mb-1">
                                <label class="form-label" for="igv">IGV 18%</label>
                                <input type="text" id="igv" name="igv" class="form-control" value="{{$venta['igv']}}" readonly/>
                            </div>
							<div class="col-12 col-md-12 mb-1">
                                <label class="form-label" for="compra_monto_total">Monto Final</label>
                                <input type="text" id="compra_monto_total" name="compra_monto_total" class="form-control" value="{{$venta['pago_total']}}" readonly/>
                            </div>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

	{{-- MODAL AGREGAR PRODUCTO --}}






@endsection
@section('page-script')
<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/validation/jquery.validate.min.js')) }}"></script>
<script src="{{ asset('js/scripts/multiselect/jquery.multi-select.js') }}"></script>
<script src="{{ asset('js/scripts/multiselect/jquery.quicksearch.min.js') }}"></script>
<script src="{{ asset('js/scripts/numeric/numeric.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>


<script>
    
 
</script>
@endsection