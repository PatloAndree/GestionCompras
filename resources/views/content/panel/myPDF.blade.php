
<style>
.observacion {
  font-size: 12px;
}

td , th{
  font-size: 11px;
  color: rgb(60, 58, 58);
  
}

table{
  border:none;

}
.underover {
    /* text-decoration: underline red; */
    text-decoration: overline;
}
.footer{
    padding-top:30%
}
.tabla_footer{
    border: none !important;
    margin-top: 20%;
    font-family: 'Montserrat', sans-serif;
}

.trnone{
    border: none !important;
}
.page_break {
  page-break-before: always;
}
.tabla_check{
    text-align: left
}
.form-check-label{
    /* margin-top: 2px */
}

</style>

<!DOCTYPE html>
<html>
<head>
    <title>Hoja de ruta </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100&display=swap" rel="stylesheet">
</head>    
<body>
                <div class="text-center">
                    <div class="col-sm-12">
                        <img src="{{ public_path('images\login\pm.png') }}"  style="width:130px;top:10px" >
                        <h5 class="mb-1">HOJA DE RUTA</h5>
                    </div>
                </div>

              
                <table style='width:100%;margin-bottom:5%' >
                    <col width="10%"><col width="20%"><col width="40%"><col width="30%">
                    <tr>
                        <th  >FECHA DE REPORTE</th>
                        <td style="text-align:left">: <?php echo $data['fecha_reporte'] ?></td>
                        <td ></td>
                        <td rowspan="3"> <img src="{{ public_path('images\login\indi.jpg')}}" style="max-width:120px;align:center" class="img-fluid "></td>
                    </tr>
                    <tr>
                        <th  colspan='1'>MÉDICO</th>
                        <td colspan='1'>:  -------- </td>
                        <td colspan="1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;</td>
                        <td colspan="1"> </td>

                    </tr>
                    <tr>
                        <th  colspan='1'>PARAMEDICO</th>
                        <td colspan='1'>: <?php echo $paramedico ?></td>
                        <td colspan="1"> </td>
                        <td colspan="1"> </td>

                    </tr>
                    <tr>
                        <th  colspan='1'>PILOTO</th>
                        <td colspan='1'>: <?php echo $piloto ?></td>
                        <td colspan="1"> </td>
                        <td rowspan="3"> <img src="{{ public_path('images\login\sas.jpg')}}" style="max-width:120px;align:center" class="img-fluid "></td>
                    </tr>
                    <tr>
                        <th  colspan='1'>UNIDAD</th>
                        <td colspan='1'>: <?php echo $sede_ambulancia ?></td>
                        <td colspan="1"> </td>
                        <td colspan="1"> </td>

                    </tr>
                    <tr>
                        <th  colspan='1'>TURNO</th>
                        <td colspan='1'>: <?php echo $turno_horas ?></td>
                        <td colspan="1"> </td>
                        <td colspan="1"> </td>

                    </tr>
                    <tr>
                        <th  colspan='1'>SUB BASE</th>
                        <td colspan='1'>: <?php echo $sub_base ?></td>
                        <td colspan="1"> </td>
                        <td colspan="1"> <input type="text" value="2" value="<?php echo $data['gaso1'] ?>" style="text-align:center"> </td>

                    </tr>
                    <tr>
                        <th  colspan='1'>KM INICIAL</th>
                        <td colspan='1'>: <?php echo $data['km_inicial'] ?></td>
                        <td colspan="1"> </td>
                        <td colspan="1"> </td>

                    </tr>
                    <tr>
                        <th  colspan='1'>KM FINAL</th>
                        <td colspan='1'>: <?php echo $km_final ?></td>
                        <td colspan="1"> </td>
                        <td colspan="1"> </td>
                    </tr>
                    <tr>
                        <th  colspan='1'>N° VALES DE COMBUSTIBLE</th>
                        <td colspan='1'>: <?php echo $data['numero_vales'] ?> </td>
                        <td colspan="1"> </td>
                        <td colspan="1"> </td>
                    </tr>
                    <tr>
                        <th  colspan='1'>VALORIZADO EN S/</th>
                        <td colspan='1'>: <?php echo $data['valorizado'] ?> </td>
                        <td colspan="1"> </td>
                        <td colspan="1"> </td>
                    </tr>
                    <tr>
                        <th  colspan='1'>GALONES</th>
                        <td colspan='1'>: <?php echo $data['galones'] ?></td>
                        <td colspan="1"> </td>
                        <td colspan="1"> </td>
                    </tr>
                    <tr>
                        <th  colspan='1'>SOAT</th>
                        <td colspan='1'>: </td>
                        <td colspan="1"> </td>
                        <td colspan="1"> </td>
                    </tr>
                    <tr>
                        <th  colspan='1'>REVISIÓN TÉCNICA</th>
                        <td colspan='1'>: </td>
                        <td colspan="1"> </td>
                        <td colspan="1"> </td>
                    </tr>
                    <tr>
                        <th  colspan='1'>ULTIMO CAMBIO DE ACEITE</th>
                        <td colspan='1'>: </td>
                        <td colspan="1"> </td>
                        <td colspan="1"> </td>
                    </tr>
                    <tr>
                        <th  colspan='1'>PRÓXIMO CAMBIO DE ACEITE</th>
                        <td colspan='1'>: </td>
                        <td colspan="1"> </td>
                        <td colspan="1"> </td>
                    </tr>
                </table>

                <input type="hidden" value='{{json_encode($distritos)}}' id="distritos_list">
                <input type="hidden" value='{{json_encode($departamentos)}}' id="departamentos_list">
                <input type="hidden" value='{{json_encode($provincias)}}' id="provincias_list">

                <div class="row">
                    <table class="table table-bordered" style="text-align:center;" id="table_hojaruta" >
                        <thead>
                            <tr>
                                <th>Direccion</th>
                                <th>Distrito</th>
                                <th>Hora llegada</th>
                                <th>Kilometraje</th>
                                <th>Hora salida</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hojasdetalles as $product)
                            <tr>
                               <td>{{$product['direccion']}}</td>
                               <td>{{$product['distrito']}}</td>
                               <td>{{$product['hora_llegada']}}</td>
                               <td>{{$product['kilometraje']}}</td>
                               <td>{{$product['hora_salida']}}</td>


                            </tr>
                                
                            @endforeach
                        </tbody> 


                    </table>
                    
                </div>

                <div class="row">
                    <label for="" class="observacion">OBSERVACIONES : </label>
                    <div class="col-md-12">
                        <span class="observacion"> <?php echo $data['observacion']?> </span>
                    </div>
                </div>   

                    
                <table class="table tabla_footer"  >
                    <tr class="trnone">
                        <th class="trnone"><p class="underover">Firma del piloto saliente.</p></th>
                        <th class="trnone text-right"><p class="underover">Firma del piloto entrante.</p></th>
                    </tr>
                </table>

                <div class="page_break">
                    <div class="text-center">
                        <div class="col-sm-12">
                            <img src="{{ public_path('images\login\furgo.webp') }}"  style="width:200px;top:10px" >
                            <h5 class="">CHECK LIST DE MANTENIMIENTO DE UNIDADES MÉDICAS</h5>
                        </div>
                    </div>

                    <table class="" style="width: 100%;text-align:center">
                        <tr style="padding-bottom:10px">
                            <th >CABINA</th>
                            <th >NIVELES</th>
                            <th >EXTERIOR</th>
                            <th >PARTES DEL MOTOR</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                       <tr>
                        <td class="tabla_check"> 
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="pedal_embriague" id="pedal_embriague" value="" <?php if($checklist['pedal_embriague']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios1">
                                    Pedal de embriague
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tapa_combustrible" id="tapa_combustrible" value="1"  <?php if($checklist['tapa_combustible']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios1">
                                    Tapa de combustible
                                </label>
                            </div>
                           
                        </td>
                        <td class="tabla_check" >	
                            <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="tapa_combustible" id="tapa_combustible" value="" <?php if($checklist['tapa_com_exterior']== 1) echo "checked";?> >
                            <label class="form-check-label" for="exampleRadios1">
                                Tapa de combustible
                            </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
								<input class="form-check-input" type="checkbox" name="radiador_tapa" id="radiador_tapa" value="" <?php if($checklist['radiador_tapa']== 1) echo "checked";?> >
								<label class="form-check-label" for="exampleRadios1">
								Radiador y tapa
								</label>
                            </div>
                        </td>
                       </tr>

                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="pedal_freno" id="pedal_freno" value="" <?php if($checklist['pedal_freno']== 1) echo "checked";?>>
                                <label class="form-check-label" for="exampleRadios2">
                                    Pedal de freno
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="agua" id="agua" value="option2" <?php if($checklist['agua']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios2">
                                    Agua
                                </label>
                            </div>
                          
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="espejo_laterales" id="espejo_laterales" value="" <?php if($checklist['espejos_laterales']== 1) echo "checked";?>>
                                <label class="form-check-label" for="exampleRadios2">
                                    Espejos laterales
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
								<input class="form-check-input" type="checkbox" name="deposito_refrigerante" id="deposito_refrigerante" value="" <?php if($checklist['deposito_refri']== 1) echo "checked";?>>
								<label class="form-check-label" for="exampleRadios2">
									Deposito del refrigerante
								</label>
                            </div>
                        </td>
                       </tr>

                       <tr>
                        <td class="tabla_check">  
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="pedal_acelerar" id="pedal_acelerar" value="" <?php if($checklist['pedal_acelera']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Pedal de acelerador
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="aceite" id="aceite" value="" <?php if($checklist['aceite']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Aceite
                                </label>
                            </div>
                        
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="mascara" id="mascara" value="" <?php if($checklist['mascara']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Máscara
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="baterias" id="baterias" value="" <?php if($checklist['baterias']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Baterias (2)
                                </label>
                            </div>
                        </td>
                       </tr>
                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="asientos_cabeza" id="asientos_cabeza" value="" <?php if($checklist['asientos_cabezal']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Asientos y cabezal
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="liquido_freno" id="liquido_freno" value="" <?php if($checklist['liquido_freno']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Liquido de freno
                                </label>
                            </div>
                           
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="plumillas" id="plumillas" value="" <?php if($checklist['plumillas']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Plumillas
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="arrancador" id="arrancador" value="" <?php if($checklist['arrancador']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Arrancador
                                </label>
                            </div>
                        </td>
                       </tr>
                        
                       <tr>
                        <td class="tabla_check">
                            
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="espejo_retrovisor" id="espejo_retrovisor" value="" <?php if($checklist['espejo_retrovisor']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Espejo retrovisor
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="hidrolima" id="hidrolima" value="" <?php if($checklist['hidrolima']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Hidrolima
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="parachoque_dela" id="parachoque_dela" value="" <?php if($checklist['parachoque_delantero']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Parachoque delantero
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tapa_liquida" id="tapa_liquida" value="" <?php if($checklist['tapa_liquido']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Tapa del liquido de freno
                                </label>
                            </div>
                        </td>
                       </tr>
                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="freno_mano" id="freno_mano" value="" <?php if($checklist['freno_mano']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Freno de mano
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="luces_delanteras" id="luces_delanteras" value="" <?php if($checklist['luces_delanteras']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Luces delanteras
                                </label>
                            </div>
                           
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="parachoque_tra" id="parachoque_tra" value="" <?php if($checklist['parachoque_trasero']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Parachoque trasero
                                    
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="paletas_ventilador" id="paletas_ventilador" value="" <?php if($checklist['paletas_ventilador']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Paletas del ventilador
                                    
                                </label>
                            </div>
                        </td>
                       </tr>
                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="cenicero" id="cenicero" value="" <?php if($checklist['cenicero']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Cenicero
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="luces_posteriores" id="luces_posteriores" value="" <?php if($checklist['luces_posteriores']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Luces posteriores
                                </label>
                            </div>
                            
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="carroceria" id="carroceria" value="" <?php if($checklist['carroceria']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Carroceria
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="varilla_medicion" id="varilla_medicion" value="" <?php if($checklist['varilla_medicion']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Varilla de medición de aceite
                                </label>
                            </div>
                        </td>
                       </tr>
                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="menijas" id="menijas" value="" <?php if($checklist['manijas']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Manijas
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="direccion_derecho" id="direccion_derecho" value="" <?php if($checklist['direccion_derecho']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Dirección derecho
                                </label>
                            </div>
                          
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="neumaticos" id="neumaticos" value="" <?php if($checklist['neumaticos']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Neumáticos
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tapa_aceite" id="tapa_aceite" value="" <?php if($checklist['tapa_ace_motor']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Tapa de aceite del motor
                                </label>
                            </div>
                        </td>
                       </tr>

                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="palanca" id="palanca" value="" <?php if($checklist['palanca_cambios']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Palanca de cambios
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="direccion_izquierda" id="direccion_izquierda" value="" <?php if($checklist['direccion_izquierda']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Dirección izquierdo
                                </label>
                            </div>
                           
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tubo_escape" id="tubo_escape" value="" <?php if($checklist['tubo_escape']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Tubo de escape
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="llave_ruedas" id="llave_ruedas" value="" <?php if($checklist['llave_ruedas']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Llave de ruedas
                                </label>
                            </div>
                        </td>
                       </tr>

                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="parabrisas" id="parabrisas" value="" <?php if($checklist['parabrisas']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Parabrisas
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="luces_freno" id="luces_freno" value="" <?php if($checklist['luces_freno']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Luces de freno
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="cierra_puerta" id="cierra_puerta" value="" <?php if($checklist['cierre_puertas']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Cierre de puertas (4 chapaas)
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="gato_dado_pa" id="gato_dado_pa" value="" <?php if($checklist['gato_dado_pala']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Gato,dado y palanca
                                </label>
                            </div>
                        </td>
                       </tr>

                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="panilla_luces" id="panilla_luces" value="" <?php if($checklist['planilla_luces']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Panilla de luces
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="luces_cabina_dela" id="luces_cabina_dela" value="" <?php if($checklist['luces_cabina_delantera']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Luces de cabina delantera
                                </label>
                            </div>
                          
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="documentos" id="documentos" value="" <?php if($checklist['documentos']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Documentos
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="cono" id="cono" value="" <?php if($checklist['cono_seguridad']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Cono de seguridad
                                </label>
                            </div>
                        </td>
                       </tr>

                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="radio" id="radio" value="" <?php if($checklist['radio']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                Radio
                                </label>
                            </div>
                          
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="luces_cabina_tras" id="luces_cabina_tras" value="" <?php if($checklist['luces_cabecera_posterior']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Luces de cabina posterior
                                </label>
                            </div>
                         
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tarjeta_propiedad" id="tarjeta_propiedad" value="" <?php if($checklist['tarjeta_propiedad']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Tarjeta de propiedad
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="triangulo" id="triangulo" value="" <?php if($checklist['triangulo_segu']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Triangulo de seguridad
                                </label>
                            </div>
                        </td>
                       </tr>


                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tapasol" id="tapasol" value="" <?php if($checklist['tapasol']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                Tapasol
                                </label>
                            </div>
                           
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="circulina" id="circulina" value="" <?php if($checklist['circulina']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Circulina
                                </label>
                            </div>
                         
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="soat" id="soat" value="" <?php if($checklist['soat']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    SOAT
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="herramienta" id="herramienta" value="" <?php if($checklist['herramienta']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Herramienta
                                </label>
                            </div>
                        </td>
                       </tr>


                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tapis" id="tapis" value="" <?php if($checklist['tapis']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                Tapis
                                </label>
                            </div>
                           
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="modulo_parlantes" id="modulo_parlantes" value="" <?php if($checklist['modulo_parlantes']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Módulo y parlantes de sirena
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="neumatico" id="neumatico" value="" <?php if($checklist['neumatico']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Neumático de respuesta
                                </label>
                            </div>
                        </td>
                       </tr>


                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="extintor" id="extintor" value="" <?php if($checklist['extintor']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                Extintor
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="revision_tecnica" id="revision_tecnica" value="" <?php if($checklist['revision_tecnica']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Revisión técnica
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" >
                            
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tablero" id="tablero" value="" <?php if($checklist['tablero']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Tablero de escritura
                                </label>
                            </div>
                        </td>
                       </tr>


                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="estribos" id="estribos" value="" <?php if($checklist['estribos']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                Estribos
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="guia" id="guia" value="" <?php if($checklist['guia_calles']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Guia de calles
                                </label>
                            </div>
                        </td>
                       </tr>

                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="nivel_aceite" id="nivel_aceite" value="1" <?php if($checklist['mivel_aceite']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios1">
                                    Nivel de aceite
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="linterna" id="linterna" value="" <?php if($checklist['linterna']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Linterna
                                </label>
                            </div>
                        </td>
                       </tr>

                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="frenos" id="frenos" value="" <?php if($checklist['freno']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Freno
                                </label>
                            </div>
                           
                        </td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" >
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="cables" id="cables" value="" <?php if($checklist['cable_corriente']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Cables de corriente
                                </label>
                            </div>
                        </td>
                       </tr>

                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="nivel_bateria" id="nivel_bateria" value="" <?php if($checklist['nivel_bateria']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Nivel de bateria
                                </label>
                            </div>
                           
                        </td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                       </tr>

                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="kilometraje" id="kilometraje" value="" <?php if($checklist['kilometraje']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Kilometraje
                                </label>
                            </div>
                        </td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                       </tr>

                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="nivel_temperatura" id="nivel_temperatura" value="" <?php if($checklist['nivel_temperatura']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Nivel de temperatura
                                </label>
                            </div>
                           
                        </td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                       </tr>

                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="reloj" id="reloj" value="" <?php if($checklist['reloj']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Reloj
                                </label>
                            </div>
                           
                        </td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                       </tr>

                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="nivel_combustible" id="nivel_combustible" value="" <?php if($checklist['nivel_combustible']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Nivel de combustible
                                </label>
                            </div>
                          
                        </td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                       </tr>

                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="mica" id="mica" value="" <?php if($checklist['mica']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Mica
                                </label>
                            </div>
                           
                        </td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                       </tr>

                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="direccionales" id="direccionales" value="" <?php if($checklist['direccionales']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Direccionales
                                </label>
                            </div>
                           
                        </td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                       </tr>

                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="pisos" id="pisos" value="" <?php if($checklist['pisos']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Pisos
                                </label>
                            </div>
                          
                        </td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                       </tr>

                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="timon_claxon" id="timon_claxon" value="" <?php if($checklist['timon_claxon']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Timón y claxón
                                </label>
                            </div>
                          
                        </td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                       </tr>

                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="ventanas" id="ventanas" value="" <?php if($checklist['ventanas']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Ventanas
                                </label>
                            </div>
                          
                        </td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                       </tr>

                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="guantera" id="guantera" value="" <?php if($checklist['guantera']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Guantera
                                </label>
                            </div>
                          
                          
                        </td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                       </tr>

                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="cinturon_seguridad" id="cinturon_seguridad" value="" <?php if($checklist['cinturon_seguridad']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Cinturón de seguridad
                                </label>
                            </div>
                          
                        </td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                       </tr>

                       <tr>
                        <td class="tabla_check">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="cajonera" id="cajonera" value="" <?php if($checklist['cajonera']== 1) echo "checked";?> >
                                <label class="form-check-label" for="exampleRadios3">
                                    Cajonera
                                </label>
                            </div>
                          
                        </td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                        <td class="tabla_check" ></td>
                       </tr>

                    </table>
                    <br>
                    <div class="row">
                        <label for="" class="observacion">OBSERVACIÓN SALIENTE : </label>
                        <div class="col-md-12">
                            <span class="observacion"> * <?php echo $checklist['obser_saliente'] ?></span>
                        </div>
                    </div>   

                    <div class="row">
                        <label for="" class="observacion">OBSERVACIÓN ENTRANTE : </label>
                        <div class="col-md-12">
                            <span class="observacion"> * <?php echo $checklist['obser_entrante'] ?></span>
                        </div>
                    </div>   

                </div>

    </body>
</html>

