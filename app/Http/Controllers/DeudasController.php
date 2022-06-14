<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Deudas;
use App\Models\Clientes;
use App\Models\Documentos;
use App\Models\FormasPagos;
use Illuminate\Http\Request;
use App\Models\DeudasNotaCredito;
use App\Models\DeudasPagos;
use App\Models\DeudasAbonos;
use App\Models\CondicionesPagos;
use Illuminate\Support\Facades\DB;

class DeudasController extends Controller
{

    public function index(Request $request) {
        $formapago      = FormasPagos::all();
        $tipofactura    = Documentos::all();
        $condicion      = CondicionesPagos::orderby('id','asc')->take(2)->get();
        $pagos          = CondicionesPagos::all()->where('id', 3);
        return view('deudas.index', compact('formapago', 'tipofactura', 'condicion', 'pagos'));
    }

    public function nuevadeuda(Request $request){
        Deudas::create($request->all());
        return response()->json(['messages' => 'ok'], 200);
    }
    
    public function notacredito(Request $request){
        DeudasNotaCredito::create($request->all());
        return response()->json(['messages' => 'ok'], 200);
    }

    public function pagos(Request $request){
        $date = Carbon::now();
        DeudasPagos::create([
            'deudas_id' =>  $request->deudas_idpago,
            'total_pago' =>  $request->totalpagoshow == '' ? 0 : $request->totalpagoshow,
            'numero_recibo' => $request->numeropago,
            'formapago_id' =>  $request->formapago_idpago,
            'numero' => $request->numerochequepago,
            'condicionespago_id' => $request->condicionespago_id,
        ]);
        return response()->json(['message' => 'ok'], 200);
    }

    public function abonos(Request $request){
        DeudasAbonos::create([
            'deudas_id' =>  $request->deudas_idabonos,
            'total_pago' =>  $request->total_pagoabono == '' ? 0 : $request->total_pagoabono,
            'numero_recibo' => $request->numfactura,
            'formapago_id' =>  $request->form_pagoabono,
            'numero' => $request->numcheque_abono,
            'condicionespago_id' => $request->condicionpago_abono,
            'fecha_abono' => $request->fecha_abono,
        ]);
        return response()->json(['message' => 'ok'], 200);
    }

    public function addModdate($date) {
        $res = Carbon::parse($date)->addDays(30);
        return response()->json(['dateforma' => $res->format('Y-m-d')], 200);
    }

    public function dateNow(){
        $date = Carbon::now();
        return response()->json(['dateforma' => $date->format('Y-m-d')], 200);
    }

    public function searchfactura(Request $request) {
        if($request->ajax()){
            $term = trim($request->term);
            $suppliers = Deudas::select('id', 'numero_factura as text')
                ->where('numero_factura', 'LIKE', '%' . $term . '%')
                ->where('estadodeuda', 1)
                ->orderBy('numero_factura', 'ASC')
                ->simplePaginate(10);

            $morePages = true;
            if (empty($suppliers->nextPageUrl())) {
                $morePages = false;
            }
            $results = array(
                "results" => $suppliers->items(),
                "pagination" => array(
                    "more" => $morePages,
                ),
            );
            return response()->json($results);
        }
    }

    public function deudashow($id) {
        $sumaabonos = DB::table('deudas_abonos')
        ->select(DB::raw('MAX(id) as idabonos'),'deudas_id', DB::raw('SUM(total_pago) as total_abonos'))
        ->groupBy('deudas_id');

        $sumanotas = DB::table('deudas_notacredito as no')
        ->select(DB::raw('MAX(id) as idno'),'deudas_id', DB::raw('SUM(total_pago) as total_nota'))
        ->groupBy('deudas_id');

        $data = DB::table('deudas as de')
        ->join('documentos as do', 'de.documento_id', 'do.id')
        ->join('condicionespago as con', 'de.condicionespago_id', 'con.id')
        ->leftJoinSub($sumaabonos, 'sumabonos', function($join){
            $join->on('de.id', '=', 'sumabonos.deudas_id');
        })
        ->leftJoinSub($sumanotas, 'sumanotas', function($join){
            $join->on('de.id', '=', 'sumanotas.deudas_id');
        })
        ->leftJoin('deudas_abonos as dab', 'sumabonos.idabonos', '=', 'dab.id')
        ->leftJoin('deudas_notacredito as dno', 'sumanotas.idno', '=', 'dno.id')
        ->leftJoin('deudas_pagos as dpa', 'de.id', '=', 'dpa.deudas_id')
        ->leftJoin('formaspagos as frmpaabono', 'frmpaabono.id', '=', 'dab.formapago_id')
        ->leftJoin('formaspagos as frmpapago', 'frmpapago.id', '=', 'dpa.formapago_id')
        ->select(
            'de.id',
            'de.proveedor_id', 
            'de.numero_factura', 
            'de.documento_id', 
            'do.name as documento',
            'de.condicionespago_id', 
            'de.fecha_factura', 
            'de.fecha_pago', 
            'de.total_compra',
            'dno.numero as numnota', 
            'sumanotas.total_nota as totalpago_nota', 
            'dno.fecha_notacredito',
            'sumabonos.total_abonos as totalpago_abono', 
            'dab.id as idbonodes', 
            'dab.numero_recibo as numreciboabono', 
            'frmpaabono.name as formpagoabono', 
            'dab.numero as numabono', 
            'dab.fecha_abono',
            'dpa.total_pago as totalpago_pago', 
            'dpa.numero_recibo as numrecibopago', 
            'frmpapago.name as formpago', 
            'dpa.numero as numpago'
        )
        ->groupBy('dab.deudas_id')
        ->orderBy('dab.id', 'ASC')
        ->where('de.id','=', $id)
        ->get();
        return response()->json($data);
    }

    public function loaddatadeuda(Request $request){

        $sumaabonos = DB::table('deudas_abonos')
        ->select(DB::raw('MAX(id) as idabonos'),'deudas_id', DB::raw('SUM(total_pago) as total_abonos'))
        ->groupBy('deudas_id');

        $sumanotas = DB::table('deudas_notacredito as no')
        ->select(DB::raw('MAX(id) as idno'),'deudas_id', DB::raw('SUM(total_pago) as total_nota'))
        ->groupBy('deudas_id');

        $data = DB::table('deudas as de')
        ->join('documentos as do', 'de.documento_id', 'do.id')
        ->join('condicionespago as con', 'de.condicionespago_id', 'con.id')
        ->leftJoinSub($sumaabonos, 'sumabonos', function($join){
            $join->on('de.id', '=', 'sumabonos.deudas_id');
        })
        ->leftJoinSub($sumanotas, 'sumanotas', function($join){
            $join->on('de.id', '=', 'sumanotas.deudas_id');
        })
        ->leftJoin('deudas_abonos as dab', 'sumabonos.idabonos', '=', 'dab.id')
        ->leftJoin('deudas_notacredito as dno', 'sumanotas.idno', '=', 'dno.id')
        ->leftJoin('deudas_pagos as dpa', 'de.id', '=', 'dpa.deudas_id')
        ->leftJoin('formaspagos as frmpaabono', 'frmpaabono.id', '=', 'dab.formapago_id')
        ->leftJoin('formaspagos as frmpapago', 'frmpapago.id', '=', 'dpa.formapago_id')
        ->select(
            'de.id',
            'de.proveedor_id', 
            'de.numero_factura', 
            'de.documento_id', 
            'do.name as documento',
            'de.condicionespago_id', 
            'de.fecha_factura', 
            'de.fecha_pago', 
            'de.total_compra',
            'dno.numero as numnota', 
            'sumanotas.total_nota as totalpago_nota', 
            'dno.fecha_notacredito',
            'sumabonos.total_abonos as totalpago_abono', 
            'dab.id as idbonodes', 
            'dab.numero_recibo as numreciboabono', 
            'frmpaabono.name as formpagoabono', 
            'dab.numero as numabono', 
            'dab.fecha_abono',
            'dpa.total_pago as totalpago_pago', 
            'dpa.numero_recibo as numrecibopago', 
            'frmpapago.name as formpago', 
            'dpa.numero as numpago'
        )
      //  ->groupBy('dab.deudas_id')
        ->orderBy('dab.id', 'ASC')
        ->get();

        if($request->ajax()){
            return response()->json(view('deudas.partials.tblabonos', compact('data'))->render());
        }
    }

    public function showdeudas(){
        $sumaabonos = DB::table('deudas_abonos')
        ->select(DB::raw('MAX(id) as idabonos'),'deudas_id', DB::raw('SUM(total_pago) as total_abonos'))
        ->groupBy('deudas_id');

        $sumanotas = DB::table('deudas_notacredito as no')
        ->select(DB::raw('MAX(id) as idno'),'deudas_id', DB::raw('SUM(total_pago) as total_nota'))
        ->groupBy('deudas_id');

        $data = DB::table('deudas as de')
        ->join('documentos as do', 'de.documento_id', 'do.id')
        ->join('condicionespago as con', 'de.condicionespago_id', 'con.id')
        ->leftJoinSub($sumaabonos, 'sumabonos', function($join){
            $join->on('de.id', '=', 'sumabonos.deudas_id');
        })
        ->leftJoinSub($sumanotas, 'sumanotas', function($join){
            $join->on('de.id', '=', 'sumanotas.deudas_id');
        })
        ->leftJoin('deudas_abonos as dab', 'sumabonos.idabonos', '=', 'dab.id')
        ->leftJoin('deudas_notacredito as dno', 'sumanotas.idno', '=', 'dno.id')
        ->leftJoin('deudas_pagos as dpa', 'de.id', '=', 'dpa.deudas_id')
        ->leftJoin('formaspagos as frmpaabono', 'frmpaabono.id', '=', 'dab.formapago_id')
        ->leftJoin('formaspagos as frmpapago', 'frmpapago.id', '=', 'dpa.formapago_id')
        ->select(
            'de.id',
            'de.proveedor_id', 
            'de.numero_factura', 
            'de.documento_id', 
            'do.name as documento',
            'de.condicionespago_id', 
            'de.fecha_factura', 
            'de.fecha_pago', 
            'de.total_compra',
            'dno.numero as numnota', 
            'sumanotas.total_nota as totalpago_nota', 
            'dno.fecha_notacredito',
            'sumabonos.total_abonos as totalpago_abono', 
            'dab.id as idbonodes', 
            'dab.numero_recibo as numreciboabono', 
            'frmpaabono.name as formpagoabono', 
            'dab.numero as numabono', 
            'dab.fecha_abono',
            'dpa.total_pago as totalpago_pago', 
            'dpa.numero_recibo as numrecibopago', 
            'frmpapago.name as formpago', 
            'dpa.numero as numpago'
        )

        ->get();
        return $data;
    }
}
