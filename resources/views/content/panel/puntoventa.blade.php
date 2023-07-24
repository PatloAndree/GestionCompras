@extends('layouts/contentLayoutMaster')
@section('title', 'Punto de venta')

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
                            <div class="col-md-12 text-left mb-1">
                                <button class="btn btn-flat-success align-self-start" tabindex="0" type="button" data-bs-toggle="modal" id="añadirProducto">
                                    <i data-feather="plus-circle"></i> producto
                                    </button>
                            </div>
                            <div class="col-12 col-md-4 mb-1">
                                <label class="form-label" for="compra_proveedor">Dni</label>
                                <input type="number" class="form-control" name="dni_cliente" id="dni_cliente" placeholder="1111111">
                            </div>
                            <div class="col-12 col-md-8 mb-1">
                                <label class="form-label" for="nombres_cliente">Cliente</label>
                                <input type="text" class="form-control" name="nombres_cliente" id="nombres_cliente">
                            </div>
                            <div class="col-12 col-md-12 mb-1">
                                <label class="form-label" for="searchProducto">Buscar producto</label>
                                <select id="searchProducto" name="searchProducto" class="form-control"></select>
                            </div>
                            <div class="col-12 col-md-12 mb-1">
                                <div class="card-datatable table-responsive pt-0">
                                    <table class="table" id="table-productos">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-left">Producto</th>
                                                <th>Cantidad</th>
                                                <th>Stock</th>
                                                <th>Precio venta</th>
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

					{{-- CARD LADO DERECHO --}}
                    <div class="col-12 col-md-3">
                        <div class="row">
                            <div class="col-12 col-md-12 mb-1">
                                <label class="form-label" for="compra_fecha">Fecha de venta(*)</label>
                                <input type="date" id="compra_fecha" name="compra_fecha" value="" class="form-control" readonly/>
                            </div>
                            <div class="col-12 col-md-12 mb-1">
                                <label class="form-label" for="compra_codigo">Codigo de venta</label>
                                <input type="text" id="compra_codigo" name="compra_codigo" value="{{$ramdon}}" readonly class="form-control"/>
                            </div>
                            <div class="col-12 col-md-12 mb-1">
                                <label class="form-label" for="compra_comprobante">Boleta o Factura (*)</label>
                                {{-- <input type="text" id="compra_comprobante" name="compra_comprobante" class="form-control"/> --}}
								<select class="form-select" aria-label="Default select example"  id="compra_comprobante" name="compra_comprobante" required>
									<option selected>Seleccionar</option>
									<option value="1">Boleta</option>
									<option value="2">Factura</option>

								</select>
                            </div>
                            <div class="col-12 col-md-12 mb-1">
                                <label class="form-label" for="compra_adicional">Información adicional</label>
                                <textarea class="form-control" id="compra_adicional" rows="1" name="compra_adicional"></textarea>
                            </div>
                            <div class="col-12 col-md-6 mb-1">
                                <label class="form-label" for="compra_monto">Sub Total </label>
                                <input type="text" id="compra_monto" name="compra_monto" class="form-control" readonly/>
                            </div>
							<div class="col-12 col-md-6 mb-1">
                                <label class="form-label" for="igv">IGV 18%</label>
                                <input type="text" id="igv" name="igv" class="form-control" value="" readonly/>
                            </div>
							<div class="col-12 col-md-12 mb-1">
                                <label class="form-label" for="compra_monto_total">Monto Final</label>
                                <input type="text" id="compra_monto_total" name="compra_monto_total" class="form-control" readonly/>
                            </div>
                            <div class="col-md-12 d-flex justify-content-between mt-1 pt-50">
                                <a class="btn btn-outline-danger" href="{{route('puntoventa.index')}}">Cancelar</a>
                                <button type="button" id="btn_save_compra" class="btn btn-success ">Vender</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

	{{-- MODAL AGREGAR PRODUCTO --}}
    <div class="modal fade" id="modalNuevo" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header bg-transparent">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body pb-5 px-sm-5 pt-50">
					<div class="text-center mb-2">
						<h4 class="mb-1" id="title-modal">Agregar producto</h4>
					</div>
					<form id="nuevoProductoForm" name="nuevoProductoForm" method="post" enctype="multipart/form-data" class="row gy-1 pt-75">
						{{-- <div class="col-12 col-md-6"> --}}
							<div class="col-12 col-md-12">
								<label class="form-label" for="categoria_producto">Categoria</label>
								<select class="form-select" aria-label="Default select example"  id="categoria_productoN" name="categoria_producto">
									<option selected>Seleccionar categoria</option>
									@foreach ($categorias as $categoria)
										<option value="{{$categoria['id']}}">{{$categoria['nombre_categoria']}}</option>
									@endforeach 
								</select>
							</div>
		
							<input type="text" class="hidden" placeholder="Ace,Gloria,Coca cola..." id="idProducto"  name="idProducto" >
							<div class="col-md-12">
								<label class="form-label" for="categoria_producto">Producto</label>
								<input type="text" class="form-control" placeholder="Nombre producto" id="nombre_productoN" name="nombre_producto">
							</div>
							<div class="col-md-6">
								<label class="form-label" for="categoria_producto">Producto Abreviatura</label>
								<input type="text" class="form-control" placeholder="Nombre producto" id="nombre_abrevN" name="nombre_abrev">
							</div>

							<div class="col-md-6">
								<label class="form-label" for="categoria_producto">Marca</label>
								<input type="text" class="form-control" placeholder="Ace,Gloria,Coca cola..." id="marca_productoN"  name="marca_producto" >
							</div>
							
		
							<div class="col-12 col-md-4">
								<label class="form-label" for="categoria_producto">Precio compra</label>
								
								<input type="number" class="form-control" placeholder="10" id="precio_compraN" name="precio_compra">
							</div>
							<div class="col-12 col-md-4">
								<label class="form-label" for="categoria_producto">Precio venta</label>
								
								<input type="number" class="form-control" placeholder="10" id="precio_ventaN" name="precio_venta">
							</div>
							<div class="col-12 col-md-4">
								<label class="form-label" for="categoria_producto">Stock</label>
								
								<input type="number" class="form-control" placeholder="10" id="producto_stockN" name="stock_producto">
								
							</div>
		
							<div class="col-md-12 col-span-6">
								<label class="form-label" for="categoria_producto">Fecha</label>
								
								<input type="date" class="form-control"  id="fecha_ven_productoN" name="fecha_ven_producto">
							</div>
							<div class="col-span-12 col-span-12">
								<label class="form-label" for="categoria_producto">Foto</label>
								
								<input type="file" class="form-control"  id="foto_producto" name="foto_producto"  onchange="previewImageEdit(event, '#imgPreviewEdit')">
							</div>
							<div class="col-span-12 col-span-12" id="foto_bd">
								<img id="imgPreview"   style="max-width:150px;border-radius:15px">
							</div>
						{{-- </div> --}}
					</form>
					
				</div>
				<div class="modal-footer">
					<button type="button" id="nuevoProductoCrear" class="btn btn-success me-1">Guardar</button>
					<button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal" aria-label="Close">Cancelar</button>
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
<script src="{{ asset('js/scripts/multiselect/jquery.multi-select.js') }}"></script>
<script src="{{ asset('js/scripts/multiselect/jquery.quicksearch.min.js') }}"></script>
<script src="{{ asset('js/scripts/numeric/numeric.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>


<script>
    
    $( document ).ready(function() {
    console.log( "ready!" );
    var fecha = new Date().toISOString().slice(0, 10);
    document.getElementById("compra_fecha").value = fecha;
    });

    $('#añadirProducto').on('click', function(){
        $("#nombre_productoN").val('');
        $("#marca_productoN").val('');
        $("#idProductoN").val('');
        $("#stock_productoN").val('');
        $("#precio_compraN").val('');
        $("#precio_ventaN").val('');
        $("#producto_imageN").val('');
        $("#categoria_productoN").val('Seleccionar categoria');
        $("#fecha_ven_productoN").val('');
        $("#producto_stockN").val('');
        document.getElementById('imgPreview').src = "https://mdbootstrap.com/img/Photos/Others/placeholder.jpg";
        $("#modalNuevo").modal('show');
    });

    function previewImage(event, querySelector){
            //Recuperamos el input que desencadeno la acción
            const input = event.target;
            //Recuperamos la etiqueta img donde cargaremos la imagen
            $imgPreview = document.querySelector(querySelector);
            // Verificamos si existe una imagen seleccionada
            if(!input.files.length) return
            //Recuperamos el archivo subido
            file = input.files[0];
            //Creamos la url
            objectURL = URL.createObjectURL(file);
            //Modificamos el atributo src de la etiqueta img
            $imgPreview.src = objectURL;           
    }
 

    $('#nuevoProductoCrear').on('click', function(){
			formData = new FormData(document.getElementById("nuevoProductoForm"));
			v_token = "{{ csrf_token() }}";
            formData.append("_method", "POST");
			formData.append("_token", v_token);
            $.ajax({
                url: "{{route('producto.create')}}",
                type: "POST",
                data: formData,
                dataType: 'json',
                processData: false, 
                contentType: false,
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
                        console.log(obj.message);
                        Swal.fire({
								position: "bottom-end",
								icon: "success",
								title: "Exito",
								text: obj.message,
								showConfirmButton: false,
								timer: 2500
							});
                        setTimeout(() => {
                            $("#modalNuevo").modal('hide');
						}, 1000);
                    }
                }
            });
            
    });


    	
	var jsonSearch = {
		placeholder: 'Busca y selecciona producto',
		minimumInputLength: 1,
		language: {
			inputTooShort: function() {
				return '';
			}
		},
		ajax: {
			url: '{{route("productoVenta.search")}}',
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
					obj.precio ;

					return obj;
				});
                console.log(data);
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
		// minimumInputLength: 3
	};
	var $searchProducto = $("#searchProducto").select2(jsonSearch);
	
	$("#table-productos-body").on('click', '.bootstrap-touchspin-up',function(){
		fila=$(this).parent().parent().parent().parent().parent().parent();
		cantidadInput =fila.find('td:eq(1)').find('input');
		cantidad = parseInt(cantidadInput.val());

		stockInput = fila.find('td:eq(2)').find('input');
		stock = parseInt(stockInput.val());
		precioInput = fila.find('td:eq(3)').find('input');
		totalInput = fila.find('td:eq(4)').find('input');
		precio =  parseFloat(precioInput.val());
		nuevaCantidad = cantidad + 1;
		nuevoPrecio = parseFloat(nuevaCantidad*precio).toFixed(2);

		if(stock > 0){
			nuevoStock = stock - 1;
			stockInput.val(nuevoStock);
			cantidadInput.val(nuevaCantidad);
		}
		totalInput.val(nuevoPrecio);
		totalCompra();
	});

	$("#table-productos-body").on('click','.bootstrap-touchspin-down',function(){
		fila = $(this).parent().parent().parent().parent().parent().parent();
		cantidadInput =fila.find('td:eq(1)').find('input');
		cantidad = parseInt(cantidadInput.val());
		precioInput = fila.find('td:eq(3)').find('input');
		totalInput = fila.find('td:eq(4)').find('input');
		precio = parseFloat(precioInput.val());
		nuevaCantidad = cantidad - 1;
		stockInput = fila.find('td:eq(2)').find('input');
		stock = parseInt(stockInput.val());

		if(nuevaCantidad>=1){
			nuevoStock = stock + 1;
			stockInput.val(nuevoStock);
		}

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
		cantidadInput =fila.find('td:eq(1)').find('input');
		cantidad = parseInt(cantidadInput.val());
		precio = parseFloat(fila.find('td:eq(2)').find('input').val());
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
		cantidad =fila.find('td:eq(1)').find('input').val();
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
				url: "{{ route('puntoventa.data') }}/"+productoID,
				type: "GET",
				data: {_token:v_token,_method:method},
				dataType: 'json',
				success: function(obj){
					if(obj.sw_error==0){
						addFila(obj.data);
                        console.log(obj.data);
						$searchProducto.select2("destroy");
						$('#searchProducto').empty();
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
				// fecha=$(this).find('td:eq(1)').find('input').val();
				cantidad=$(this).find('td:eq(1)').find('input').val();
				precio= parseFloat($(this).find('td:eq(3)').find('input').val()).toFixed(2);
				precio_total= parseFloat($(this).find('td:eq(4)').find('input').val()).toFixed(2);

				stock= parseFloat($(this).find('td:eq(2)').find('input').val());

				id=$(this).data('productoid');
				if(precio>0){
					producto = {"id":id,"stock":stock,"cantidad":cantidad,"precio":precio,"precio_total":precio_total};
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
				subTotal = total * 0.18;
				montoIgv = total + subTotal;
			});
			$("#compra_monto").val(total.toFixed(2));
			$("#igv").val(subTotal.toFixed(2));
			$("#compra_monto_total").val(montoIgv.toFixed(2));

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
						<td>${producto. nombre_producto}</td>
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
						<td><input class="form-control stock_producto " type="text" value="${producto. stock_producto - 1}" disabled></td>
						<td><input class="form-control precio-compra number-decimal" type="text" value="${producto. precio_venta}" required></td>
						<td><input class="form-control number-decimal" type="text" value="${producto. precio_venta}" required disabled></td>
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
	
	$("#btn_save_compra").click(function(){
		// btnSave=$(this);
		// btnSave.prop('disabled',true);
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
						url: "{{route('puntoventa.create')}}",
						type: "POST",
						data: formData,
						cache:false,
						contentType: false,
						processData: false,
						dataType: 'json',
						success: function(obj){
							// if(typeof obj.message === 'object' && obj.message !== null){
							// 	mensaje='';
							// 	Object.values(obj.message).forEach(element => {
							// 		mensaje+=element+'<br>';
							// 	});
							// }else{
							// 	mensaje=obj.message;
							// }
							if(obj.sw_error==1){
								Swal.fire({
									position: "bottom-end",
									icon: "warning",
									title: "Atención",
									text: obj.message,
									showConfirmButton: false,
									timer: 2500
								});
								// btnSave.prop('disabled',false);
							}else{
								Swal.fire({
									position: "bottom-end",
									icon: "success",
									title: "Éxito",
									text: obj.message,
									showConfirmButton: false,
									timer: 2500
								});
								setTimeout(() => {
									window.location.href = "{{route('puntoventa.index')}}";
									// location.reload();
								}, 2500);
							}
						}
					});
				}else{
					Swal.fire({
						position: "center",
						icon: "warning",
						title: "Atención",
						text: 'Asegurese que lleno todos los campos obligatorios para realizar la venta.',
						showConfirmButton: false,
						timer: 2500
					});
					btnSave.prop('disabled',false);
				}
		}else{
			// btnSave.prop('disabled',false);
		}
		
	
		
	});

	$("#dni_cliente").on('change',function(){
		// documento = $("#paciente_tipo_documento").val();
		ndocumento = $("#dni_cliente").val().trim();
		if((ndocumento.length==8)){
			getCliente();
		}
	});

	function getCliente(){
		documento = 1;
		ndocumento = $("#dni_cliente").val().trim();
		$.ajax({
			url: "{{route('paciente.data')}}"+"/"+documento+"/"+ndocumento,
			type: "GET",
			data: {},
			dataType: 'json',
			success: function(obj){
				if(obj){
					$("#nombres_cliente").val(obj.name + ' ' +obj.last_name );
					// $("#paciente_last_name").val(obj.last_name);
					// $("#paciente_age").val(obj.age);
					// $("#paciente_sex").val(obj.sex);
					// $("#paciente_address").val(obj.address);
					// $("#paciente_phone").val(obj.phone);
					// $("#email").val(obj.email);
				}else{
					Swal.fire({
						toast: true,
						position: "bottom-end",
						icon: "warning",
						text: "cliente no identificado.",
						showConfirmButton: false,
						timer: 2500
					});
				}
			}
		});
	}




</script>
@endsection