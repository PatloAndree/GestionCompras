@extends('layouts/contentLayoutMaster')
@section('title', 'Nueva solicitud')

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
				<div class="col-12 col-md-7" style="border-right: 1px solid #d6dce1;">
					<div class="row">
						<div class="col-12 col-md-3 mb-1 d-none">
							<label class="form-label" for="solicitud_categoria">Categoría</label>
							<select id="solicitud_categoria" class="form-select" required>
								<option value="">Seleccionar</option>
								@foreach ($categorias as $categoria)
									<option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-12 col-md-3 mb-1">
							<label class="form-label" for="solicitud_unidad">Unidades</label>
							<select id="solicitud_unidad" class="form-control">
								<option value="">Seleccionar</option>
								@foreach ($unidades as $unidad)
									<option value="{{$unidad->id}}">{{$unidad->nombre}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-12 col-md-8 mb-1">
							<label class="form-label" for="searchProducto">Buscar</label>
							<input type="text" class="form-control" id="searchProducto">
						</div>
						<!-- <div class="col-12 col-md-1 my-auto">
							<button class="btn btn-primary btn-sm" id="buscar" type="button"><i data-feather="search" color="white"></i></button>
						</div> -->
						<div class="col-12 col-md-12 mb-1">
							<div class="card-datatable table-responsive pt-0">
								<table class="table" id="table-productos">
									<thead class="table-light">
										<tr>
											<th>Producto</th>
										</tr>
									</thead>
									<tbody id="table-productos-body">
										@foreach ($productos as $producto)
											<tr>
												<th data-productoid="{{$producto->id}}" data-productostock="{{$producto->total_stock}}" style="cursor: pointer" class="tr-producto">{{$producto->nombre}}</th>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- // DATOS DONDE SE AGREGARA LA DATA -->
				<div class="col-12 col-md-5">
					<div class="row">
						<div class="col-12 col-md-12 mb-1">
							<div class="card-datatable table-responsive pt-0">
								<table class="table" id="table-detalle-productos">
									<thead class="table-light">
										<tr>
											<th style="width:80%">Producto</th>
											<th style="width:20%">Cantidad</th>
										</tr>
									</thead>
									<tbody id="table-detalle-productos-body">
									</tbody>
								</table>
							</div>
						</div>
						<div class="col-12 col-md-12 mb-1">
							<label class="form-label" for="solicitud_note">Información adicional</label>
							<textarea class="form-control" id="solicitud_note" rows="4" name="solicitud_note"></textarea>
						</div>
						<div class="col-12 text-right mt-2 pt-50">
							<a class="btn btn-outline-danger" href="{{route('solicitudes.index')}}">Cancelar</a>
							<button type="button" id="btn-save-solicitud" class="btn btn-info me-1">Guardar</button>
						</div>
					</div>
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
<script src="{{ asset('js/scripts/numeric/numeric.js') }}"></script>
<script>
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
	var dt_config = {
		processing: true,
		dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
		language: {
			paginate: {
				previous: '&nbsp;',
				next: '&nbsp;'
			}
		},
		searching: false
	};
	var dt_ajax = $("#table-productos").dataTable(dt_config);
	$("#table-productos-body").on('click','.tr-producto',function(){
		
		productoId=$(this).data('productoid');
		productoStock=parseInt($(this).data('productostock'));
		productoNombre=$(this).text();
		detalleProducto = $("tr#detalle-id-"+productoId);
		if(detalleProducto.length==0){
			htmlDetalle=`<tr id="detalle-id-${productoId}" data-productoid="${productoId}">
							<td>${productoNombre}</td>
							<td>
								<div class="item-quantity">
									<div class="quantity-counter-wrapper">
										<div class="input-group bootstrap-touchspin">
											<span class="input-group-btn bootstrap-touchspin-injected"><button class="btn btn-primary bootstrap-touchspin-down" type="button">-</button></span>
											<input type="text" class="quantity-counter form-control number-integer" value="1" data-stockmax="${productoStock}" required>
											<span class="input-group-btn bootstrap-touchspin-injected"><button class="btn btn-primary bootstrap-touchspin-up" type="button">+</button></span>
											<span style="padding-left: 0.5em;"><i data-feather="trash" color="blue" style="cursor:pointer" class="delete-detalle"></i></span>
										</div>
									</div>
								</div>
								
							</td>
						</tr>`;
			$("#table-detalle-productos-body").append(htmlDetalle);
			feather.replace();
			validateNumber();
		}else{
			inputCantidad=detalleProducto.find('.quantity-counter');
			cantidadActual=parseInt(inputCantidad.val());
			if(cantidadActual<productoStock){
				inputCantidad.val(cantidadActual+1)
			}
		}
	});
	
	$("#table-detalle-productos-body").on('click', '.bootstrap-touchspin-up',function(){
		inputCantidad=$(this).parent().parent().find('input');
		console.log(inputCantidad);
		stockMax=parseInt(inputCantidad.data('stockmax'));
		console.log(stockMax);
		cantidadActual=parseInt(inputCantidad.val());
		console.log(cantidadActual);
		if(cantidadActual<stockMax){
			inputCantidad.val(cantidadActual+1);
		}
		validateNumber();
	});
	$("#table-detalle-productos-body").on('click','.bootstrap-touchspin-down',function(){
		inputCantidad=$(this).parent().parent().find('input');
		stockMax=parseInt(inputCantidad.data('stockmax'));
		cantidadActual=parseInt(inputCantidad.val());

		if(cantidadActual>1){
			inputCantidad.val(cantidadActual-1);
		}
		validateNumber();
	});
	$("#table-detalle-productos-body").on('blur','.quantity-counter',function(){
		inputCantidad=$(this);
		stockMax=parseInt($(this).data('stockmax'));
		cantidadActual=parseInt($(this).val());

		if(cantidadActual>0){
			inputCantidad.val(cantidadActual-1);
		}else{
			inputCantidad.val(1);
		}
		validateNumber();
	});	
	
	$("#table-detalle-productos-body").on('click','.delete-detalle', function(){
		$(this).parent().parent().parent().parent().parent().parent().remove();
	});

	$("#buscar").click(function(){
		buscar();
	});
	$('#searchProducto').keyup(function(e){
		if(e.keyCode == 13)
		{
			buscar();
		}
	});

	$("#solicitud_categoria,#solicitud_unidad").change(function(){
		buscar();
	});

	function buscar(){
		textoSearch=$.trim($("#searchProducto").val());
		categoria=$("#solicitud_categoria").val();
		unidad=$("#solicitud_unidad").val();
		v_token = "{{ csrf_token() }}";
		$.ajax({
			url: "{{route('solicitud.buscar')}}",
			type: "POST",
			data: {"_token":v_token,"categoria":categoria,"unidad":unidad,"textoSearch":textoSearch},
			dataType: 'json',
			success: function(obj){
				if(obj.length>0){
					htmlProducto="";
					obj.forEach(element => {
						htmlProducto+=`<tr>
										<th data-productoid="${element.id}" data-productostock="${element.stock}" style="cursor: pointer" class="tr-producto">${element.nombre}</th>
						</tr>`;
					});
					$('#table-productos').DataTable().destroy();
					$('#table-productos-body').html(htmlProducto);
					$("#table-productos").dataTable(dt_config);
				}
			}
		});
		
	}
	$("#btn-save-solicitud").click(function(){
		btnSave=$(this);
		btnSave.prop('disabled',true);
		productos = productos();
		if(productos.length>0){
			v_token = "{{ csrf_token() }}";
			note=$("#solicitud_note").val();
			$.ajax({
				url: "{{route('solicitud.submit')}}",
				type: "POST",
				data: {"_token":v_token,"productos":productos,"note":note},
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
					Swal.fire({
						position: "bottom-end",
						icon: obj.type,
						title: obj.titulo,
						text: mensaje,
						showConfirmButton: false,
						timer: 3000
					});
					if(obj.sw_error==0){
						Swal.fire({
							icon: 'success',
							title: 'Se realizo la solicitud correctamente.',
							text: 'Numero de solicitud #'+obj.code,
							allowOutsideClick : false
						}).then((result) => {
							window.location.href = "{{route('solicitud.show')}}/"+obj.code;
						})
					}
				}
			});
		}else{
			Swal.fire({
				position: "center",
				icon: "warning",
				title: "Atención",
				text: 'Agregue productos a la solicitud.',
				showConfirmButton: false,
				timer: 2500
			});
			btnSave.prop('disabled',false);
		}
		
	
		
	});
	function productos(){
		table = $("#table-detalle-productos-body").find('tr');
		let productos = [];
		if(table.length>0){
			table.each(function(){
				cantidad=parseInt($(this).find('input').val());
				id=$(this).data('productoid');
				producto = {"id":id,"cantidad":cantidad};
				productos.push(producto);
			});
		}
		return productos;
	}

	//END
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
	
	
</script>
@endsection