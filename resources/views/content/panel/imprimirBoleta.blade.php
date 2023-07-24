{{$medidaTicket = 180;}}

<html>

<head>

    <style>
        * {
            font-size: 12px;
            font-family: 'DejaVu Sans', serif;
        }

        h1 {
            font-size: 18px;
        }

        .ticket {
            margin: 1px;
        }

        .nombre{
            font-size: 10px
        }

        td,
        th,
        tr,
        table {
            border-top: 1px solid black;
            border-collapse: collapse;
            margin: 0 auto;
        }

        td.precio {
            text-align: right;
            font-size: 11px;
        }

        td.cantidad {
            font-size: 11px;
        }

        td.producto {
            text-align: center;
        }

        th {
            text-align: center;
        }
        .centrado {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: <?php echo $medidaTicket ?>px;
            max-width: <?php echo $medidaTicket ?>px;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        * {
            margin: 0;
            padding: 0;
        }

        .ticket {
            margin: 0;
            padding: 0;
        }

        body {
            text-align: center;
        }
    </style>

    <script>
        
    </script>

</head>

<body>
    <div class="ticket centrado">
        <span>INVERSIONES Y COMERCIO</span>
        <span>MARKET PLACE  SAC</span>
        <span><br>Boleta de venta # {{$codigo}} <br></span>
        <span>{{$venta['created_at']}} <br></span>
        <span class="nombre">Dni: {{$venta['dni_cliente']}} - Cliente: <br></span>
        <span class="nombre">{{$venta['nombres_cliente']}}</span>

        <table>
            <thead>
                <tr class="centrado">
                    <th class="cantidad">Cant.</th>
                    <th class="producto">Producto</th>
                    <th class="precio">Precio</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($productos as $producto) {
                    // $total += $producto["cantidad"] * $producto["precio"];
                ?>
                    <tr>
                        <td class="cantidad">{{$producto['cantidad']}}</td>
                        <td class="producto">{{($producto['producto_nombre'])}}</td>
                        <td class="precio"><?php echo number_format($producto["precio"], 2) ?></td>
                    </tr>
                <?php }
                ?>
            </tbody>
            <tr>
                <td class="cantidad"><strong>SUBT.</strong></td>
                <td class="producto">--------
                </td>
                <td class="precio">
                    S/{{$venta['subtotal']}}
                </td>
            </tr>
            <tr>
                <td class="cantidad"><strong>IGV</strong></td>
                <td class="producto">
                    18%
                </td>
                <td class="precio">
                    S/{{$venta['igv']}}
                    
                </td>
            </tr>
            <tr>
                <td class="cantidad"><strong>TOTAL</strong></td>
                <td class="producto">
                    --------
                </td>
                <td class="precio">
                    S/{{$venta['pago_total']}}
                    
                    
                </td>
            </tr>
        </table>
        <p class="centrado">¡GRACIAS POR SU COMPRA!
            <br>parzibyte.me</p>
    </div>
</body>

</html>