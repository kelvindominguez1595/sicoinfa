
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>{{ $tipo_de_reporte }} - {{ $code }} - {{ $date }} {{ $time }}</title>

    <style>
        @font-face {
            font-family: Arial, Helvetica, sans-serif;
            font-style: normal;

            src: local('fonts/arial.ttf')
        }

        body {
            font-family: Arial, Helvetica, sans-serif;

            letter-spacing: 1px;
        }
        /** Defina ahora los márgenes reales de cada página en el PDF **/
        table.table2 {
            border: 1px solid #1C6EA4;
            width: 100%;
            /**/
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

                <td style=" width: 50%; ">
                    <strong>ARCO IRIS</strong>
                    <br>
                    FABRICACIÓN DE PRODUCTOS DE CEMENTO Y FERRETERIA
                    <br>

                    <strong>{{ $tipo_de_reporte }}</strong>

                    @if (isset($sucursal))
                        {{$sucursal->name}}
                    @endif
                </td>

                <td style=" width: 15%; font-size:12px; text-align: left;">
                    <strong>Reg. </strong>57462-7 <br>
                    <strong>Dirección.</strong> Av. el Progreso Barrio San Juan, Carretera Litoral, Desvío Principal de
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
            @foreach($campvisibility as $item)
                <th style="">{{$item}}</th>
            @endforeach
            </thead>

            <tbody>

                @php
                    $total_costo         = 0;
                    $total_costo_coniva  = 0;
                    $totalGlobalCompra  = 0;
                    $totalGlobalCompraConIVA  = 0;
                    $totalprecioventa   = 0;
                    $totalventatotal    = 0;
                    $totaldiferencia    = 0;
                    $totalutilidad      = 0;
                    $total_costo_total = 0;
                @endphp
                @foreach ($data as $item)

                    <tr>
                        @if (showFields('CODIGO', $campvisibility))
                            <td style="">{{ $item->code }}</td>
                        @endif

                        @if (showFields('FECHA', $campvisibility))
                                <td style="">{{  date('d-m-Y', strtotime($item->created_at))  }}</td>
                        @endif

                        @if (showFields('CODIGO DE BARRA', $campvisibility))
                                <td style="">{{ $item->barcode }}</td>
                        @endif

                        @if (showFields('CATEGORIA', $campvisibility))
                                <td style="">{{ $item->category_name }}</td>
                        @endif

                        @if (showFields('MARCA', $campvisibility))
                                <td style="">{{ $item->marca_name }}</td>
                        @endif

                        @if (showFields('NOMBRE', $campvisibility))
                                <td style="">{{ $item->name }}</td>
                        @endif

                        @if (showFields('UNIDAD DE MEDIDA', $campvisibility))
                                <td style="">{{ $item->medida_name }}</td>
                        @endif

                        @if (showFields('CANTIDAD', $campvisibility))
                            @php $cantidad = $item->cantidadnew ?? 0; @endphp
                                <td style=""> {{ $cantidad }} </td>
                        @endif

                        @if (showFields('COSTO S/IVA', $campvisibility))
                                @php
                                    $costoReal = $item->cost_s_iva ?? $item->costosiniva;
                                    $total_costo += $costoReal;
                                @endphp
                                <td style=""> ${{ number_format($costoReal,2) }} </td>
                        @endif

                        @if (showFields('COSTO C/IVA', $campvisibility))
                                @php
                                    $costoReal = $item->cost_c_iva ?? $item->costoconiva;
                                    $total_costo_coniva += $costoReal;
                                @endphp
                                <td style=""> ${{ number_format($costoReal,2) }} </td>
                        @endif

                        @if (showFields('TOTAL COMPRA S/IVA', $campvisibility))
                                @php
                                    $costo = $item->cost_s_iva ?? $item->costosiniva;
                                    $totalCompra =  $item->cantidadnew * $costo;
                                    $totalGlobalCompra += $totalCompra;
                                @endphp
                                <td style=""> ${{ number_format($totalCompra,2) }} </td>
                        @endif

                        @if (showFields('TOTAL COMPRA C/IVA', $campvisibility))
                                @php
                                    $costo = $item->cost_c_iva ?? $item->costoconiva;
                                    $totalCompra =  $item->cantidadnew * $costo;
                                    $totalGlobalCompraConIVA += $totalCompra;
                                @endphp
                                <td style=""> ${{ number_format($totalCompra,2) }} </td>
                        @endif

                        @if (showFields('PRECIO DE VENTA', $campvisibility))
                                @php
                                    $preVenta = $item->precioventa ?? $item->sale_price;
                                    $totalprecioventa += $preVenta;
                                @endphp
                                <td style=""> ${{ number_format($preVenta,2) }} </td>
                        @endif

                        @if (showFields('VENTA TOTAL', $campvisibility))
                                @php
                                    $precioventa = $item->precioventa ?? $item->sale_price;
                                    $ventatotal =  $item->cantidadnew * $precioventa;
                                    $totalventatotal += $ventatotal;
                                @endphp
                                <td style=""> ${{ number_format($ventatotal,2) }} </td>
                        @endif

                        @if (showFields('PORCENTAJE %', $campvisibility))
                                @php
                                    $costoper = $item->cost_s_iva ?? $item->costosiniva;
                                    $precioventaper = $item->precioventa ?? $item->sale_price;
                                    $costoperval = $costoper ?? 0;
                                    $precioventapervali = $precioventaper ?? 0;

                                    if($costoperval == 0 || $precioventapervali == 0 ) {
                                        $diferencia = 0;
                                    } else {
                                        $diferencia =  ((($precioventapervali / $costoperval) - 1) *100);
                                    }
                                @endphp
                                <td style=""> {{ number_format(abs($diferencia),2) }} %</td>
                        @endif

                            @if (showFields('DIFERENCIA UNITARIA', $campvisibility))
                                @php
                                    $costoUni = $item->cost_s_iva ?? $item->costosiniva;
                                    $ventaUni = $item->precioventa ?? $item->sale_price;
                                    $diferenciauni = $ventaUni - $costoUni;
                                    $totaldiferencia += $diferenciauni;
                                @endphp
                                <td style=""> ${{  number_format(abs($diferenciauni),2) }} </td>
                        @endif

                            @if (showFields('TOTAL EXISTENCIA S/IVA', $campvisibility))
                                @php
                                    $costoSinIVA = $item->cost_s_iva ?? $item->costosiniva;
                                    $cantidad = $item->cantidadnew ?? 0;
                                    $exissiniva =  $cantidad * $costoSinIVA;
                                @endphp
                                <td style=""> ${{  number_format(abs($exissiniva),2) }} </td>
                        @endif

                            @if (showFields('TOTAL EXISTENCIA C/IVA', $campvisibility))
                                @php
                                      $costoConiva = $item->cost_c_iva ?? $item->costoconiva;
                                      $cantidad = $item->cantidadnew ?? 0;
                                      $existConiva =  $cantidad * $costoConiva;
                                @endphp
                                <td style=""> ${{  number_format(abs($existConiva),2) }} </td>
                        @endif

                            @if (showFields('TOTAL COSTOS', $campvisibility))
                                @php
                                    $costo = $item->cost_s_iva ?? $item->costosiniva;
                                    $result =  $item->cantidadnew * $costo;
                                    $total_costo_total += $result;
                                @endphp
                                <td style=""> ${{  number_format(abs($total_costo_total),2) }} </td>
                        @endif

                            @if (showFields('UTILIDAD TOTAL', $campvisibility))
                                @php
                                    $precioventa = $item->precioventa ?? $item->sale_price;
                                    $ventatotal =  $item->cantidadnew * $precioventa;
                                    $costo = $item->cost_c_iva ?? $item->costoconiva;
                                    $totalCompra =  $item->cantidadnew * $costo;
                                    $utilidad = $ventatotal - $totalCompra;
                                    $totalutilidad += $utilidad;
                                @endphp
                                <td style=""> ${{  number_format(abs($utilidad),2) }} </td>
                        @endif

                    </tr>
                @endforeach
            </tbody>
{{--            <tfoot>--}}
{{--                <tr>--}}
{{--                    <td></td>--}}
{{--                    <td></td>--}}
{{--                    <td></td>--}}
{{--                    <td></td>--}}
{{--                    <td></td>--}}
{{--                    <td></td>--}}
{{--                    <td style="">${{ number_format($totalcosto, 2) }}</td>--}}
{{--                    <td style="">${{ number_format($totalGlobalCompra, 2) }}</td>--}}
{{--                    <td style="">${{ number_format($totalprecioventa, 2) }}</td>--}}
{{--                    <td style="">${{ number_format($totalventatotal, 2) }}</td>--}}
{{--                    <td></td>--}}
{{--                    <td style="">${{ number_format($totaldiferencia, 2) }}</td>--}}
{{--                    <td style="">${{ number_format($totalutilidad, 2) }}</td>--}}
{{--                </tr>--}}
{{--            </tfoot>--}}
        </table>

{{--            @if (showFields('COSTO S/IVA', $campvisibility))--}}
{{--                {{ showPositionTotal('COSTO S/IVA', $campvisibility) }}--}}
{{--            @endif <br>--}}

{{--            @if (showFields('TOTAL COSTOS', $campvisibility))--}}
{{--                {{ showPositionTotal('TOTAL COSTOS', $campvisibility) }}--}}
{{--            @endif <br>--}}

{{--            @if (showFields('VENTA TOTAL', $campvisibility))--}}
{{--                {{ showPositionTotal('VENTA TOTAL', $campvisibility) }}--}}
{{--            @endif <br>--}}

{{--            @if (showFields('TOTAL COMPRA S/IVA', $campvisibility))--}}
{{--                {{ showPositionTotal('TOTAL COMPRA S/IVA', $campvisibility) }}--}}
{{--            @endif <br>--}}

{{--            @if (showFields('PRECIO DE VENTA', $campvisibility))--}}
{{--                {{ showPositionTotal('PRECIO DE VENTA', $campvisibility) }}--}}
{{--            @endif <br>--}}

{{--            @if (showFields('DIFERENCIA UNITARIA', $campvisibility))--}}
{{--                {{ showPositionTotal('DIFERENCIA UNITARIA', $campvisibility) }}--}}
{{--            @endif <br>--}}
{{--            @if (showFields('UTILIDAD TOTAL', $campvisibility))--}}
{{--                {{ showPositionTotal('UTILIDAD TOTAL', $campvisibility) }}--}}
{{--            @endif--}}

    </main>

{{--    <div id="footer">--}}
{{--        <p class="page">Page </p>--}}
{{--    </div>--}}
</body>
</html>

