<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Deudas;
use App\Models\Clientes;
use App\Models\Documentos;
use App\Models\FormasPagos;
use Illuminate\Http\Request;
use App\Models\DetalleDeudas;
use App\Models\CondicionesPagos;
use Illuminate\Support\Facades\DB;

class DeudasController extends Controller
{
    public function index(Request $request) {
        $formapago      = FormasPagos::all();
        $tipofactura    = Documentos::all();
        $condicion      = CondicionesPagos::all();
        return view('deudas.index', compact('formapago', 'tipofactura', 'condicion'));
    }

    public function listardeudas(Request $request) {
        $ddeuda = DB::table('detalle_deudas as dd')
        ->select(
            'dd.deudas_id',
            'dd.total_compra',
            'dd.formapago_id',
            'dd.fecha_abonopago',
            'dd.num_documento',
            'dd.num_recibo',
            DB::raw('SUM(dd.abono) as abono'),
            'dd.saldo',
            'dd.nota_credito',
            'dd.valor_nota',
            'dd.estado',
            'dd.pagototal',
        )->groupBy('dd.deudas_id');

        $data = DB::table('deudas as d')
        ->join('clientefacturas as cf', 'd.proveedor_id', '=', 'cf.id')
        ->join('documentos as doc', 'd.tipodocumento_id', '=', 'doc.id')
        ->join('condicionespago as c', 'd.estado', '=', 'c.id')
        ->joinSub($ddeuda, 'dd', function($join){
            $join->on('d.id', '=', 'dd.deudas_id');
        })
        ->leftJoin('formaspagos as fp', 'dd.formapago_id', '=', 'fp.id')
            ->select(
                'd.id',
                'd.proveedor_id',
                'd.fecha_factura',
                'd.numero_factura',
                'doc.name as tipofactura',
                'c.name as destado',
                'd.created_at',
                'd.updated_at',
                'dd.deudas_id',
                'dd.total_compra',
                'fp.name as formapago',
                'dd.fecha_abonopago',
                'dd.num_documento',
                'dd.num_recibo',
                'dd.abono',
                'dd.saldo',
                'dd.nota_credito',
                'dd.valor_nota',
                'dd.estado',
                'dd.pagototal',
            )
            ->orderBy('d.fecha_factura', 'DESC')
            ->paginate(10);

            if($request->ajax()){
                return response()->json(view('deudas.partials.tblabonos', compact('data'))->render());
            }
    }

    public function deudas_abonos($id){
        $formapago      = FormasPagos::all();
        $tipofactura    = Documentos::all();
        $condicion      = CondicionesPagos::all();
        return view('deudas.pagosEdit', compact('formapago', 'tipofactura', 'condicion'));
    }

    public function savefactura(Request $request){
    
        $resdeudas = Deudas::create([
            'proveedor_id'      => $request['proveedor'],
            'fecha_factura'     => $request['fechafacturado'],
            'numero_factura'    => $request['numerofactura'],
            'tipodocumento_id'  => $request['tipofactura'],
            'estado'            => $request['estado'],
        ]);
 
       DetalleDeudas::create([
           'deudas_id'         => $resdeudas->id,
           'total_compra'      => $request['totalcompra'],
           'formapago_id'      => $request['formapago'],
           'fecha_abonopago'   => $request['fechapago'],
           'num_documento'     => $request['numerocheque'],
           'num_recibo'        => '',
           'abono'             => 0,
           'saldo'             => 0,
           'nota_credito'      => '',
           'valor_nota'        => 0,
           'estado'            => $request['estado'],
           'pagototal'         => 0
       ]);

        /*
            foreach ($request['proveedor_id'] as $key => $value){
                $deudas = Deudas::create([
                    'proveedor_id'      => $request['proveedor_id'][$key],
                    'fecha_factura'     => $request['fecha_factura'][$key],
                    'numero_factura'    => $request['numero_factura'][$key],
                    'tipo_factura'      => $request['tipo_factura'][$key],
                    'estado'            => $request['estado'][$key]
                ]);
                DetalleDeudas::create([
                    'deudas_id'         => $deudas->id,
                    'total_compra'      => $request['total_compra'][$key],
                    'forma_pago'        => $request['forma_pago'][$key],
                    'fecha_abonopago'   => $request['fecha_abonopago'][$key],
                    'num_documento'     => $request['num_documento'][$key],
                    'num_recibo'        => $request['num_recibo'][$key],
                    'abono'             => $request['abono'][$key],
                    'saldo'             => $request['saldo'][$key],
                    'nota_credito'      => $request['nota_credito'][$key],
                    'valor_nota'        => $request['valor_nota'][$key],
                    'estado'            => $request['estado'][$key],
                    'pagototal'         => $request['pagototal'][$key]
                ]);
            }
        */

        return response()->json(["message", "success"], 200);
    }

    public function editar($id){
        $deudas = Deudas::find($id);
        $proveedor = Clientes::find($deudas->proveedor_id);
        $ddeudas = DetalleDeudas::where('deudas_id', $id)->get();
        $lastrow = DetalleDeudas::where('deudas_id', $id)
            ->take(1)
            ->get();
        $countrow = $ddeudas->count();
        return response()->json([
            "deudas"    => $deudas,
            "ddeudas"   => $ddeudas,
            "dlast"      => $lastrow,
            "countdeudas" => $countrow,
            "proveedor" => $proveedor
        ],200);
    }

    public function actualizar(Request $request){}

    public function addModdate($date) {
        $res = Carbon::parse($date)->addDays(30);
        return response()->json(['dateforma' => $res->format('Y-m-d')], 200);
    }

    public function dateNow(){
        $date = Carbon::now();
        return response()->json(['dateforma' => $date->format('Y-m-d')], 200);
    }
}
