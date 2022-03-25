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
    public function guardar(Request $request){}
    public function editar(Request $request){}
    public function actualizar(Request $request){}
}
