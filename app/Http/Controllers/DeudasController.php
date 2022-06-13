<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Deudas;
use App\Models\Clientes;
use App\Models\Documentos;
use App\Models\FormasPagos;
use Illuminate\Http\Request;
use App\Models\DeudasNotaCredito;
use App\Models\DeudasPagoAbonos;
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
        DeudasPagoAbonos::create([
            'deudas_id' =>  $request->deudas_idpago,
            'total_pago' =>  $request->totalpagoshow == '' ? 0 : $request->totalpagoshow,
            'numero_recibo' => $request->numeropago,
            'formapago_id' =>  $request->formapago_idpago,
            'numero' => $request->numerochequepago,
            'condicionespago_id' => $request->condicionespago_id,
            'fecha_abono' => '0000-00-00',
        ]);
        return response()->json(['message' => 'ok'], 200);
    }

    public function abonos(Request $request){
        DeudasPagoAbonos::create([
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
        $data = Deudas::find($id);
        return response()->json($data);
    }
}
