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
    .img-fluid{
        max-width:100%;
        height:auto
    }

    </style>
    
    <!DOCTYPE html>
    <html>
    <head>
        <title>Laravel 9 Generate PDF Example - ItSolutionStuff.com</title>
        <link rel="stylesheet" href="{{ public_path('css\bootstrap.4.4.1.min.css') }}">
    </head>    
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-2 text-center">
                    <img src="{{ public_path('images\login\pm.png') }}" class="img-fluid">
                </div>
                <div class="col-xs-5 text-center">
                    <h3>Acta de entrega de medicamentos y otros</h2>
                    <h4 style="color: red">N° R-0187</h4>
                </div>
                <div class="col-xs-4">
                     <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th><strong>Mes</strong></th>
                                <th>{{Helper::getMonthSpanish(date("n",strtotime($solicitud->created_at)))}}</th>
                            </tr>
                            <tr>
                                <th><strong>Aprobado</strong></th>
                                <th>Elver Mateo</th>
                            </tr>
                            <tr>
                                <th><strong>Elaborado</strong></th>
                                <th>{{$solicitud->usuario->name.' '.$solicitud->usuario->last_name}}</th>
                            </tr>
                            <tr>
                                <th><strong>Fecha</strong></th>
                                <th>{{date("d/m/Y",strtotime($solicitud->fecha_atencion))}}</th>
                            </tr>
                        </tbody>
                     </table>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Razón social</th>
                                <th scope="col">RUC</th>
                                <th scope="col">Domicilio fiscal</th>
                                <th scope="col">Activida económica</th>
                                <th scope="col">Tópico</th>
                            </tr>
                          </thead>
                          <tbody>
                                <tr>
                                      <th>CORPORACION PERU MEDICAL ASSISTANCE S.A.C</th>
                                      <td>20563249847</td>
                                      <td>AV. UNIVERSITARIA MZA. 0 LOTE. 47 URB. EL PACIFICO SMP</td>
                                      <td>SERVICIOS PRE - HOSPITALITARIOS DE URGENECIAS</td>
                                      <td>{{$solicitud->sede->name}}</td>
                                </tr>
                          </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col">Descripción</th>
                                <th scope="col">Cantidad</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $count=1;?>
                            @foreach ($solicitud->productos as $product)
                                <tr>
                                    <th>{{$count}}</th>
                                    <td>{{$product->dataproducto->nombre}}</td>
                                    <td>{{$product->cantidad_entregada}}</td>
                                </tr>
                                <?php $count++;?>
                            @endforeach
                          </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Observación solicitante</th>
                                <th scope="col">Observación administrador</th>
                            </tr>
                          </thead>
                          <tbody>
                                  <tr>
                                      <td>{{$solicitud->note}}</th>
                                      <td>{{$solicitud->note_final}}</td>
                                  </tr>
                          </tbody>
                    </table>
                </div>
            </div>

            <div class="row" style="position: fixed;bottom: 0;width: 100%;">
                <div class="col-xs-5" >
                    <div style="border:1px solid #dee2e6">
                        <div>
                            <p><strong>Recibí Conforme</strong></p>
                        </div>
                        <div class="text-right" style="margin-top: 1em">
                            <p>__________________________________</p>
                            <p>Lic. (a) _________________________</p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-1"></div>
                <div class="col-xs-5">
                    <div style="border:1px solid #dee2e6">
                        <div class="d-none" style="color: white">
                            <p><strong>Recibí Conforme</strong></p>
                        </div>
                        <div class="text-right" style="margin-top: 1em">
                            <p>_________________________________</p>
                            <p>Entregado por : _________________</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
      
       
      
    </html>