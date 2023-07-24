@extends('layouts/contentLayoutMaster')

@section('title', 'Hoja de ruta')
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
    <ul class="nav nav-tabs nav-fill mb-3" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#h_ruta" type="button" role="tab" aria-controls="home" aria-selected="true">Hoja de ruta</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#checklist" type="button" role="tab" aria-controls="profile" aria-selected="false">Check lista</button>
        </li>
    </ul>

<div class="tab-content" id="myTabContent">

    <!-- TAB HOJA DE RUTA -->
  <div class="tab-pane fade show active" id="h_ruta" role="tabpanel" aria-labelledby="home-tab">
  
        <div class="card">
            <div class="card-body">
                    <div class="border-bottom mt-0 mb-2 pb-2">
                        <div class="form-group row">
                        
                            <div class="col-sm-6">
                        
                            <input type="text"  class="form-control-plaintext  sub_base"  disabled  id="sub_base" name="sub_base" style="font-size:16px;font-weight:700;" value="<?php echo $data['sub_base']; ?>">
                            </div>

                            <div class="col-sm-6">
                            <input type="text"  class="form-control-plaintext  hoja_piloto"  disabled  id="hoja_piloto" name="hoja_piloto" style="font-size:16px;text-align: right;font-weight:700;" value="<?php echo $nombre_piloto; ?>"">
                            </div>
                        </div>                   
                                            
                    </div>
                    <form id="hojaderutaformUpdate" name="hojaderutaformUpdate" class="mt-1" >	
                            <input type="hidden" value="<?php echo $hoja ?>" id="id_hojaruta">
                            <div class="row">
                                        <div class="col-md-6" >
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">Fecha de reporte :</label>
                                                    <div class="col-sm-3">
                                                    <input type="date"  class="form-control-plaintext hoja_fecha" readonly  id="hoja_fecha" name="hoja_fecha"   value="<?php echo $data['fecha_reporte']; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label"> Paramedico :</label>
                                                    <div class="col-sm-6">
                                                        <select class="form-select" disabled id="hoja_paramedico" name="hoja_paramedico">
                                                            <option selected><?php echo $enfermero ?> </option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">Km. inicial :</label>
                                                    <div class="col-sm-6">
                                                    <input type="number" disabled  class="form-control-plaintext border-bottom hoja_km_inicial"  id="hoja_km_inicial" name="hoja_km_inicial"  value="<?php echo $data['km_inicial']; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">Km. final :</label>
                                                    <div class="col-sm-6">
                                                    <input type="number"  class="form-control-plaintext border-bottom hoja_km_final" readonly  id="hoja_km_final" name="hoja_km_final"  value="<?php echo $data['km_final']; ?>">
                                                    </div>
                                                </div>

                                        
                                                <div class="form-group row mt-1">
                                                    <label for="staticEmail" disabled class="col-sm-3 col-form-label">Sub base : </label>
                                                    <div class="col-sm-6">
                                                        <select class="form-select" id="select_base" disabled name="select_base">
                                                            <option selected><?php echo $sedes ?> </option>
                                                            
                                                          
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">N° vales combustible :</label>
                                                    <div class="col-sm-6">
                                                    <input type="number"  class="form-control-plaintext border-bottom hoja_km_final" disabled id="n_vales" name="n_vales" value="<?php echo $data['numero_vales']; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">Valorizado en :</label>
                                                    <div class="col-sm-6">
                                                    <input type="number"  class="form-control-plaintext border-bottom hoja_km_final"disabled  id="valorizado" name="valorizado" value="<?php echo $data['valorizado']; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">Galones :</label>
                                                    <div class="col-sm-6">
                                                    <input type="number"  class="form-control-plaintext border-bottom galones" disabled  id="galones" name="galones" value="<?php echo $data['galones']; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">SOAT :</label>
                                                    <div class="col-sm-6">
                                                    <input type="number"  class="form-control-plaintext border-bottom soat" readonly  id="soat" name="soat" value="<?php echo $datos_ambulancia['soat']; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">Revisión técnica :</label>
                                                    <div class="col-sm-6">
                                                    <input type="number"  class="form-control-plaintext border-bottom revision_tecnica"  id="revision_tecnica" name="revision_tecnica" readonly value="<?php echo $datos_ambulancia['revision_tecnica']; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">Ultimo cambio de aceite :</label>
                                                    <div class="col-sm-6">
                                                    <input type="date"  class="form-control-plaintext  ultimo_aceite"  readonly id="ultimo_aceite" name="ultimo_aceite" value="<?php echo $datos_ambulancia['ult_cambio_aceite']; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label for="staticEmail" class="col-sm-3 col-form-label">Ultimo cambio de aceite :</label>
                                                    <div class="col-sm-6">
                                                    <input type="date"  class="form-control-plaintext  proximo_aceite"  readonly id="proximo_aceite" name="proximo_aceite" value="<?php echo $datos_ambulancia['prox_cambio_aceite']; ?>">
                                                    </div>
                                                </div>

                                            </div>    
                                        </div>
                                        
                                        <div class="col-6 text-center ">
                                        <label for="" class="mt-0 col-form-label">Indicar nivel de gasolina</label>

                                            <div class="row ">      
                                                <div class="col-md-6 justify-content-end">
                                                        <span class="brand-logo">
                                                            <img src="{{ asset('images/login/indi.jpg')}}" style="max-width:300px;float:right" class="img-fluid ">
                                                        </span>
                                                </div>
                                                <div class="col-md-4 text-left">
                                                    <span class="brand-logo">
                                                        <img src="{{ asset('images/login/gaso.jpg')}}" style="max-width:250px" class="img-fluid">
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row justify-content-center mr-0 ml-0">
                                                <div class="col-md-3 ">
                                                        <input type="text" value="<?php echo $data['gaso1']; ?>" id="hoja_gaso1" disabled name="hoja_gaso1" class="form-control">
                                                </div>
                                                <div class="col-md-3 ">
                                                        <input type="text" value="<?php echo $data['gaso2']; ?>" id="hoja_gaso2" disabled name="hoja_gaso2" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                            </div>

                            <div class="row mt-4">
                                {{-- <div class="col-md-1 mb-1">
                                    <a class="btn btn-info" tabindex="0" id="new_detalle"  target="_blank"><span>+</span></a>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="card-datatable table-responsive pt-0">
                                    
                                        <table class="user-list-table table" id="table_hojaruta">
                                            <thead class="table-light">
                                                <tr>
                                                    
                                                    <th>Dirección</th>
                                                    <th>Departamento</th>
                                                    <th>Provincia</th>
                                                    <th>Distrito</th>
                                                    <th>Hora llegada</th>
                                                    <th>Kilometraje</th>
                                                    <th>Hora salida</th>
                                                    <th>Actions</th>

                                                </tr>
                                            </thead>
                                            <tbody id="bodyAsistencia">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2">
                                                <label class="form-label" for="observacion_hoja">Observación</label>
                                                <textarea name="observacion_hoja" id="observacion_hoja" name="observacion_hoja" rows="3" disabled class="form-control"  cols="30" placeholder="Escribe alguna observación"><?php echo $data['observacion']; ?> </textarea>
                                </div>
                             
                            </div>
                    </form>
                    <div class="col-md-12 mt-2 d-none">
                                    <label class="form-label" for="observacion_hoja">detalles</label>
                                    <input type="text" data-id='<?php echo $hojasdetalles; ?>' id="detalles_data" > 
                    </div>
            </div>

            <input type="hidden" value='{{json_encode($distritos)}}' id="distritos_list">
            <input type="hidden" value='{{json_encode($departamentos)}}' id="departamentos_list">
            <input type="hidden" value='{{json_encode($provincias)}}' id="provincias_list">
        </div>
</div>

  <!-- TAB CHECK LISTA -->
  <div class="tab-pane fade" id="checklist" role="tabpanel" aria-labelledby="profile-tab">
 
        <div class="card">
                <div class="card-body border-bottom mt-0 mb-0">
                    <div class="form-group row">        
                            <div class="col-sm-6">
                            <input type="text"  class="form-control-plaintext  sub_base"  disabled  id="sub_base" name="sub_base" style="font-size:16px;font-weight:700;" value="<?php echo $data['sub_base']; ?>">
                            </div>

                            <div class="col-sm-6">
                            <input type="text"  class="form-control-plaintext  hoja_piloto"  disabled  id="hoja_piloto" name="hoja_piloto" style="font-size:16px;text-align: right;font-weight:700;" value="<?php echo $nombre_piloto; ?>"">
                            </div>
                        </div>                   
                                            
                    </div>

                    <div class="row">

                        <div class="col-md-11 text-center">
                                <span class="brand-logo">
                                    <img src="{{ asset('images/login/furgo.webp')}}" style="max-width:300px" class="img-fluid">
                                </span>
                        </div>
                    </div>

                    <div class="card-body row">

                            <div class="col-md-3">
                                <h5>CABINA</h5>
                                        <div class="form-check">
                                            <input class="form-check-input" disabled type="checkbox" name="pedal_embriague" id="pedal_embriague" value="" <?php if($checklist['pedal_embriague']== 1) echo "checked";?> >
                                            <label class="form-check-label" for="exampleRadios1">
                                                Pedal de embriague
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" disabled type="checkbox" name="pedal_freno" id="pedal_freno" value="" <?php if($checklist['pedal_freno']== 1) echo "checked";?>>
                                            <label class="form-check-label" for="exampleRadios2">
                                                Pedal de freno
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" disabled type="checkbox" name="pedal_acelerar" id="pedal_acelerar" value="" <?php if($checklist['pedal_acelera']== 1) echo "checked";?> >
                                            <label class="form-check-label" for="exampleRadios3">
                                                Pedal de acelerador
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" disabled type="checkbox" name="asientos_cabeza" id="asientos_cabeza" value="" <?php if($checklist['asientos_cabezal']== 1) echo "checked";?> >
                                            <label class="form-check-label" for="exampleRadios3">
                                                Asientos y cabezal
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" disabled type="checkbox" name="espejo_retrovisor" id="espejo_retrovisor" value="" <?php if($checklist['espejo_retrovisor']== 1) echo "checked";?> >
                                            <label class="form-check-label" for="exampleRadios3">
                                                Espejo retrovisor
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" disabled type="checkbox" name="freno_mano" id="freno_mano" value="" <?php if($checklist['freno_mano']== 1) echo "checked";?> >
                                            <label class="form-check-label" for="exampleRadios3">
                                                Freno de mano
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" disabled type="checkbox" name="cenicero" id="cenicero" value="" <?php if($checklist['cenicero']== 1) echo "checked";?> >
                                            <label class="form-check-label" for="exampleRadios3">
                                                Cenicero
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" disabled type="checkbox" name="menijas" id="menijas" value="" <?php if($checklist['manijas']== 1) echo "checked";?> >
                                            <label class="form-check-label" for="exampleRadios3">
                                                Manijas
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" disabled type="checkbox" name="palanca" id="palanca" value="" <?php if($checklist['palanca_cambios']== 1) echo "checked";?> >
                                            <label class="form-check-label" for="exampleRadios3">
                                                Palanca de cambios
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" disabled type="checkbox" name="parabrisas" id="parabrisas" value="" <?php if($checklist['parabrisas']== 1) echo "checked";?> >
                                            <label class="form-check-label" for="exampleRadios3">
                                                Parabrisas
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" disabled type="checkbox" name="panilla_luces" id="panilla_luces" value="" <?php if($checklist['planilla_luces']== 1) echo "checked";?> >
                                            <label class="form-check-label" for="exampleRadios3">
                                                Panilla de luces
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" disabled type="checkbox" name="radio" id="radio" value="" <?php if($checklist['radio']== 1) echo "checked";?> >
                                            <label class="form-check-label" for="exampleRadios3">
                                            Radio
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" disabled type="checkbox" name="tapasol" id="tapasol" value="" <?php if($checklist['tapasol']== 1) echo "checked";?> >
                                            <label class="form-check-label" for="exampleRadios3">
                                            Tapasol
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" disabled type="checkbox" name="tapis" id="tapis" value="" <?php if($checklist['tapis']== 1) echo "checked";?> >
                                            <label class="form-check-label" for="exampleRadios3">
                                            Tapis
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" disabled type="checkbox" name="extintor" id="extintor" value="" <?php if($checklist['extintor']== 1) echo "checked";?> >
                                            <label class="form-check-label" for="exampleRadios3">
                                            Extintor
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" disabled type="checkbox" name="estribos" id="estribos" value="" <?php if($checklist['estribos']== 1) echo "checked";?> >
                                            <label class="form-check-label" for="exampleRadios3">
                                            Estribos
                                            </label>
                                        </div>
                                        <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="nivel_aceite" id="nivel_aceite" value="1" <?php if($checklist['mivel_aceite']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios1">
                                            Nivel de aceite
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="frenos" id="frenos" value="" <?php if($checklist['freno']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Freno
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="nivel_bateria" id="nivel_bateria" value="" <?php if($checklist['nivel_bateria']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Nivel de bateria
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="kilometraje" id="kilometraje" value="" <?php if($checklist['kilometraje']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Kilometraje
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="nivel_temperatura" id="nivel_temperatura" value="" <?php if($checklist['nivel_temperatura']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Nivel de temperatura
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="reloj" id="reloj" value="" <?php if($checklist['reloj']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Reloj
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="nivel_combustible" id="nivel_combustible" value="" <?php if($checklist['nivel_combustible']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Nivel de combustible
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="mica" id="mica" value="" <?php if($checklist['mica']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Mica
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="direccionales" id="direccionales" value="" <?php if($checklist['direccionales']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Direccionales
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="pisos" id="pisos" value="" <?php if($checklist['pisos']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Pisos
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="timon_claxon" id="timon_claxon" value="" <?php if($checklist['timon_claxon']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Timón y claxón
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="ventanas" id="ventanas" value="" <?php if($checklist['ventanas']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Ventanas
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="guantera" id="guantera" value="" <?php if($checklist['guantera']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Guantera
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="cinturon_seguridad" id="cinturon_seguridad" value="" <?php if($checklist['cinturon_seguridad']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Cinturón de seguridad
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="cajonera" id="cajonera" value="" <?php if($checklist['cajonera']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Cajonera
                                        </label>
                                    </div>
                            </div>

                            <div class="col-md-3 mt-1">
                                <h5>NIVELES</h5>

                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="tapa_combustrible" id="tapa_combustrible" value="1"  <?php if($checklist['tapa_combustible']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios1">
                                            Tapa de combustible
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="agua" id="agua" value="option2" <?php if($checklist['agua']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios2">
                                            Agua
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="aceite" id="aceite" value="" <?php if($checklist['aceite']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Aceite
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="liquido_freno" id="liquido_freno" value="" <?php if($checklist['liquido_freno']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Liquido de freno
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="hidrolima" id="hidrolima" value="" <?php if($checklist['hidrolima']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Hidrolima
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="luces_delanteras" id="luces_delanteras" value="" <?php if($checklist['luces_delanteras']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Luces delanteras
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="luces_posteriores" id="luces_posteriores" value="" <?php if($checklist['luces_posteriores']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Luces posteriores
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="direccion_derecho" id="direccion_derecho" value="" <?php if($checklist['direccion_derecho']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Dirección derecho
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="direccion_izquierda" id="direccion_izquierda" value="" <?php if($checklist['direccion_izquierda']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Dirección izquierdo
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="luces_freno" id="luces_freno" value="" <?php if($checklist['luces_freno']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Luces de freno
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="luces_cabina_dela" id="luces_cabina_dela" value="" <?php if($checklist['luces_cabina_delantera']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Luces de cabina delantera
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="luces_cabina_tras" id="luces_cabina_tras" value="" <?php if($checklist['luces_cabecera_posterior']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Luces de cabina posterior
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="circulina" id="circulina" value="" <?php if($checklist['circulina']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Circulina
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="modulo_parlantes" id="modulo_parlantes" value="" <?php if($checklist['modulo_parlantes']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Módulo y parlantes de sirena
                                        </label>
                                    </div>
                            </div>

                            <div class="col-md-3 mt-1">
                                <h5>EXTERIOR</h5>
                                <div class="form-check">
                                    <input class="form-check-input" disabled type="checkbox" name="tapa_combustible" id="tapa_combustible" value="" <?php if($checklist['tapa_com_exterior']== 1) echo "checked";?> >
                                    <label class="form-check-label" for="exampleRadios1">
                                        Tapa de combustible
                                    </label>
                                    </div>
                                    <div class="form-check">
                                    <input class="form-check-input" disabled type="checkbox" name="espejo_laterales" id="espejo_laterales" value="" <?php if($checklist['espejos_laterales']== 1) echo "checked";?>>
                                    <label class="form-check-label" for="exampleRadios2">
                                        Espejos laterales
                                    </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="mascara" id="mascara" value="" <?php if($checklist['mascara']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Máscara
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="plumillas" id="plumillas" value="" <?php if($checklist['plumillas']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Plumillas
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="parachoque_dela" id="parachoque_dela" value="" <?php if($checklist['parachoque_delantero']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Parachoque delantero
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="parachoque_tra" id="parachoque_tra" value="" <?php if($checklist['parachoque_trasero']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Parachoque trasero
                                            
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="carroceria" id="carroceria" value="" <?php if($checklist['carroceria']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Carroceria
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="neumaticos" id="neumaticos" value="" <?php if($checklist['neumaticos']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Neumáticos
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="tubo_escape" id="tubo_escape" value="" <?php if($checklist['tubo_escape']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Tubo de escape
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="cierra_puerta" id="cierra_puerta" value="" <?php if($checklist['cierre_puertas']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Cierre de puertas (4 chapaas)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="documentos" id="documentos" value="" <?php if($checklist['documentos']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Documentos
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="tarjeta_propiedad" id="tarjeta_propiedad" value="" <?php if($checklist['tarjeta_propiedad']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Tarjeta de propiedad
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="soat" id="soat" value="" <?php if($checklist['soat']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            SOAT
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="revision_tecnica" id="revision_tecnica" value="" <?php if($checklist['revision_tecnica']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Revisión técnica
                                        </label>
                                    </div>
                                    
                            </div>
                    
                            
                            <div class="col-md-3 mt-1">
                                <h5>PARTES DEL MOTOR</h5>

                                <div class="form-check">
                                    <input class="form-check-input" disabled type="checkbox" name="radiador_tapa" id="radiador_tapa" value="" <?php if($checklist['radiador_tapa']== 1) echo "checked";?> >
                                    <label class="form-check-label" for="exampleRadios1">
                                    Radiador y tapa
                                    </label>
                                    </div>
                                    <div class="form-check">
                                    <input class="form-check-input" disabled type="checkbox" name="deposito_refrigerante" id="deposito_refrigerante" value="" <?php if($checklist['deposito_refri']== 1) echo "checked";?>>
                                    <label class="form-check-label" for="exampleRadios2">
                                        Deposito del refrigerante
                                    </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="baterias" id="baterias" value="" <?php if($checklist['baterias']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Baterias (2)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="arrancador" id="arrancador" value="" <?php if($checklist['arrancador']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Arrancador
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="tapa_liquida" id="tapa_liquida" value="" <?php if($checklist['tapa_liquido']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Tapa del liquido de freno
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="paletas_ventilador" id="paletas_ventilador" value="" <?php if($checklist['paletas_ventilador']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Paletas del ventilador
                                            
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="varilla_medicion" id="varilla_medicion" value="" <?php if($checklist['varilla_medicion']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Varilla de medición de aceite
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="tapa_aceite" id="tapa_aceite" value="" <?php if($checklist['tapa_ace_motor']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Tapa de aceite del motor
                                        </label>
                                    </div>
                                    
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="llave_ruedas" id="llave_ruedas" value="" <?php if($checklist['llave_ruedas']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Llave de ruedas
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="gato_dado_pa" id="gato_dado_pa" value="" <?php if($checklist['gato_dado_pala']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Gato,dado y palanca
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="cono" id="cono" value="" <?php if($checklist['cono_seguridad']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Cono de seguridad
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="triangulo" id="triangulo" value="" <?php if($checklist['triangulo_segu']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Triangulo de seguridad
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="herramienta" id="herramienta" value="" <?php if($checklist['herramienta']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Herramienta
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="neumatico" id="neumatico" value="" <?php if($checklist['neumatico']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Neumático de respuesta
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="tablero" id="tablero" value="" <?php if($checklist['tablero']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Tablero de escritura
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="guia" id="guia" value="" <?php if($checklist['guia_calles']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Guia de calles
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="linterna" id="linterna" value="" <?php if($checklist['linterna']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Linterna
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" disabled type="checkbox" name="cables" id="cables" value="" <?php if($checklist['cable_corriente']== 1) echo "checked";?> >
                                        <label class="form-check-label" for="exampleRadios3">
                                            Cables de corriente
                                        </label>
                                    </div>
                                    
                            </div>

                            <div class="col-md-12 mt-2">
                                <label class="form-label" for="observacion_entrada">Observación saliente:</label>
                                <textarea name="observacion_entrada" disabled  id="observacion_entrada" rows="3" class="form-control"  cols="30" placeholder="Escribe alguna observación"><?php echo $checklist['obser_saliente'] ?></textarea>
                            </div>

                            <div class="col-md-12 mt-2">
                                    <label class="form-label" for="observacion_salida">Observación entrante:</label>
                                    <textarea name="observacion_salida" disabled id="observacion_salida" rows="3" class="form-control"  cols="30" placeholder="Escribe alguna observación"><?php echo $checklist['obser_entrante'] ?></textarea>
                            </div>

                            <div class="col-md-12 mt-4">
                                {{-- <form  action="{{route('hojaderuta.uploadImagen')}}"  method="POST" enctype="multipart/form-data">
                                    @csrf --}}
                                    <div class="col-md-12">
                                        <label for="exampleFormControlFile1">Subir imagen</label>
                                        <!-- <input type="file" class="form-control" id="imagen"> -->
                                        <input type="file" accept="image/*" disabled class="form-control" id="photo" name="file" onchange="previewImage(event, '#imgPreview')">
                                    </div>
                                    <div class="col-md-10 mt-1" id="img_up">
                                        <img id="imgPreview" src="{{ asset($checklist['ruta_incidencia'] ) }}" style="max-width:250px;border-radius:15px">
                                        
                                    </div>
                                {{-- </form> --}}
                                <div class="col-md-12 mt-2">
                                        <label class="form-label" for="observacion_incidencia">Incidencias:</label>
                                        <textarea name="observacion_incidencia" disabled id="observacion_incidencia" rows="3" class="form-control"  cols="30" placeholder="Escribe alguna incidencia"><?php echo $checklist['incidencia'] ?></textarea>
                                </div>
                            </div>

                            
                           
                    </div>
                </div>
            <input type="hidden" value='{{json_encode($distritos)}}' id="distritos_list">
        </div>

        <input type="hidden" value='{{json_encode($distritos)}}' id="distritos_list">
    
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
	var countFilaAdd=1;

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
    // $( document ).ready(function() {
     
    // });
    $(window).on('load', function() {

        
         var hojaDetalle = $("#detalles_data").data('id');
         var distritos_list =JSON.parse($("#distritos_list").val());
         var provincias_list =JSON.parse($("#provincias_list").val());
         var departamentos_list =JSON.parse($("#departamentos_list").val());

        
        if(hojaDetalle != ""){
            $.each(hojaDetalle, function (index,element) {
                htmlDepartamentos = '<option value="">Seleccionar  </option>' ;
                htmlProvincias = '<option value="">Seleccionar  </option>' ;
                htmlDistritos = '<option value="">Seleccionar  </option>' ;

                $.each(element.selectDepartamento, function(index2,element2){
                    htmlDepartamentos += `<option value="${element2.id}"  ${element2.id == element.departamento ? "selected" : ""}>${element2.nombre_ubigeo}</option> `;
                });
                $.each(element.selectProvincia, function(index3,element3){
                    htmlProvincias += `<option value="${element3.id}" ${element3.id == element.provincia ? "selected" : ""}>${element3.nombre_ubigeo}</option> `;
                });
                $.each(element.selectDistrito, function(index4,element4){
                    htmlDistritos += `<option value="${element4.id}" ${element4.id == element.distrito ? "selected" : ""}>${element4.nombre_ubigeo}</option> `;
                });
                

                var array = JSON.stringify(element);
                    htmlDetalleHoja=`<tr class="fila-body-hojas-add">
                            <td>
                                    <input type="text" id="hoja_direccion_insert-${countFilaAdd}" disabled class="form-control  hoja_direccion_insert" value="${element.direccion}" required>
                            </td>
                            <td>
                                    <select class="form-select hoja_deparamento" disabled    id="hoja_departamento-${countFilaAdd}" name="select_pro" >
                                                ${htmlDepartamentos}
                                               
                                    </select>
                            </td>
                            <td>
                                    <select class="form-select hoja_provincia" id="hoja_provincia-${countFilaAdd}" disabled    name="select_pro">
                                                ${htmlProvincias}
                                    </select>
                            </td>
                            <td>
                                    <select class="form-select hoja_distrito" id="hoja_distrito-${countFilaAdd}"   disabled  name="select_pro">
                                                ${htmlDistritos}
                                    </select>
                            </td>
                            <td>   
                                    <input type="time" id="hoja_llegada_insert-${countFilaAdd}" class="form-control hoja_llegada_insert" disabled value="${element.hora_llegada}" required>
                            </td>
                            <td>
                                    <input type="number" id="hoja_kilometraje_insert-${countFilaAdd}" disabled   class="form-control hoja_kilometraje_insert" value="${element.kilometraje}" required>
                            </td>
                            <td>
                                    <input type="time" id="hoja_salida_insert-${countFilaAdd}" class="form-control hoja_salida_insert" disabled   value="${element.hora_salida}"  required>
                            </td>
                            <td>
                                <div class="col-12 col-md-2 mx-auto my-auto">
                                  
                                </div>
                            </td>
                            </tr>`;
                // });
                $("#table_hojaruta").append(htmlDetalleHoja);
                countFilaAdd++;
    
            });
        }
	});

    

    // $("#new_detalle").click(function(){
	// 	htmlDetalleHoja=`<tr class="fila-body-hojas-add">
    //                         <td>
    //                                 <input type="text" id="hoja_direccion_insert-${countFilaAdd}" class="form-control  hoja_direccion_insert"  required>
    //                         </td>
    //                         <td>
                                    
    //                                 <select class="form-select hoja_deparamento" id="hoja_departamento-${countFilaAdd}" name="select_pro" >
    //                                             <option>Selecciona</option>

    //                                             @foreach ($departamentos as $departamento)
    //                                                     <option value="{{$departamento['id']}}" >{{$departamento['nombre_ubigeo']}}</option>
    //                                             @endforeach  
                                               
    //                                 </select>
    //                         </td>
    //                         <td>
    //                                 <select class="form-select hoja_provincia" id="hoja_provincia-${countFilaAdd}" disabled name="select_pro">
    //                                         <option value="">Seleccionar</option>
    //                                 </select>
    //                         </td>
    //                         <td>
    //                                 <select class="form-select hoja_distrito" id="hoja_distrito-${countFilaAdd}" disabled name="select_pro">
    //                                         <option value="">Seleccionar</option>
    //                                 </select>
    //                         </td>
    //                         <td>
    //                                 <input type="time" id="hoja_llegada_insert-${countFilaAdd}" class="form-control hoja_llegada_insert"  required>
    //                         </td>
    //                         <td>
    //                                 <input type="number" id="hoja_kilometraje_insert-${countFilaAdd}" class="form-control  hoja_kilometraje_insert" required>
    //                         </td>
    //                         <td>
    //                                 <input type="time" id="hoja_salida_insert-${countFilaAdd}" class="form-control hoja_salida_insert"   required>
    //                         </td>
    //                         <td>
    //                             <div class="col-12 col-md-2 mx-auto my-auto">
    //                                 <i data-feather="trash-2" color="red" style="cursor: pointer;" class="remove_hoja_ruta"></i>
    //                             </div>
    //                         </td>

	// 					</tr>`;
	// 	if($(".fila-body-hojas-add").length==0){
	// 		$("#table_hojaruta").append(htmlDetalleHoja);
	// 		countFilaAdd++;
	// 	}else{
	// 		sw_error=0;
	// 		$(".fila-body-hojas-add").each(function(){
	// 			fila=$(this);
	// 			direccion=fila.find('.hoja_direccion_insert').val();
	// 			departamento=fila.find('.hoja_deparamento').val();
	// 			provincia=fila.find('.hoja_provincia').val();
	// 			distrito=fila.find('.hoja_distrito').val();
	// 			hora_llegada=fila.find('.hoja_llegada_insert').val();
	// 			kilometraje=fila.find('.hoja_kilometraje_insert').val();
	// 			hora_salida=fila.find('.hoja_salida_insert').val();
	// 		});
	// 		if(sw_error==1){
	// 			Swal.fire({
	// 				position: "bottom-end",
	// 				icon: "warning",
	// 				title: "Atención",
	// 				text: "Antes de agregar una fila adicional, rellene todos los campos.",
	// 				showConfirmButton: false,
	// 				timer: 3000
	// 			});
	// 		}else{
	// 			$("#table_hojaruta").append(htmlDetalleHoja);
    
	// 			// validateNumber();
	// 			countFilaAdd++;
	// 		}
	// 	}
	// 	feather.replace();
		
	// });

    // $("#btnAñadirHoja").click(function(){
    //     // $("#btn-save").prop('disabled',true);
	// 	isValid = $("#hojaderutaformNew").valid();
    //     hojadetalle = getHojasInsert();
    //     var nuevadata = JSON.stringify(hojadetalle);
	// 	if(isValid){
    //         var formSerialize = $('#hojaderutaformNew').serialize();
    //         v_token = "{{ csrf_token() }}";
	// 		method = 'POST';
	// 		formData = new FormData(document.getElementById("hojaderutaformNew"));
	// 		formData.append("_method", "POST");
	// 		formData.append("_token", v_token);
	// 		formData.append("hojadetalle", nuevadata);
	// 		$.ajax({
	// 			url: "{{route('hojaderuta.create')}}",
	// 			type: "POST",
	// 			data: formData,
    //             cache:false,
	// 			contentType: false,
	// 			processData: false,
	// 			dataType: 'json',
	// 			success: function(obj){
	// 				if(obj.sw_error==1){
	// 					Swal.fire({
	// 						position: "bottom-end",
	// 						icon: "warning",
	// 						title: "Atención",
	// 						text: obj.message,
	// 						showConfirmButton: false,
	// 						timer: 2500
	// 					});
	// 				}else{
	// 					Swal.fire({
	// 						position: "bottom-end",
	// 						icon: "success",
	// 						title: "Éxito",
	// 						text: obj.message,
	// 						showConfirmButton: false,
	// 						timer: 2500
	// 					});
    //                     location.reload();
	// 				}
	// 				// $("#btn-save").prop('disabled',false);
	// 			}
	// 		});
	// 	}else{
			
	// 	}
	// });

    // $("#btUpdateHoja").click(function(){
        
    //     var id_hojaruta = $("#id_hojaruta").val();
	// 	isValid = $("#hojaderutaformUpdate").valid();
	// 	// productos = getProductsInsert();
    //     hojadetalle = getHojasInsert();
    //     var nuevadata = JSON.stringify(hojadetalle);
	// 	if(isValid){
	// 	// if(isValid && productos.length>0){
    //         var formSerialize = $('#hojaderutaformUpdate').serialize();
    //         v_token = "{{ csrf_token() }}";
	// 		method = 'POST';
	// 		formData = new FormData(document.getElementById("hojaderutaformUpdate"));
	// 		formData.append("_method", "POST");
	// 		formData.append("_token", v_token);
	// 		formData.append("hojadetalle", nuevadata);
	// 		$.ajax({
	// 			url: "{{route('hojaderuta.update')}}/" +id_hojaruta,
	// 			type: "POST",
	// 			data: formData,
    //             cache:false,
	// 			contentType: false,
	// 			processData: false,
	// 			dataType: 'json',
	// 			success: function(obj){
	// 				if(obj.sw_error==1){
	// 					Swal.fire({
	// 						position: "bottom-end",
	// 						icon: "warning",
	// 						title: "Atención",
	// 						text: obj.message,
	// 						showConfirmButton: false,
	// 						timer: 2500
	// 					});
	// 				}else{
	// 					Swal.fire({
	// 						position: "bottom-end",
	// 						icon: "success",
	// 						title: "Éxito",
	// 						text: obj.message,
	// 						showConfirmButton: false,
	// 						timer: 2500
	// 					});
    //                     setTimeout(() => {
	// 						window.location.href = "{{route('hojasderuta.index')}}";
	// 					}, 2500);
	// 				}
	// 			}
	// 		});
	// 	}else{
			
	// 	}
	// });

	// $("#table_hojaruta").on("click", ".remove_hoja_ruta", function() {
	// 	$(this).closest("tr").remove();
	// });

    // $("#guardarCheck").click(function() {
	// 	var arreglo = [];
	// 	$('input:checkbox').each(function() {
	// 		arreglo.push({'name':$(this).prop('name'),'value': $(this).is(':checked') ? "1" : "0"});
	// 	});

    //     // var nuevoArreglo = [];
    //      var   nuevoArreglo = JSON.stringify(arreglo);
    //     var idruta = $("#id_hojarutacheck").val();
	// 	var obser_entrada = $("#observacion_entrada").val();
	// 	var obser_salida = $("#observacion_salida").val();
	// 	var obser_incidencia = $("#observacion_incidencia").val();     
    //     var property = document.getElementById('photo').files[0];
    //     var image_name = property.name;
    //     var formData = new FormData();
	// 	_token = "{{ csrf_token() }}";
	// 	method = 'POST';
    //     formData.append("_method", "POST");
    //     formData.append("_token", _token);
    //     formData.append("idruta", idruta);
    //     formData.append("obser_entrada", obser_entrada);
    //     formData.append("obser_salida", obser_salida);
    //     formData.append("obser_incidencia", obser_incidencia);
    //     formData.append("nuevoArreglo", nuevoArreglo);
    //     formData.append("file", property);
    //     formData.append("imagen_name", image_name);

	// 	$.ajax({
	// 		url: "{{route('hojaderuta.guardar')}}",
	// 		type: "POST",
	// 		data: formData,
    //         contentType: false,
    //         cache: false,
    //         processData: false,
	// 		success: function(obj){
	// 			if(obj.sw_error==1){
	// 				Swal.fire({
	// 					position: "bottom-end",
	// 					icon: "warning",
	// 					title: "Atención",
	// 					text: obj.message,
	// 					showConfirmButton: false,
	// 					timer: 2500
	// 				});
	// 			}else{
	// 				Swal.fire({
	// 					position: "bottom-end",
	// 					icon: "success",
	// 					title: "Éxito",
	// 					text: obj.message,
	// 					showConfirmButton: false,
	// 					timer: 2500
	// 				});
	// 				location.reload();
	// 			}
				
	// 		}
	// 		});
	// });

    // $("#updateCheck").click(function() {
        
    //     var checkId = $("#CheckIdRuta").val();
	// 	var arreglo = [];
	// 	$('input:checkbox').each(function() {
	// 		arreglo.push({'name':$(this).prop('name'),'value': $(this).is(':checked') ? "1" : "0"});
	// 	});

    //     // var nuevoArreglo = [];
    //      var   nuevoArreglo = JSON.stringify(arreglo);
    //     var idruta = $("#id_hojarutacheck").val();
	// 	var obser_entrada = $("#observacion_entrada").val();
	// 	var obser_salida = $("#observacion_salida").val();
	// 	var obser_incidencia = $("#observacion_incidencia").val();     
    //     var property = document.getElementById('photo').files[0];
    //     var image_name = property.name;
    //     var formData = new FormData();
	// 	_token = "{{ csrf_token() }}";
	// 	method = 'POST';
    //     formData.append("_method", "POST");
    //     formData.append("_token", _token);
    //     formData.append("idruta", idruta);
    //     formData.append("obser_entrada", obser_entrada);
    //     formData.append("obser_salida", obser_salida);
    //     formData.append("obser_incidencia", obser_incidencia);
    //     formData.append("nuevoArreglo", nuevoArreglo);
    //     formData.append("file", property);
    //     formData.append("imagen_name", image_name);

	// 	$.ajax({
	// 		url: "{{route('hojaderuta.updateCheck')}}/" + checkId ,
	// 		type: "POST",
	// 		data: formData,
    //         contentType: false,
    //         cache: false,
    //         processData: false,
	// 		success: function(obj){
	// 			if(obj.sw_error==1){
	// 				Swal.fire({
	// 					position: "bottom-end",
	// 					icon: "warning",
	// 					title: "Atención",
	// 					text: obj.message,
	// 					showConfirmButton: false,
	// 					timer: 2500
	// 				});
	// 			}else{
	// 				Swal.fire({
	// 					position: "bottom-end",
	// 					icon: "success",
	// 					title: "Éxito",
	// 					text: obj.message,
	// 					showConfirmButton: false,
	// 					timer: 2500
	// 				});
	// 				location.reload();
	// 			}
				
	// 		}
	// 		});
	// });

    // function getHojasInsert(){
	// 	arrHojasJsons=[];
	// 	$(".fila-body-hojas-add").each(function(){
	// 		fila=$(this);
	// 		direccion=fila.find('.hoja_direccion_insert').val();
	// 		departamento=fila.find('.hoja_deparamento').val();
	// 		provincia=fila.find('.hoja_provincia').val();
	// 		distrito=fila.find('.hoja_distrito').val();
	// 		llegada=fila.find('.hoja_llegada_insert').val();
	// 		kilometraje=fila.find('.hoja_kilometraje_insert').val();
	// 		salida=fila.find('.hoja_salida_insert').val();

	// 		arrHojasJsons.push({"direccion": direccion,"departamento": departamento,"provincia":provincia,"distrito":distrito,"llegada": llegada,"kilometraje": kilometraje,"salida": salida});
	// 	});

	// 	return arrHojasJsons;
	// }

    // function previewImage(event, querySelector){
    //     //Recuperamos el input que desencadeno la acción
    //     const input = event.target;
    //     //Recuperamos la etiqueta img donde cargaremos la imagen
    //     $imgPreview = document.querySelector(querySelector);
    //     // Verificamos si existe una imagen seleccionada
    //     if(!input.files.length) return
    //     //Recuperamos el archivo subido
    //     file = input.files[0];
    //     //Creamos la url
    //     objectURL = URL.createObjectURL(file);
    //     //Modificamos el atributo src de la etiqueta img
    //     $imgPreview.src = objectURL;
                    
    // }

    // $('#table_hojaruta').on('change',".hoja_deparamento", function(){
    
    //     var select = $(this);
    //     deparment_id = $(this).val();
	// 		if(deparment_id!=''){
	// 			v_token = "{{ csrf_token() }}";
	// 			method = 'GET';
	// 			$.ajax({
	// 				url: "{{ route('ubigeo.padre') }}/"+deparment_id,
	// 				type: "POST",
	// 				data: {_token:v_token,_method:method},
	// 				dataType: 'json',
	// 				success: function(obj){
	// 					provincias = obj.provincias;
	// 					if(provincias.length>0){
	// 						htmlOptions = '<option value="">Seleccionar</option>';
	// 						provincias.forEach(element => {
	// 							htmlOptions+=`<option value="${element.id}">${element.nombre_ubigeo}</option>`;
	// 						});
    //                         // var row = $(this).closest("tr");        // Finds the closest row <tr> 
    //                         //  row.find(".hoja_provincia").html(htmlOptions);

    //                         //  $(this).parents("tr").find("td").eq(2).html(htmlOptions);
    //                         //  $(this).find('td:first').html();
    //                         select.parent().parent().find('.hoja_provincia').html(htmlOptions);
    //                         //  $(this).find('td:first').html("hola");
    //                         // $(this).parents("tr").find("td").eq(2).html(htmlOptions);
	// 						// $(".hoja_provincia").html(htmlOptions);
	// 					    select.parent().parent().find(".hoja_provincia").prop('disabled',false);
							
	// 					}
	// 				}
	// 			});
	// 		}else{
    //             $(".hoja_provincia").prop('disabled',true);

	// 		}
    // });


    // $('#table_hojaruta').on('change', "tr .hoja_provincia", function(){
	// 	deparment_id = $(this).val();
    //     var select = $(this);
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
	// 					// $(".hoja_distrito").html(htmlOptions);
    //                     select.parent().parent().find('.hoja_distrito').html(htmlOptions);
	// 					select.parent().parent().find(".hoja_distrito").prop('disabled',false);

	// 				}
	// 			}
	// 		});
	// 	}else{
    //         $(".hoja_distrito").prop('disabled',true);
					
	// 	}
	// });
   
</script>
@endsection