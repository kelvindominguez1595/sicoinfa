
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Historial de Compras- {{ $date }}</title>

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
                    <strong>Historial de Compras</strong>
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
                <th style="text-align: center;">CÓDIGO</th>
                <th style="text-align: center;">CATEGORÍA</th>
                <th style="text-align: center;">MARCA</th>
                <th style="text-align: center;">PRODUCTO</th>
                <th style="text-align: center;">PROVEEDOR</th>
                <th style="text-align: center;">CANTIDAD</th>
                <th style="text-align: center;">U. DE MEDIDA</th>
                <th style="text-align: center;">P. UNI. SIN IVA</th>
                <th style="text-align: center;">P. UNI. CON IVA</th>
                <th style="text-align: center;">ALMACÉN</th>
                <th style="text-align: center;">FECHA INGRESO</th>
                <th style="text-align: center;">CRÉDITO FISCAL</th>
                <th style="text-align: center;">FECHA FACTURA</th>
            </thead>

            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td style="text-align: center;">{{ $item->code }}</td>
                        <td style="text-align: center;">{{ $item->category_name }}</td>
                        <td style="text-align: center;">{{ $item->marca_name }}</td>
                        <td style="text-align: center;">{{ $item->name }}</td>
                        <td style="text-align: center;">{{ $item->cliente }}</td>
                        <td style="text-align: center;">{{ $item->cantidadnew }}</td>
                        <td style="text-align: center;">{{ $item->medida_name }}</td>

                            @if (isset($item->costosiniva))
                                <td style="text-align: center;">${{ number_format($item->costosiniva, 4) }}</td>
                                <td style="text-align: center;">${{ number_format($item->costoconiva, 4) }}</td>
                            @else
                                <td style="text-align: center;">${{ number_format($item->cost_s_iva, 4) }}</td>
                                <td style="text-align: center;">${{ number_format($item->cost_c_iva, 4) }}</td>
                            @endif

                        <td style="text-align: center;">
                            {{ $item->sucursal }}
                        </td>

                        <td style="text-align: center;">
                            {{ date('d-m-Y h:i:s A', strtotime($item->fechaingreso)) }}
                        </td>

                        <td style="text-align: center;">
                            {{ $item->nit }}
                        </td>

                        <td style="text-align: center;">
                            {{ date('d-m-Y', strtotime($item->fechafactura)) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>
</html>

