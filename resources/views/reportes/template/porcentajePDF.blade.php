
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Reporte-Porcentaje- {{ $date }}</title>

    <style>

        /** Defina ahora los márgenes reales de cada página en el PDF **/
        table.table2 {
            border: 1px solid #1C6EA4;
            width: 100%;
            /*text-align: center;*/
            border-collapse: collapse;
        }

        table.table2 td,
        table.table2 th {
            border: 1px solid #AAAAAA;
            padding: 3px 2px;
        }

        table.table2 tbody td {

            font-size: 13px;
        }

        table.table2 thead {
            background: #1C6EA4;
            border-bottom: 2px solid #444444;
        }

        table.table2 thead th {
            font-size: 15px;
            font-weight: bold;
            color: #FFFFFF;
            border-left: 2px solid #D0E4F5;
        }

        table.table2 thead th:first-child {
            border-left: none;
        }

        table.table2 tfoot {
            font-size: 18px;
            font-weight: bold;
            color: #222222;
            background: #D0E4F5;
            background: -moz-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
            background: -webkit-linear-gradient(top, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
            background: linear-gradient(to bottom, #dcebf7 0%, #d4e6f6 66%, #D0E4F5 100%);
            border-top: 2px solid #444444;
        }

        table.table2 tfoot td {

            font-size: 12px;
        }

        table.table2 tfoot .links {
            text-align: right;
        }

        table.table2 tfoot .links a {
            display: inline-block;
            /*background: #1C6EA4;*/
            color: #FFFFFF;
            padding: 2px 8px;
            border-radius: 5px;
        }
        /** Definir las reglas del encabezado **/
        header {
            position: absolute;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;
        }

    </style>
</head>
<body>
    <header>
        <table style="width: 100%;">
            <tbody>
            <tr>
                <td style="width: 15%;">
                   <img src="{{ public_path('images/logoFerreteria.jpg') }}" width="60px" height="50px">
                </td>

                <td style=" width: 50%; text-align: center;">
                    <strong>ARCO IRIS</strong>
                    <br>
                    FABRICACIÓN DE PRODUCTOS DE CEMENTO Y FERREYERIA
                    <br>
                    <strong>REPORTE DE PRODUCTOS</strong>
                    @if (isset($sucursal))
                        {{$sucursal->name}}
                    @endif
                </td>

                <td style=" width: 15%; font-size:12px; text-align: left;">
                    <strong>Reg. </strong>57462-7 <br>
                    <strong>Direccion.</strong> Av. el Progreso Barrio San Juan, Carretera Litoral, DevioPrincipal de
                    Santiago Nonualco <br>
                    <strong>Tel: </strong>2305-6679
                </td>
            </tr>
            </tbody>
        </table>
    </header>
    <p></p>
    <p></p>
    <p></p>
    <p></p>
    <p></p>
    <p></p>
    <main>

        <table class="table2">
            <thead style="border: 2px solid;">
                <th style="text-align: center;">Código</th>
                <th style="text-align: center;">C. de Barra</th>
                <th style="text-align: center;">Categoría</th>
                <th style="text-align: center;">Marca</th>
                <th style="text-align: center;">Nombre</th>
                <th style="text-align: center;">Cantidad</th>
                <th style="text-align: center;">Costo</th>
                <th style="text-align: center;">Total de Compra</th>
                <th style="text-align: center;">P. Venta</th>
                <th style="text-align: center;">Venta Total</th>
                <th style="text-align: center;">% Diferencia</th>
                <th style="text-align: center;">Diferencia Unitaria</th>
                <th style="text-align: center;">Utilidad Total</th>
            </thead>

            <tbody>
                @php
                    $totalcosto         = 0;
                    $totalGlobalCompra  = 0;
                    $totalprecioventa   = 0;
                    $totalventatotal    = 0;
                    $totaldiferencia    = 0;
                    $totalutilidad      = 0;
                @endphp
                @foreach ($data as $item)
                    <tr>
                        <td style="text-align: center;">{{ $item->code }}</td>
                        <td style="text-align: center;">{{ $item->barcode }}</td>
                        <td style="text-align: center;">{{ $item->category_name }}</td>
                        <td style="text-align: center;">{{ $item->marca_name }}</td>
                        <td style="text-align: center;">{{ $item->name }}</td>
                        <td style="text-align: center;">
                            @isset($item->cantidadnew)
                                {{ $item->cantidadnew }}
                            @else
                             0
                            @endisset
                        </td>

                        <td style="text-align: center;">
                            @php
                            if(isset($item->cost_s_iva)){
                                $costoReal = $item->cost_s_iva;
                            }else {
                                $costoReal = $item->costosiniva;
                            }
                            $totalcosto += $costoReal;
                            @endphp
                            ${{number_format($costoReal,2)}}
                        </td>

                        <td style="text-align: center;">
                            @php
                                if(isset($item->cost_s_iva)){
                                    $costo = $item->cost_s_iva;
                                }else {
                                    $costo = $item->costosiniva;
                                }
                                $totalCompra =  $item->cantidadnew * $costo;
                                $totalGlobalCompra += $totalCompra;
                            @endphp
                             ${{number_format($totalCompra,2)}}
                        </td>

                        <td style="text-align: center;">
                            @php
                            if(isset($item->precioventa)){
                                $preVenta = $item->precioventa;
                            }else {
                                $preVenta = $item->sale_price;
                            }
                            $totalprecioventa += $preVenta;
                            @endphp
                            ${{number_format($preVenta,2)}}
                        </td>

                        <td style="text-align: center;">
                            @php
                            if(isset($item->precioventa)){
                                $precioventa = $item->precioventa;
                            }else {
                                $precioventa = $item->sale_price;
                            }
                            $ventatotal =  $item->cantidadnew * $precioventa;
                            $totalventatotal += $ventatotal;
                            @endphp
                            ${{number_format($ventatotal,2)}}
                        </td>

                        <td style="text-align: center;">
                            @php
                                if(isset($item->cost_s_iva)){
                                    $costoper = $item->cost_s_iva;
                                }else {
                                    $costoper = $item->costosiniva;
                                }

                                if(isset($item->precioventa)){
                                    $precioventaper = $item->precioventa;
                                }else {
                                    $precioventaper = $item->sale_price;
                                }

                                if(isset($costoper)){
                                    $costoperval = $costoper;
                                } else {
                                    $costoperval = 0;
                                }

                                if(isset($precioventaper)){
                                    $precioventapervali =  $precioventaper;
                                } else {
                                    $precioventapervali = 0;
                                }
                                if($costoperval == 0 || $precioventapervali == 0 )
                                {
                                    $diferencia = 0;

                                } else {
                                    $diferencia =  ((($precioventapervali / $costoperval) - 1) *100);
                                }
                            @endphp
                            {{number_format(abs($diferencia),2)}}%
                        </td>


                        <td style="text-align: center;">
                            @php
                            if(isset($item->cost_s_iva)){
                                $costoUni = $item->cost_s_iva;
                            }else {
                                $costoUni = $item->costosiniva;
                            }
                            if(isset($item->precioventa)){
                                $ventaUni = $item->precioventa;
                            }else {
                                $ventaUni = $item->sale_price;
                            }
                                $diferenciauni = $ventaUni - $costoUni;
                                $totaldiferencia += $diferenciauni;
                            @endphp
                            ${{number_format(abs($diferenciauni),2)}}
                        </td>

                        <td style="text-align: center;">
                            @php
                                $utilidad = $ventatotal - $totalCompra;
                                $totalutilidad += $utilidad;
                            @endphp
                            ${{number_format(abs($utilidad),2)}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center;">${{ number_format($totalcosto, 2) }}</td>
                    <td style="text-align: center;">${{ number_format($totalGlobalCompra, 2) }}</td>
                    <td style="text-align: center;">${{ number_format($totalprecioventa, 2) }}</td>
                    <td style="text-align: center;">${{ number_format($totalventatotal, 2) }}</td>
                    <td></td>
                    <td style="text-align: center;">${{ number_format($totaldiferencia, 2) }}</td>
                    <td style="text-align: center;">${{ number_format($totalutilidad, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </main>

{{--    <div id="footer">--}}
{{--        <p class="page">Page </p>--}}
{{--    </div>--}}
</body>
</html>

