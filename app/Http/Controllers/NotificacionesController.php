<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificaciones;
use Illuminate\Support\Facades\DB;
use App\Models\Notificacion_estados;
use Illuminate\Support\Facades\Auth;
class NotificacionesController extends Controller
{

    public function Notificaciones(Request $request){
        if(!empty($request->notificacion_id)) {
            $this->verificaEstadoNotifiacion($request->notificacion_id);
        }
        return view('notificaciones.index');
    }

    public function verificaEstadoNotifiacion($notificacion_id){
        $existNote = Notificacion_estados::where('notificacion_id', $notificacion_id)
            ->where('usuario_id', Auth::user()->id)
            ->exists();
        if($existNote){
            $id = [
                "notificacion_id" => $notificacion_id,
                "estado" => "VISTO"
            ];
        } else {
            $verified = Notificacion_estados::where('notificacion_id', $notificacion_id)
                ->where('usuario_id', Auth::user()->id)
                ->first();
            if($verified->estado != "VISTO") {
                Notificacion_estados::create([
                    'notificacion_id' => $request->notificacion_id,
                    'usuario_id' => Auth::user()->id,
                    'estado' => "VISTO",
                ]);
                $id = [
                    "notificacion_id" => $notificacion_id,
                    "estado" => "VISTO"
                ];
            }
        }
        return $id;
    }

    public function verMensaje($id, $notificacion_id){
        // registro_id ---> datos de factura para ver la data

        $this->verificaEstadoNotifiacion($notificacion_id);

        $precionew = DB::table('precios')
            ->select(
                DB::raw('MAX(id) as price_id'),
                'producto_id',
                DB::raw('MAX(created_at) as created_at'))
            ->groupBy('producto_id');

        $data = DB::table('stocks as stock')
            ->Join('detalle_stock as d_stock', 'd_stock.stocks_id', 'stock.id')
            ->join('manufacturers as man', 'stock.manufacturer_id', 'man.id')
            ->join('detalle_products as dp', 'stock.id', 'dp.stocks_id')
            ->JoinSub($precionew, 'precio', function($join){
                $join->on('stock.id', '=', 'precio.producto_id');
            })
            ->Join('precios as price', 'precio.price_id', 'price.id')
            ->select(
                'stock.id',
                'stock.code',
                'stock.name',
                'man.name as marca_name',
                'price.precioventa',
                'price.cambio',
                'dp.quantity',
            )
            ->where('d_stock.datosingresos_id', '=', $factura)
            ->get();
        return response()->json([$data], 200);
    }

   public function timeago($date) {
        $timestamp = strtotime($date);

        $strTime = array("segundo", "minuto", "hora", "dia", "mes", "año");
        $length = array("60","60","24","30","12","10");

        $currentTime = time();
        if($currentTime >= $timestamp) {
            $diff     = time()- $timestamp;
            for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
                $diff = $diff / $length[$i];
            }

            $diff = round($diff);
            return "Hace " . $diff . " " . $strTime[$i] . "(s)";
        }
    }
}
