@extends('layouts/contentLayoutMaster')
@section('title', 'Nueva Compra')

@section('page-style')
	<link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css')) }}">
    <link rel="stylesheet" type="text/css" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
	<style>
		.ms-container{
			width: 100%;
		}
		.select2-container--default .select2-selection--single .select2-selection__arrow {
			display: none;
		}
	</style>
@endsection

@section('content')
	<!-- list and filter start -->
	<div class="card">
		<div class="card-body">
			<div class="row">
				<form id="comprasForm" name="comprasForm" class="row gy-1 pt-75" enctype="multipart/form-data">
					<div class="col-12 col-md-8" style="border-right: 1px solid #d6dce1;">
						<div class="row">
							<div class="col-12 col-md-12 mb-1">
								<label class="form-label" for="compra_proveedor">Proveedor</label>
								<select id="compra_proveedor" name="compra_proveedor" class="form-select" required>
									<option value="">Seleccionar</option>
									@foreach ($proveedores as $proveedor)
										<option value="{{$proveedor->id}}">{{$proveedor->nombre.' ['.$proveedor->numerodocumento.']'}}</option>
									@endforeach
								</select>
							</div>
							<div class="col-12 col-md-12 mb-1">
								<label class="form-label" for="searchProducto">Producto</label>
								<select id="searchProducto" name="searchProducto" class="form-control"></select>
							</div>
							<div class="col-12 col-md-12 mb-1">
								<div class="card-datatable table-responsive pt-0">
									<table class="table" id="table-productos">
										<thead class="table-light">
											<tr>
												<th>Producto</th>
												<th>Fecha vencimiento</th>
												<th>Cantidad</th>
												<th>Precio compra</th>
												<th>Total</th>
												<th>Acción</th>
											</tr>
										</thead>
										<tbody id="table-productos-body">
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-md-4">
						<div class="row">
							<div class="col-12 col-md-12 mb-1">
								<label class="form-label" for="compra_fecha">Fecha de compra</label>
								<input type="date" id="compra_fecha" name="compra_fecha" class="form-control" required/>
							</div>
							<div class="col-12 col-md-12 mb-1">
								<label class="form-label" for="compra_codigo">Codigo de compra</label>
								<input type="text" id="compra_codigo" name="compra_codigo" class="form-control"/>
							</div>
							<div class="col-12 col-md-12 mb-1">
								<label class="form-label" for="compra_comprobante">Boleta o Factura</label>
								<input type="text" id="compra_comprobante" name="compra_comprobante" class="form-control"/>
							</div>
							<div class="col-12 col-md-12 mb-1">
								<label class="form-label" for="compra_adicional">Información adicional</label>
								<textarea class="form-control" id="compra_adicional" rows="4" name="compra_adicional"></textarea>
							</div>
							<div class="col-12 col-md-12 mb-1">
								<label class="form-label" for="compra_monto">Monto Final</label>
								<input type="text" id="compra_monto" name="compra_monto" class="form-control" readonly/>
							</div>
							<div class="col-12 text-right mt-2 pt-50">
								<a class="btn btn-outline-danger" href="{{route('compras.index')}}">Cancelar</a>
								<button type="button" id="btn-save-compra" class="btn btn-info me-1">Guardar</button>
							</div>
						</div>
					</div>
				</form>
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
<script src="{{ asset('js/scripts/numeric/numeric.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
	var jsonSearch = {
		placeholder: 'Select an option',
		ajax: {
			url: '{{route("producto.search")}}',
			dataType: 'json',
			data: function (params) {
				var query = {
					search: params.term
				}

				// Query parameters will be ?search=[term]&type=public
				return query;
			},
			processResults: function(data, params) {
				var data = $.map(data, function(obj) {
					obj.id = obj.id;
					obj.text = obj.sku;
					return obj;
				});
				// parse the results into the format expected by Select2
				// since we are using custom formatting functions we do not need to
				// alter the remote JSON data, except to indicate that infinite
				// scrolling can be used
				params.page = params.page || 1;

				return {
					results: data,
					pagination: {
					more: (params.page * 30) < data.total_count
					}
				};
			},
			cache: true
		},
		minimumInputLength: 3
	};
	var $searchProducto = $("#searchProducto").select2(jsonSearch);
	
	$("#table-productos-body").on('click', '.bootstrap-touchspin-up',function(){
		fila=$(this).parent().parent().parent().parent().parent().parent();
		cantidadInput =fila.find('td:eq(2)').find('input');
		cantidad = parseInt(cantidadInput.val());
		precioInput = fila.find('td:eq(3)').find('input');
		totalInput = fila.find('td:eq(4)').find('input');
		precio =  parseFloat(precioInput.val());
		nuevaCantidad = cantidad + 1;
		nuevoPrecio = parseFloat(nuevaCantidad*precio).toFixed(2);
		cantidadInput.val(nuevaCantidad);
		totalInput.val(nuevoPrecio);
		totalCompra();
	});
	$("#table-productos-body").on('click','.bootstrap-touchspin-down',function(){
		fila = $(this).parent().parent().parent().parent().parent().parent();
		cantidadInput =fila.find('td:eq(2)').find('input');
		cantidad = parseInt(cantidadInput.val());
		precioInput = fila.find('td:eq(3)').find('input');
		totalInput = fila.find('td:eq(4)').find('input');
		precio = parseFloat(precioInput.val());
		nuevaCantidad = cantidad - 1;

		if(nuevaCantidad<1){
			nuevaCantidad=1;
		}

		nuevoPrecio = parseFloat(nuevaCantidad*precio).toFixed(2);
		cantidadInput.val(nuevaCantidad);
		totalInput.val(nuevoPrecio);
		totalCompra();

	});
	$("#table-productos-body").on('blur','.quantity-counter',function(){
		fila=$(this).parent().parent().parent().parent().parent().parent();
		totalInput = fila.find('td:eq(4)').find('input');
		cantidadInput =fila.find('td:eq(2)').find('input');
		cantidad = parseInt(cantidadInput.val());
		precio = parseFloat(fila.find('td:eq(3)').find('input').val());
		if(cantidad<1){
			cantidad=1;
			cantidadInput.val(cantidad);
		}
		nuevoPrecio = parseFloat(cantidad*precio).toFixed(2);
		totalInput.val(nuevoPrecio);
		totalCompra();
	});
	$("#table-productos-body").on('blur','.precio-compra',function(){
		fila=$(this).parent().parent();
		totalInput = fila.find('td:eq(4)').find('input');
		cantidad =fila.find('td:eq(2)').find('input').val();
		precioInput = fila.find('td:eq(3)').find('input');
		precio = parseFloat(precioInput.val());
		precioInput.val(precio.toFixed(2));
		nuevoPrecio = parseFloat(cantidad*precio).toFixed(2);
		totalInput.val(nuevoPrecio);
		totalCompra();
	});
	$("#table-productos-body").on('click','.remove', function(){
		$(this).parent().parent().remove();
		totalCompra();
	});

	$('#searchProducto').on('select2:select', function (e) {
		optionSelected=$("#searchProducto").select2().find(":selected");
		if(optionSelected.length>0){
			productoID=optionSelected.val();
			v_token = "{{ csrf_token() }}";
			method = 'GET';
			$.ajax({
				url: "{{ route('producto.data') }}/"+productoID,
				type: "GET",
				data: {_token:v_token,_method:method},
				dataType: 'json',
				success: function(obj){
					if(obj.sw_error==0){
						addFila(obj.data);
						$searchProducto.select2("destroy");
						$('#searchProducto').empty()
						$searchProducto.select2(jsonSearch);
					}
					
					
				}
			});
		}else{
			$('#searchProducto').val(null).trigger('change');
		}
	});

	function productosComprados(){
		table = $("#table-productos-body").find('tr');
		let productos = [];
		let sw_error = 0; 
		if(table.length>0){
			table.each(function(){
				fecha=$(this).find('td:eq(1)').find('input').val();
				cantidad=$(this).find('td:eq(2)').find('input').val();
				precio= parseFloat($(this).find('td:eq(3)').find('input').val()).toFixed(2);
				id=$(this).data('productoid');
				if(fecha.trim()!='' && precio>0){
					producto = {"id":id,"fecha":fecha,"cantidad":cantidad,"precio":precio};
					productos.push(producto);
				}else{
					sw_error=1;
				}
				
			});
			
		}

		if(sw_error==0 && productos.length==0){
			sw_error=1;
		}
		
		return {"sw_error":sw_error,"productos":productos};
	}
	function totalCompra(){
		table = $("#table-productos-body").find('tr');
		if(table.length>0){
			total=0;
			table.each(function(){
				valor = parseFloat($(this).find('td:eq(4)').find('input').val());
				total = valor + total;
			});
			$("#compra_monto").val(total.toFixed(2));
		}else{
			$("#compra_monto").val("0.00");
		}
	}

	function validateNumber(){
		$(".number-decimal").numeric({
			decimal: ".",
			negative: false,
			scale: 2
		});
		$(".number-integer").numeric({
			decimal: false,
			negative: false
		});
	}
	function addFila(producto){
		idClass='tr.producto-'+producto.id;
		trPrododucto=$("#table-productos-body").find(idClass);
		console.log(trPrododucto);
		if(trPrododucto.length==0){
			htmlFila=`<tr class="producto-${producto.id}" data-productoid="${producto.id}">
						<td>${producto.nombre}</td>
						<td><input class="form-control" type="date" required></td>
						<td>
							<div class="item-quantity">
								<div class="quantity-counter-wrapper">
									<div class="input-group bootstrap-touchspin">
										<span class="input-group-btn bootstrap-touchspin-injected"><button class="btn btn-primary bootstrap-touchspin-down" type="button">-</button></span>
										<input type="text" class="quantity-counter form-control number-integer" value="1" required>
										<span class="input-group-btn bootstrap-touchspin-injected"><button class="btn btn-primary bootstrap-touchspin-up" type="button">+</button></span>
									</div>
								</div>
							</div>
						</td>
						<td><input class="form-control precio-compra number-decimal" type="text" value="0.00" required></td>
						<td><input class="form-control number-decimal" type="text" value="0.00" required disabled></td>
						<td class="text-center"><i data-feather="trash-2" color="red" style="cursor: pointer;" class="remove"></i></td>
					</tr>`;

					$("#table-productos-body").append(htmlFila);

		}else{
			addQuantity(1,idClass);
		}

		feather.replace();
		validateNumber();
		totalCompra();
	}

	function addQuantity(tipo,trID){
		inputQuantity=$(trID).find('input.quantity-counter');
		valorActual=parseInt(inputQuantity.val());
		if(tipo==1){
			valorActual++;
			inputQuantity.val(valorActual);
		}else{

		}
	}
	
	$("#btn-save-compra").click(function(){
		btnSave=$(this);
		btnSave.prop('disabled',true);
		isValid = $("#comprasForm").valid();
		if(isValid){
			comprados = productosComprados();
				if(comprados.sw_error==0){
					productos=comprados.productos;
					formData = new FormData(document.getElementById("comprasForm"));
					formData.append("_method", "POST");
					formData.append("_token", v_token);
					formData.append("productos", JSON.stringify(productos));
					$.ajax({
						url: "{{route('compras.submit')}}",
						type: "POST",
						data: formData,
						cache:false,
						contentType: false,
						processData: false,
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
								btnSave.prop('disabled',false);
							}else{
								Swal.fire({
									position: "bottom-end",
									icon: "success",
									title: "Éxito",
									text: mensaje,
									showConfirmButton: false,
									timer: 2500
								});
								setTimeout(() => {
									window.location.href = "{{route('compras.list')}}";
								}, 2500);
							}
						}
					});
				}else{
					Swal.fire({
						position: "center",
						icon: "warning",
						title: "Atención",
						text: 'Asegurese que todos los productos tengan fecha de vencimiento y el precio sea mayor a 0.',
						showConfirmButton: false,
						timer: 2500
					});
					btnSave.prop('disabled',false);
				}
		}else{
			btnSave.prop('disabled',false);
		}
		
	
		
	})
</script>
@endsection