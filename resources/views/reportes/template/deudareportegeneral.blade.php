
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Reporte de Deuda General - {{ $code }} - {{ $date }} {{ $time }}</title>

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

                <td style="text-align: center; width: 50%; ">
                    <strong>ARCO IRIS</strong>
                    <br>
                    FABRICACIÓN DE PRODUCTOS DE CEMENTO Y FERRETERIA
                    <br>

                    <strong>REPORTE DEUDAD GENERAL</strong>
                    <br>              
                    @if (!empty($estadodeuda))
                        @if ($estadodeuda == 1)
                         ESTADO  CRÉDITO                            
                        @else
                         ESTADO  PAGADO                            
                        @endif
                
                    @endif
                    <br>
                    @if(!empty($desde) && !empty($hasta))
                        Desde:{{  date('d/m/Y', strtotime($desde)) }} Hasta: {{ date('d/m/Y', strtotime($hasta)) }}
                    @endif
                </td>

                <td style=" width: 15%; font-size:11px; text-align: left;">
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
    <p></p>
    <p></p>

    <main>

        <table class="table2">
            <thead style="border: 2px solid;">
                <th>PROVEEDOR</th>
                <th>TOTAL</th>              
            </thead>

            <tbody>

                @php $totalfinaldeudatodo = 0; @endphp
                @foreach ($data as $item)               
                @php $totalfinaldeudatodo += $item->totaldeudaproveedor; @endphp
                    <tr>
                        <td>{{ $item->nombre_comercial }}</td>                         
                        <td>${{ number_format($item->totaldeudaproveedor,2) }}</td>                         
                    </tr>
                @endforeach
    
            </tbody>
            <tfoot>
                <tr>
                    <td style="text-align: right;">DEUDA TOTAL</td>
                    <td>${{ number_format($totalfinaldeudatodo, 2) }} </td>
                </tr>
            </tfoot>
        </table>



    </main>


</body>
</html>

