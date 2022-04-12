<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReporteController extends Controller
{
    public function porcentaje() {
        return view('reportes.porcentaje');
    }

    public function promedio(Request $request) {
        return view('reportes.promedio');
    }

    public function rendimiento(Request $request) {
        return view('reportes.rendimiento');
    }

    public function porcentajereporte(Request $request) {
        $categoria  = $request->categoria;
        $marca      = $request->marca;
        $orderby    = $request->orderby;
        $desde      = $request->desde;
        $hasta      = $request->hasta;
        $tipoprint  = $request->tipoprint;
        $campo      = $request->campo;

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
        // busqueda por marca
        if(!empty($marca)){
            $query->where('sk.manufacturer_id', '=', $marca);
        }
        $query->whereBetween('detsto.created_at', [$desde, $hasta]);
        $query->orderBy($campo, $orderby);

        $data = $query->get();
        $date = date('d-m-Y-s');
        $code = generarCodigo(4);
        if($request['tipoprint'] == 'excel'){
            return $this->porcentajeExcel($data);
        } else {
            $pdf = PDF::loadView('reportes.template.porcentajePDF', compact('data', 'date'))->setPaper('legal', 'landscape');
            set_time_limit(300);
            return $pdf->download('Reporte-porcentaje-'.$code.'.pdf');
        }

    }

    public function reporteDET(Request $request){
        $categoria = $request->categoria;
        $marca = $request->marca;
        $orderby = $request->orderby;
        $desde = $request->desde;
        $hasta = $request->hasta;

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
        // $query->orderBy('sk.name', 'desc');
        // busqueda por categoria
        if(!empty($categoria)){
            $query->where('sk.category_id', '=', $categoria);
        }
        // busqueda por marca
        if(!empty($marca)){
            $query->where('sk.manufacturer_id', '=', $marca);
        }
        $query->whereBetween('detsto.created_at', [$desde, $hasta]);
        $data = $query->get();

        $pdf = PDF::loadView('reportes.template.detPDF', compact('data'))->setPaper('letter', 'landscape');
        $date = date('d-m-Y-s');
        return $pdf->stream('Reporte-producto-'.$date.'.pdf');
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
            ->setTitle(dataTitlesExcel()['titlereportepro'])
            ->setSubject(dataTitlesExcel()['titlereportepro'])
            ->setDescription(dataTitlesExcel()['descripcionpro'])
            ->setKeywords('Reportes')
            ->setCategory(dataTitlesExcel()['titlereportepro']);

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

}
