@extends('layouts/contentLayoutMaster')
@section('title', 'Atención de solicitud')

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
					<div class="row justify-content-start">
						
						<div class="col-12 col-md-3 mb-1 justify-content-lg-end">
							<label class="form-label" for="searchProducto"></label>
							<button class="btn btn-primary btn-sm " id="nuevo_producto" type="button"><i data-feather="plus-square" color="white"></i> PRODUCTO</button>
						</div>
						<div class="col-12 col-md-12 mb-1">
							<div class="card-datatable table-responsive pt-0">
								<table class="table" id="table-detalle-productos">
									<thead class="table-light">
										<tr>
											<th>#</th>
											<th>Producto</th>
											<th>Cantidad solicitada</th>
											<th>Cantidad a enviar</th>
											<th>Acción</th>
										</tr>
									</thead>
									<tbody id="table-detalle-productos-body">
										
										@foreach ($solicitudDetalles as $solicitudDetalle)
											<tr id="detalle-id-{{$solicitudDetalle->producto_id}}" data-productoid="{{$solicitudDetalle->producto_id}}" data-type="detalle">
												<th></th>
												<th>{{$solicitudDetalle->dataproducto->nombre}}</th>
												<th><input type="input" class="form-control cantidadSolicitada" value="{{$solicitudDetalle->cantidad_solicitada}}" readonly></th>
												<th><input type="input" class="form-control cantidadEnviar number-integer" data-stock="{{$solicitudDetalle->dataproducto->stock}}" value="0"></th>
												<th></th>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-5">
					<input type="hidden" class="form-control" id="solicitud_id" value="{{$solicitud->id}}" readonly>
					<div class="row">
						<div class="col-12 col-md-12 mb-1">
							<div class="card-datatable pt-0">
								<div class="row">
									<div class="col-md-12 mb-1">
										<label for="solicitud-usuario" class="form-label">Solicitante</label>
										<input type="text" class="form-control" id="solicitud-usuario" value="{{$solicitud->usuario->name.' '.$solicitud->usuario->last_name}}" readonly>
									</div>
									<div class="col-md-12 mb-1">
										<label for="solicitud-sede" class="form-label">Sede</label>
										<input type="text" class="form-control" id="solicitud-sede" value="{{$solicitud->sede->name}}" readonly>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-md-12 mb-1">
							<label class="form-label" for="solicitud_note">Información adicional del solicitante</label>
							<textarea class="form-control" id="solicitud_note" rows="4" name="solicitud_note" readonly>{{$solicitud->note}}</textarea>
						</div>
						<div class="col-12 col-md-12 mb-1">
							<label class="form-label" for="solicitud_note_final">Información adicional</label>
							<textarea class="form-control" id="solicitud_note_final" rows="4" name="solicitud_note_final"></textarea>
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

	<!-- MODAL DE AÑADIR USUARIOS -->
	<div class="modal fade" id="modals-producto" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">

				<div class="modal-header bg-transparent">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<div class="modal-body pb-5 px-sm-5 pt-50">
					<div class="text-left mb-2">
						<h1 class="mb-1" id="title-modal"></h1>
					</div>
					<div class="row">
						<!-- CABECERA -->
						<div class="col-12 col-md-3 mb-1">
							<label class="form-label" for="solicitud_unidad">Unidades</label>
							<select id="solicitud_unidad" class="form-control">
								<option value="">Seleccionar</option>
								@foreach ($unidades as $unidad)
									<option value="{{$unidad->id}}">{{$unidad->nombre}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-12 col-md-6 mb-1">
							<label class="form-label" for="searchProducto">Buscar</label>
							<input type="text" class="form-control" id="searchProducto">
						</div>
						<!-- LISTADO -->
						<div class="col-12 col-md-12 mb-1">
							<div class="card-datatable table-responsive pt-0">
								<table class="table" id="table-productos">
									<thead class="table-light">
										<tr>
											<th>Producto</th>
											<th class="text-right">Stock</th>

										</tr>
									</thead>
									<tbody id="table-productos-body">
										@foreach ($productos as $producto)
											<tr id="color-la" class="color-l">
												<th data-productoid="{{$producto->id}}" 
												data-productostock="{{$producto->total_stock}}" 
												style="cursor: pointer" class="tr-producto">{{$producto->nombre}}</th>
												<th class="text-right">{{$producto->stock}}</th>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
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

	$( document ).ready(function() {
		validateNumber();
	});

	
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

	$("#table-productos-body").on('click','input.cantida_send', function(){
		console.log($(this));
	});

	$("#nuevo_producto").click(function(){
		// $(this).prop('disabled',true);
		$("#title-modal").html('<h4>AGREGAR PRODUCTOS</h4>');
		$("#tipo_submit").val(0);
		$("#modals-producto").modal('show');
		$('#m_m').text('+');

	});

	$("#table-products").on('click','.producto-edit', function(){
		alert("PRODUCTO REGISTRADO");
	});

	var dt_ajax = $("#table-productos-g").dataTable(dt_config);

	contador = 0;



	$("#table-productos-body").on("click", ".color-l",function(){
		
		$(this).css({
			background: "#3489db",
			color: "white",
			});
			
	});

	$("#table-productos-body").on('click','.tr-producto',function(){
		contador++;
		productoId=$(this).data('productoid');
		$(this).css({
			background: "#3489db",
			color: "white",
			});
		// AQUI ME FALTO HACERLE UN CONTADOR
		productoStock=parseInt($(this).data('productostock'));
		productoNombre=$(this).text();
		detalleProducto = $("tr#detalle-id-"+productoId);


		if(detalleProducto.length==0){
			
			htmlDetalle=`
							<tr id="detalle-id-${productoId}" data-productoid="${productoId}" data-type="nuevo">
								<th></th>
								<th>${productoNombre}</th>
								<th><input type="input" class="form-control cantidadSolicitada" value="0" readonly></th>
								<th><input type="input" class="form-control cantidadEnviar number-integer" data-stock="${productoStock}" value="1"></th>
								</tr>
									`;
			$("#table-detalle-productos-body").append(htmlDetalle);
			feather.replace();
			validateNumber();
			
				$("#modals-producto").modal('hide');
		}else{
			inputCantidad=detalleProducto.find('.cantidadEnviar');
			cantidadActual=parseInt(inputCantidad.val());
			if(cantidadActual<productoStock){
				inputCantidad.val(cantidadActual+1);
				$("#modals-producto").modal('hide');
			}else{
				Swal.fire({
					position: "bottom-end",
					icon: 'error',
					title: 'Atención',
					text: 'No hay stock disponible.',
					showConfirmButton: false,
					timer: 3000
				});
			}
		}
	});
	
	$("#table-detalle-productos-body").on('change', '.cantidadEnviar',function(){
		stock=$(this).data('stock');
		if(this.value==''){
			this.value=0;
		}else{
			this.value=parseInt(this.value);
		}
		
		if(this.value>stock){
			this.value=stock;
		}
		validateNumber();
		/*console.log(this.value);
		*/
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
		// $(this).parent().parent().parent().parent().parent().parent().remove();
		$(this).parent().parent().parent().parent().remove();


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
		unidad=$("#solicitud_unidad").val();
		v_token = "{{ csrf_token() }}";
		$.ajax({
			url: "{{route('solicitud.buscar')}}",
			type: "POST",
			data: {"_token":v_token,"unidad":unidad,"textoSearch":textoSearch},
			dataType: 'json',
			success: function(obj){
				if(obj.length>0){
					htmlProducto="";
					obj.forEach(element => {
						htmlProducto+=`<tr>
										<th data-productoid="${element.id}" data-productostock="${element.stock}"
										 style="cursor: pointer" class="tr-producto">${element.nombre}</th>
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
			note=$("#solicitud_note_final").val();
			solicitud_id=$("#solicitud_id").val();
			$.ajax({
				url: "{{route('solicitud.finalizar')}}",
				type: "POST",
				data: {"_token":v_token,"productos":productos,"note":note,"solicitud_id":solicitud_id},
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
							title: 'Se realizo la solicitud correctamente.<br>',
							html: 'La solicitud fue atendida y guardad,<br>' +
							'Puede ver su pdf de la solicitud en el siguiente link :<br>'+
							`<a href="{{route('solicitud.pdf')}}/`+obj.code+`">Solicitud #`+obj.code+`</a>`,
							allowOutsideClick : false
						}).then((result) => {
							window.location.href = "{{route('solicitud.show')}}/"+obj.code;
						});
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
				cantidad=parseInt($(this).find('.cantidadEnviar').val());
				id=$(this).data('productoid');
				type=$(this).data('type');
				producto = {"id":id,"cantidad":cantidad,"type":type};
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
	
	
</script>
@endsection