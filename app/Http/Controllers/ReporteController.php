<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReporteController extends Controller
{
    public function reportes() {

        $title = [
            "CATEGORIA", "CODIGO", "CANTIDAD", "COSTO S/IVA", "COSTO C/IVA",
            "CODIGO DE BARRA", "DIFERENCIA UNITARIA", "FECHA", "MARCA", "NOMBRE",
            "PRECIO DE VENTA", "PORCENTAJE %", "TOTAL COMPRA S/IVA", "TOTAL COMPRA C/IVA", "TOTAL EXISTENCIA S/IVA",
            "TOTAL EXISTENCIA C/IVA", "TOTAL COSTOS", "UTILIDAD TOTAL", "UNIDAD DE MEDIDA", "VENTA TOTAL",
        ];

        $order = array(
            array("name" => "CÓDIGO", "val" => "sk.code"),
            array("name" => "CÓDIGO DE BARRA", "val" => "sk.barcode"),
            array("name" => "CATEGORIA", "val" => "c.name"),
            array("name" => "MARCA", "val" => "man.name"),
            array("name" => "NOMBRE", "val" => "sk.name"),
        );

        $type_report = array(
            array("name" => "PRECIO DE VENTAS", "val" => "precioventas"),
            array("name" => "COSTOS SIN IVA", "val" => "costosiniva"),
            array("name" => "COSTOS Y PORCENTAJES DE UTILIDAD", "val" => "cosporutilidad"),
            array("name" => "UTILIDAD CODIGO Y PERIODO", "val" => "codigoperiodo"),
        );

        return view('reportes.reporte', compact('title', 'order', 'type_report'));
    }

    public function promedio() {
        return view('reportes.promedio');
    }

    public function rendimiento() {
        return view('reportes.rendimiento');
    }
    public function detView() {
        return view('reportes.reporteDETView');
    }

    public function porcentajereporte(Request $request) {
        $request->validate([
            'tipo_de_reporte' => 'required',
        ]);

        $categoria  = $request->categoria;
        $marca      = $request->marca;
        $orderby    = $request->orderby;
        $desde      = $request->desde;
        $hasta      = $request->hasta;
        $tipoprint  = $request->tipoprint;
        $campo      = $request->campo;

        $codigotxt      = $request->codigotxt;
        $codbarratxt    = $request->codigobarratxt;

        /**
         * CAMPOS PARA VER VISIBILIDAD DE LOS CAMPOS
         */
          $CATEGORIA            = $request['CATEGORIA'];
          $CODIGO               = $request['CODIGO'];
          $CANTIDAD             = $request['CANTIDAD'];
          $COSTOSIVA            = $request['COSTOSIVA'];
          $COSTOCIVA            = $request['COSTOCIVA'];
          $CODIGODEBARRA        = $request['CODIGODEBARRA'];
          $DIFERENCIAUNITARIA   = $request['DIFERENCIAUNITARIA'];
          $FECHA                = $request['FECHA'];
          $MARCA                = $request['MARCA'];
          $NOMBRE               = $request['NOMBRE'];
          $PRECIODEVENTA        = $request['PRECIODEVENTA'];
          $PORCENTAJE           = $request['PORCENTAJE'];
          $TOTALCOMPRASIVA      = $request['TOTALCOMPRASIVA'];
          $TOTALCOMPRACIVA      = $request['TOTALCOMPRACIVA'];
          $TOTALEXISTENCIASIVA  = $request['TOTALEXISTENCIASIVA'];
          $TOTALEXISTENCIACIVA  = $request['TOTALEXISTENCIACIVA'];
          $TOTALCOSTOS          = $request['TOTALCOSTOS'];
          $UTILIDADTOTAL        = $request['UTILIDADTOTAL'];
          $UNIDADDEMEDIDA       = $request['UNIDADDEMEDIDA'];
          $VENTATOTAL           = $request['VENTATOTAL'];

        $oldprice = DB::table('detalle_stock')
            ->select(
                DB::raw('MAX(id) as iddstock'),
                'stocks_id',
                DB::raw('MAX(created_at) as created_at'))
            ->groupBy('stocks_id');

        $precionew = DB::table('precios')
            ->select(
                DB::raw('MAX(id) as idprice'),
                'producto_id',
                DB::raw('MAX(created_at) as created_at'))
            ->groupBy('producto_id');

        $cansum = DB::table('detalle_products')
            ->select('id as idsupro', 'branch_offices_id',
                'stocks_id', DB::raw('SUM(quantity) as cantidadnew'))
            ->groupBy('stocks_id');

        $query = DB::table('stocks as sk')
        ->join('categories as c', 'sk.category_id', 'c.id')
        ->join('manufacturers as man', 'sk.manufacturer_id', 'man.id')
        ->join('measures as me', 'sk.measures_id', 'me.id')
        ->leftJoinSub($oldprice, 'detallestock', function($join){
            $join->on('sk.id', '=', 'detallestock.stocks_id');
        })
        ->leftJoin('detalle_stock as detsto', 'detallestock.iddstock', 'detsto.id')
        ->leftJoin('detalle_price as dp', 'detallestock.iddstock', 'dp.detalle_stock_id')
        ->leftJoinSub($precionew, 'precio', function($join){
            $join->on('sk.id', '=', 'precio.producto_id');
        })
        ->leftJoin('precios as price', 'precio.idprice', 'price.id')
        ->leftJoinSub($cansum, 'canprodu', function($join){
            $join->on('sk.id', '=', 'canprodu.stocks_id');
        })
        ->select(
            'sk.id',
            'sk.image',
            'sk.code',
            'sk.barcode',
            'sk.name',
            'sk.exempt_iva',
            'sk.stock_min',
            'sk.description',
            'sk.created_at',
            'c.name as category_name',
            'man.name as marca_name',
            'me.name as medida_name',
            'sk.category_id',
            'sk.manufacturer_id',
            'detsto.created_at as created_atdstock',
            'detsto.id as iddstock',
            'detsto.stocks_id as idsproducto',
            'detsto.invoice_number as numfactura',
            'detsto.invoice_date as fechafactura',
            'detsto.created_at as fechaingreso',
            'dp.cost_s_iva',
            'dp.cost_c_iva',
            'dp.sale_price',
            'dp.state as estateoldprice',
            'price.costosiniva',
            'price.costoconiva',
            'price.ganancia',
            'price.porcentaje',
            'price.precioventa',
            'price.cambio',
            'canprodu.cantidadnew',
        );
        $query->where('sk.state', '=', 1);
        $query->groupBy('sk.id');

         // busqueda por categoria
         if(!empty($categoria)){
            $query->where('sk.category_id', '=', $categoria);
        }

         if(!empty($codigotxt)){
            $query->where('sk.code', '=', $codigotxt);
        }

         if(!empty($codbarratxt)){
            $query->where('sk.barcode', '=', $codbarratxt);
        }
        // busqueda por marca
        if(!empty($marca)){
            $query->where('sk.manufacturer_id', '=', $marca);
        }
        if(!empty($desde) && !empty($hasta)){
            $query->whereBetween('sk.created_at', [$desde, $hasta]);
        }
        $query->orderBy($campo, $orderby);

        $data = $query->get();
        $date = date('d-m-Y-s');
        $code = generarCodigo(4);
//        if($request['tipoprint'] == 'excel'){
//            return $this->porcentajeExcel($data);
//        } else {
//            $pdf = PDF::loadView('reportes.template.porcentajePDF', compact('data', 'date'))->setPaper('legal', 'landscape');
//            set_time_limit(300);
//            return $pdf->download('Reporte-porcentaje-'.$code.'.pdf');
//        }

    }

    public function reporteDET(Request $request){

        $year = $request->year;


        $oldprice = DB::table('detalle_stock')
            ->select(
                DB::raw('MAX(id) as iddstock'),
                'stocks_id',
                DB::raw('MAX(created_at) as created_at'))
            ->groupBy('stocks_id');

        $precionew = DB::table('precios')
            ->select(
                DB::raw('MAX(id) as idprice'),
                'producto_id',
                DB::raw('MAX(created_at) as created_at'))
            ->groupBy('producto_id');

        $cansum = DB::table('detalle_products')
            ->select('id as idsupro', 'branch_offices_id',
                'stocks_id', DB::raw('SUM(quantity) as cantidadnew'))
            ->groupBy('stocks_id');
        $query = DB::table('stocks as sk')
            ->join('categories as c', 'sk.category_id', 'c.id')
            ->join('manufacturers as man', 'sk.manufacturer_id', 'man.id')
            ->join('measures as me', 'sk.measures_id', 'me.id')
            ->leftJoinSub($oldprice, 'detallestock', function($join){
                $join->on('sk.id', '=', 'detallestock.stocks_id');
            })
            ->leftJoin('detalle_stock as detsto', 'detallestock.iddstock', 'detsto.id')
            ->leftJoin('detalle_price as dp', 'detallestock.iddstock', 'dp.detalle_stock_id')
            ->leftJoinSub($precionew, 'precio', function($join){
                $join->on('sk.id', '=', 'precio.producto_id');
            })
            ->leftJoin('precios as price', 'precio.idprice', 'price.id')
            ->leftJoinSub($cansum, 'canprodu', function($join){
                $join->on('sk.id', '=', 'canprodu.stocks_id');
            })
            ->select(
                'sk.id',
                'sk.image',
                'sk.code',
                'sk.barcode',
                'sk.name',
                'sk.exempt_iva',
                'sk.stock_min',
                'sk.description',
                'sk.created_at',
                'c.name as category_name',
                'man.name as marca_name',
                'me.name as medida_name',
                'sk.category_id',
                'sk.manufacturer_id',
                'detsto.created_at as created_atdstock',
                'detsto.id as iddstock',
                'detsto.stocks_id as idsproducto',
                'detsto.invoice_number as numfactura',
                'detsto.invoice_date as fechafactura',
                'detsto.created_at as fechaingreso',
                'dp.cost_s_iva',
                'dp.cost_c_iva',
                'dp.sale_price',
                'dp.state as estateoldprice',
                'price.costosiniva',
                'price.costoconiva',
                'price.ganancia',
                'price.porcentaje',
                'price.precioventa',
                'price.cambio',
                'canprodu.cantidadnew',
            );
        $query->where('sk.state', '=', 1);
        $query->groupBy('sk.id');
         $query->orderBy('sk.name', 'ASC');
        // busqueda por categoria
        /*if(!empty($categoria)){
            $query->where('sk.category_id', '=', $categoria);
        }
        // busqueda por marca
        if(!empty($marca)){
            $query->where('sk.manufacturer_id', '=', $marca);
        }*/
        if(empty($year)){
            $fyear = date('Y');
        } else {
            $fyear = $year;
        }
        $code = generarCodigo(4);
        $query->whereYear('detsto.created_at', $fyear);
        $data = $query->get();
        if($request['tipoprint'] == 'excel'){
            return $this->reporteDETExcel($data);
        } else {
            $pdf = PDF::loadView('reportes.template.detPDF', compact('data'))->setPaper('letter', 'landscape');
            $date = date('d-m-Y-s');
            return $pdf->stream('Reporte-det-'.$code.'.pdf');
        }


    }

    public function porcentajeExcel($data){
        $username = Auth::user()->name;

        $spreadsheet = new Spreadsheet();
        $write = new Xlsx($spreadsheet);

        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()
            ->setCreator(dataTitlesExcel()['creador'])
            ->setLastModifiedBy($username)
            ->setTitle(dataTitlesExcel()['titlereportepor'])
            ->setSubject(dataTitlesExcel()['titlereportepor'])
            ->setDescription(dataTitlesExcel()['descripcionpor'])
            ->setKeywords('Reportes')
            ->setCategory(dataTitlesExcel()['titlereportepor']);

        $sheet->setCellValue('A1', 'CÓDIGO');
        $sheet->setCellValue('B1', 'C. DE BARRA');
        $sheet->setCellValue('C1', 'CATEGORIA');
        $sheet->setCellValue('D1', 'MARCA');
        $sheet->setCellValue('E1', 'NOMBRE');
        $sheet->setCellValue('F1', 'CANTIDAD');
        $sheet->setCellValue('G1', 'COSTO');
        $sheet->setCellValue('H1', 'TOTAL DE COMPRA');
        $sheet->setCellValue('I1', 'P. VENTA');
        $sheet->setCellValue('J1', 'VENTA TOTAL');
        $sheet->setCellValue('K1', '% DIFERENCIA');
        $sheet->setCellValue('L1', 'DIFERENCIA UNITARIA');
        $sheet->setCellValue('M1', 'UTILIDAD TOTAL');

        $i = 2;
        $totalcosto         = 0;
        $totalGlobalCompra  = 0;
        $totalprecioventa   = 0;
        $totalventatotal    = 0;
        $totaldiferencia    = 0;
        $totalutilidad      = 0;
        foreach($data as $item) {
            $sheet->setCellValue('A'.$i, $item->code);
            $sheet->setCellValue('B'.$i, $item->barcode);
            $sheet->setCellValue('C'.$i, $item->category_name);
            $sheet->setCellValue('D'.$i, $item->marca_name);
            $sheet->setCellValue('E'.$i, $item->name);
            if(isset($item->cantidadnew)){
                $cantidad = $item->cantidadnew;
            } else {
                $cantidad = 0;
            }
            $sheet->setCellValue('F'.$i, $cantidad);

            if(isset($item->cost_s_iva)){
                $costoReal = $item->cost_s_iva;
            }else {
                $costoReal = $item->costosiniva;
            }
            $totalcosto += $costoReal;

            $sheet->setCellValue('G'.$i, number_format($costoReal,2));
            if(isset($item->cost_s_iva)){
                $costo = $item->cost_s_iva;
            }else {
                $costo = $item->costosiniva;
            }
            $totalCompra =  $item->cantidadnew * $costo;
            $totalGlobalCompra += $totalCompra;

            $sheet->setCellValue('H'.$i, number_format($totalCompra,2));
            if(isset($item->precioventa)){
                $preVenta = $item->precioventa;
            }else {
                $preVenta = $item->sale_price;
            }
            $totalprecioventa += $preVenta;
            $sheet->setCellValue('I'.$i, number_format($preVenta,2));
            if(isset($item->precioventa)){
                $precioventa = $item->precioventa;
            }else {
                $precioventa = $item->sale_price;
            }
            $ventatotal =  $item->cantidadnew * $precioventa;
            $totalventatotal += $ventatotal;

            $sheet->setCellValue('J'.$i, number_format($ventatotal,2));
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

            $sheet->setCellValue('K'.$i, number_format(abs($diferencia),2));
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

            $sheet->setCellValue('L'.$i, number_format(abs($diferenciauni),2));
            $utilidad = $ventatotal - $totalCompra;
            $totalutilidad += $utilidad;
            $sheet->setCellValue('M'.$i, number_format(abs($utilidad),2));
            $i++;
        }

        $sheet->setCellValue('G'.$i, number_format($totalcosto, 2));
        $sheet->setCellValue('H'.$i, number_format($totalGlobalCompra, 2));
        $sheet->setCellValue('I'.$i, number_format($totalprecioventa, 2));
        $sheet->setCellValue('J'.$i, number_format($totalventatotal, 2));
        $sheet->setCellValue('L'.$i, number_format($totaldiferencia, 2));
        $sheet->setCellValue('M'.$i, number_format($totalutilidad, 2));

        $code = generarCodigo(4);
        $filename = 'historial-compras-'.$code.'.xlsx';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='. $filename);
        header('Cache-Control: max-age=0');

        $write->save('php://output');
        exit();
    }

    public function reporteDETExcel($data){
        $username = Auth::user()->name;

        $spreadsheet = new Spreadsheet();
        $write = new Xlsx($spreadsheet);

        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()
            ->setCreator(dataTitlesExcel()['creador'])
            ->setLastModifiedBy($username)
            ->setTitle(dataTitlesExcel()['titlereportepor'])
            ->setSubject(dataTitlesExcel()['titlereportepor'])
            ->setDescription(dataTitlesExcel()['descripcionpor'])
            ->setKeywords('Reportes')
            ->setCategory(dataTitlesExcel()['titlereportepor']);

        $sheet->setCellValue('A1', 'CÓDIGO');
        $sheet->setCellValue('B1', 'C. DE BARRA');
        $sheet->setCellValue('C1', 'CATEGORIA');
        $sheet->setCellValue('D1', 'MARCA');
        $sheet->setCellValue('E1', 'NOMBRE');
        $sheet->setCellValue('F1', 'CANTIDAD');
        $sheet->setCellValue('G1', 'MEDIDA');
        $sheet->setCellValue('H1', 'COSTO');
        $sheet->setCellValue('I1', 'TOTAL DE COMPRA');

        $i = 2;
        $totalcosto         = 0;
        $totalGlobalCompra  = 0;
        foreach($data as $item) {
            $sheet->setCellValue('A'.$i, $item->code);
            $sheet->setCellValue('B'.$i, $item->barcode);
            $sheet->setCellValue('C'.$i, $item->category_name);
            $sheet->setCellValue('D'.$i, $item->marca_name);
            $sheet->setCellValue('E'.$i, $item->name);

            if(isset($item->cantidadnew)){
                $cantidad = $item->cantidadnew;
            } else {
                $cantidad = 0;
            }
            $sheet->setCellValue('F'.$i, $cantidad);

            $sheet->setCellValue('G'.$i, $item->medida_name);

            if(isset($item->cost_s_iva)){
                $costoReal = $item->cost_s_iva;
            }else {
                $costoReal = $item->costosiniva;
            }
            $totalcosto += $costoReal;
            $sheet->setCellValue('H'.$i, number_format($costoReal,2));

            if(isset($item->cost_s_iva)){
                $costo = $item->cost_s_iva;
            }else {
                $costo = $item->costosiniva;
            }
            $totalCompra =  $item->cantidadnew * $costo;
            $totalGlobalCompra += $totalCompra;

            $sheet->setCellValue('I'.$i, number_format($totalCompra,2));

            $i++;
        }



        $code = generarCodigo(4);
        $filename = 'historial-det-'.$code.'.xlsx';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='. $filename);
        header('Cache-Control: max-age=0');

        $write->save('php://output');
        exit();
    }
}
