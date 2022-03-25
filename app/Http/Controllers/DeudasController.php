<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deudas;
use App\Models\DetalleDeudas;
use phpDocumentor\Reflection\Utils;

class DeudasController extends Controller
{
    public function index(Request $request){
        return view('deudas.index');
    }
    public function create(){
        $tipofactura  = [
            "CREDITO", "CONTADO", "CCF", "N/CREDITO", "FACTURA"
        ];
        $formapago = [
            "CHEQUE", "REMESA", "EFECTIVO", "DEPOSITO"
        ];
        return view('deudas.create', compact('tipofactura', 'formapago'));
    }
    public function guardar(Request $request){
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
        return response()->json(["message", "success"], 200);
    }
    public function editar(Request $request){}
    public function actualizar(Request $request){}
}
