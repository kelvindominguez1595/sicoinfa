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
            "CODIGO",
            "FECHA",
            "CODIGO DE BARRA",
            "CATEGORIA",
            "MARCA",
            "NOMBRE",
            "UNIDAD DE MEDIDA",
            "CANTIDAD",
            "COSTO S/IVA",
            "COSTO C/IVA",
            "TOTAL COMPRA S/IVA",
            "TOTAL COMPRA C/IVA",
            "PRECIO DE VENTA",
            "VENTA TOTAL",
            "PORCENTAJE %",
            "DIFERENCIA UNITARIA",
            "TOTAL EXISTENCIA S/IVA",
            "TOTAL EXISTENCIA C/IVA",
            "TOTAL COSTOS",
            "UTILIDAD TOTAL",
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
        $tipo_de_reporte  = $request->tipo_de_reporte;
        $campo      = $request->campo;

        $codigotxt      = $request->codigotxt;
        $codbarratxt    = $request->codigobarratxt;
        /** PARA MOSTRAR LOS CAMPOS */
        $campVisibility = $request['visibility'];

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
       // $query->where('canprodu.cantidadnew', '>', 0);
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

        if($request['tipoprint'] == 'excel'){
            return $this->porcentajeExcel($data, $campVisibility, $tipo_de_reporte);
        } else {
            return $this->reportePDF($data, $campVisibility, $tipo_de_reporte);
       }

    }

    public function reportePDF($data, $campvisibility, $tipo_de_reporte){
        $date = date('d-m-Y');
        $code = generarCodigo(4);
        $time = date('h.i.s A');

    //    return view('reportes.template.reportePDF',
    //        compact('data', 'date', 'campvisibility', 'tipo_de_reporte', 'time', 'code'));
   // $pdf = PDF::loadHTML('<h1>Test</h1>');

   ini_set("memory_limit", "512M");
   set_time_limit(300);
       $pdf = PDF::loadView('reportes.template.reportePDF',
            compact('data', 'date', 'campvisibility', 'tipo_de_reporte', 'time', 'code'))
            ->setPaper('legal', 'landscape');
            return $pdf->download( $tipo_de_reporte.' - '.$code.' - '.$date.' '.$time.'.pdf');

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

    public function porcentajeExcel($data, $campvisibility, $tipo_de_reporte){
        $username = Auth::user()->name;
        $mi_letra = "A";

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

        for ($i =0; $i < count($campvisibility); $i++){
            $sheet->setCellValue($mi_letra.'1', $campvisibility[$i]);
            $mi_letra++;
        }

        $arrayLetras = $this->matriz_Letras_AZ($campvisibility);

        $i = 2;
        $total_costo         = 0;
        $total_costo_coniva  = 0;
        $totalGlobalCompra  = 0;
        $totalGlobalCompraConIVA  = 0;
        $totalprecioventa   = 0;
        $totalventatotal    = 0;
        $totaldiferencia    = 0;
        $totalutilidad      = 0;
        $total_costo_total = 0;

        foreach($data as $item) {

            if($this->filter_letra('CODIGO', $arrayLetras)){
                $letra = $this->filter_letra('CODIGO',$arrayLetras);
                $sheet->setCellValue($letra.$i, $item->code);
            }

            if($this->filter_letra('FECHA',$arrayLetras)){
                $letra = $this->filter_letra('FECHA',$arrayLetras);
                $sheet->setCellValue($letra.$i, date('d-m-Y', strtotime($item->created_at)));
            }

            if($this->filter_letra('CODIGO DE BARRA',$arrayLetras)){
                $letra = $this->filter_letra('CODIGO DE BARRA',$arrayLetras);
                $sheet->setCellValue($letra.$i, $item->barcode);
            }

            if($this->filter_letra('CATEGORIA',$arrayLetras)){
                $letra = $this->filter_letra('CATEGORIA',$arrayLetras);
                $sheet->setCellValue($letra.$i, $item->category_name);
            }

            if($this->filter_letra('MARCA',$arrayLetras)){
                $letra = $this->filter_letra('MARCA',$arrayLetras);
                $sheet->setCellValue($letra.$i, $item->marca_name);
            }

            if($this->filter_letra('NOMBRE',$arrayLetras)){
                $letra = $this->filter_letra('NOMBRE',$arrayLetras);
                $sheet->setCellValue($letra.$i, $item->name);
            }

            if($this->filter_letra('UNIDAD DE MEDIDA',$arrayLetras)){
                $letra = $this->filter_letra('UNIDAD DE MEDIDA',$arrayLetras);
                $sheet->setCellValue($letra.$i, $item->medida_name);
            }

            if($this->filter_letra('CANTIDAD',$arrayLetras)){
                $letra = $this->filter_letra('CANTIDAD',$arrayLetras);
                $cantidad = $item->cantidadnew ?? 0;
                $sheet->setCellValue($letra.$i, $cantidad);
            }

            if($this->filter_letra('COSTO S/IVA',$arrayLetras)){
                $letra = $this->filter_letra('COSTO S/IVA',$arrayLetras);
                $costoReal = $item->cost_s_iva ?? $item->costosiniva;
                $total_costo += $costoReal;
                $sheet->setCellValue($letra.$i, number_format($costoReal,2));
            }

            if($this->filter_letra('COSTO C/IVA',$arrayLetras)){
                $letra = $this->filter_letra('COSTO C/IVA',$arrayLetras);
                $costoReal = $item->cost_c_iva ?? $item->costoconiva;
                $total_costo_coniva += $costoReal;
                $sheet->setCellValue($letra.$i, number_format($costoReal,2));
            }

            if($this->filter_letra('TOTAL COMPRA S/IVA',$arrayLetras)){
                $letra = $this->filter_letra('TOTAL COMPRA S/IVA',$arrayLetras);
                $costo = $item->cost_s_iva ?? $item->costosiniva;
                $totalCompra =  $item->cantidadnew * $costo;
                $totalGlobalCompra += $totalCompra;

                $sheet->setCellValue($letra.$i, number_format($totalCompra,2));
            }

            if($this->filter_letra('TOTAL COMPRA C/IVA',$arrayLetras)){
                $letra = $this->filter_letra('TOTAL COMPRA C/IVA',$arrayLetras);
                $costo = $item->cost_c_iva ?? $item->costoconiva;
                $totalCompra =  $item->cantidadnew * $costo;
                $totalGlobalCompraConIVA += $totalCompra;

                $sheet->setCellValue($letra.$i, number_format($totalCompra,2));
            }

            if($this->filter_letra('PRECIO DE VENTA',$arrayLetras)){
                $letra = $this->filter_letra('PRECIO DE VENTA',$arrayLetras);
                $preVenta = $item->precioventa ?? $item->sale_price;
                $totalprecioventa += $preVenta;
                $sheet->setCellValue($letra.$i, number_format($preVenta,2));
            }

            if($this->filter_letra('VENTA TOTAL',$arrayLetras)){
                $letra = $this->filter_letra('VENTA TOTAL',$arrayLetras);
                $precioventa = $item->precioventa ?? $item->sale_price;
                $ventatotal =  $item->cantidadnew * $precioventa;
                $totalventatotal += $ventatotal;

                $sheet->setCellValue($letra.$i, number_format($ventatotal,2));
            }

            if($this->filter_letra('PORCENTAJE %',$arrayLetras)){
                $letra = $this->filter_letra('PORCENTAJE %',$arrayLetras);
                $costoper = $item->cost_s_iva ?? $item->costosiniva;
                $precioventaper = $item->precioventa ?? $item->sale_price;
                $costoperval = $costoper ?? 0;
                $precioventapervali = $precioventaper ?? 0;

                if($costoperval == 0 || $precioventapervali == 0 ) {
                    $diferencia = 0;
                } else {
                    $diferencia =  ((($precioventapervali / $costoperval) - 1) *100);
                }
                $sheet->setCellValue($letra.$i, number_format(abs($diferencia),2));
            }

            if($this->filter_letra('DIFERENCIA UNITARIA',$arrayLetras)){
                $letra = $this->filter_letra('DIFERENCIA UNITARIA',$arrayLetras);
                $costoUni = $item->cost_s_iva ?? $item->costosiniva;
                $ventaUni = $item->precioventa ?? $item->sale_price;
                $diferenciauni = $ventaUni - $costoUni;
                $totaldiferencia += $diferenciauni;

                $sheet->setCellValue($letra.$i, number_format(abs($diferenciauni),2));
            }

            if($this->filter_letra('TOTAL EXISTENCIA S/IVA',$arrayLetras)){
                $letra = $this->filter_letra('TOTAL EXISTENCIA S/IVA',$arrayLetras);
                $costoSinIVA = $item->cost_s_iva ?? $item->costosiniva;
                $cantidad = $item->cantidadnew ?? 0;
                $exissiniva =  $cantidad * $costoSinIVA;
                $sheet->setCellValue($letra.$i,  number_format(abs($exissiniva),2));
            }

            if($this->filter_letra('TOTAL EXISTENCIA C/IVA',$arrayLetras)){
                $letra = $this->filter_letra('TOTAL EXISTENCIA C/IVA',$arrayLetras);
                $costoConiva = $item->cost_c_iva ?? $item->costoconiva;
                $cantidad = $item->cantidadnew ?? 0;
                $existConiva =  $cantidad * $costoConiva;
                $sheet->setCellValue($letra.$i,  number_format(abs($existConiva),2));
            }

            if($this->filter_letra('TOTAL COSTOS',$arrayLetras)){
                $letra = $this->filter_letra('TOTAL COSTOS',$arrayLetras);
                $costo = $item->cost_s_iva ?? $item->costosiniva;
                $result =  $item->cantidadnew * $costo;

                $total_costo_total += $result;
                $sheet->setCellValue($letra.$i, $total_costo_total);
            }

            if($this->filter_letra('UTILIDAD TOTAL',$arrayLetras)){
                $letra = $this->filter_letra('UTILIDAD TOTAL',$arrayLetras);
                $precioventa = $item->precioventa ?? $item->sale_price;
                $ventatotal =  $item->cantidadnew * $precioventa;
                $costo = $item->cost_c_iva ?? $item->costoconiva;
                $totalCompra =  $item->cantidadnew * $costo;
                $utilidad = $ventatotal - $totalCompra;

                $totalutilidad += $utilidad;
                $sheet->setCellValue($letra.$i,  number_format(abs($utilidad),2));
            }
            $i++;
        }

        if($this->filter_letra('COSTO S/IVA',$arrayLetras)){
            $letra = $this->filter_letra('COSTO S/IVA',$arrayLetras);
            $sheet->setCellValue($letra.$i, number_format($total_costo, 2));
        }

        if($this->filter_letra('TOTAL COSTOS',$arrayLetras)){
            $letra = $this->filter_letra('TOTAL COSTOS',$arrayLetras);
            $sheet->setCellValue($letra.$i, number_format($total_costo_total, 2));
        }

        if($this->filter_letra('VENTA TOTAL',$arrayLetras)){
            $letra = $this->filter_letra('VENTA TOTAL',$arrayLetras);
            $sheet->setCellValue($letra.$i, number_format($totalventatotal, 2));
        }

        if($this->filter_letra('TOTAL COMPRA S/IVA',$arrayLetras)){
            $letra = $this->filter_letra('TOTAL COMPRA S/IVA',$arrayLetras);
            $sheet->setCellValue($letra.$i, number_format($totalGlobalCompra, 2));
        }

        if($this->filter_letra('PRECIO DE VENTA',$arrayLetras)){
            $letra = $this->filter_letra('PRECIO DE VENTA',$arrayLetras);
            $sheet->setCellValue($letra.$i, number_format($totalprecioventa, 2));
        }

        if($this->filter_letra('VENTA TOTAL',$arrayLetras)){
            $letra = $this->filter_letra('VENTA TOTAL',$arrayLetras);
            $sheet->setCellValue($letra.$i, number_format($totalventatotal, 2));
        }

        if($this->filter_letra('DIFERENCIA UNITARIA',$arrayLetras)){
            $letra = $this->filter_letra('DIFERENCIA UNITARIA',$arrayLetras);
            $sheet->setCellValue($letra.$i, number_format(abs($totaldiferencia), 2));
        }

        if($this->filter_letra('UTILIDAD TOTAL',$arrayLetras)){
            $letra = $this->filter_letra('UTILIDAD TOTAL',$arrayLetras);
            $sheet->setCellValue($letra.$i, number_format(abs($totalutilidad), 2));
        }


        $date = date('d-m-Y');
        $time = date('h.i.s A');
        $code = generarCodigo(4);
        $filename = $tipo_de_reporte.' - '.$code.' - '.$date.' '.$time.'.xlsx';

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

            $cantidad = $item->cantidadnew ?? 0;
            $sheet->setCellValue('F'.$i, $cantidad);

            $sheet->setCellValue('G'.$i, $item->medida_name);

            $costoReal = $item->cost_s_iva ?? $item->costosiniva;
            $totalcosto += $costoReal;
            $sheet->setCellValue('H'.$i, number_format($costoReal,2));

            $costo = $item->cost_s_iva ?? $item->costosiniva;
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

    public function matriz_Letras_AZ($visibility): array
    {
        $mi_letra = "A";
        $arr = [];
        for ($i =0; $i < count($visibility); $i++) {
            $arr[] = ["name" => $visibility[$i], "letra" => $mi_letra];
            $mi_letra++;
        }
        return $arr;
    }

    public function filter_letra($name, $letraArray){
        $letra = '';
        foreach ($letraArray as  $val){
            if($name === $val['name']){
                $letra = $val['letra'];
            }
        }
        return $letra;
    }
}
