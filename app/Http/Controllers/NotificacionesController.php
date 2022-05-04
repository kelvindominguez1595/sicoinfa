<?php

namespace App\Http\Controllers;

use App\Models\Notificaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Notificacion_estados;
use Illuminate\Support\Facades\Auth;
class NotificacionesController extends Controller
{

    public function notify(Request $request)
    {
        $precionew = DB::table('precios')
            ->select(
                DB::raw('MAX(id) as price_id'),
                'producto_id',
                DB::raw('MAX(created_at) as created_at'))
            ->groupBy('producto_id');

        $data = [];

        $notyid = $request->notificacion_id;
        if (!empty($request->notificacion_id)) {
            $this->verificaEstadoNotifiacion($request->notificacion_id);
            $nt = Notificaciones::find($request->notificacion_id);

            $data = DB::table('stocks as stock')
                ->Join('detalle_stock as d_stock', 'd_stock.stocks_id', 'stock.id')
                ->join('manufacturers as man', 'stock.manufacturer_id', 'man.id')
                ->join('measures as me', 'stock.measures_id', 'me.id')
                ->join('detalle_products as dp', 'stock.id', 'dp.stocks_id')
                ->JoinSub($precionew, 'precio', function ($join) {
                    $join->on('stock.id', '=', 'precio.producto_id');
                })
                ->Join('precios as price', 'precio.price_id', 'price.id')
                ->select(
                    'stock.id',
                    'stock.code',
                    'stock.name',
                    'man.name as marca_name',
                    'me.name as medida_name',
                    'price.precioventa',
                    'price.cambio',
                    'dp.quantity',
                )
                ->where('d_stock.datosingresos_id', '=', $nt->registro_id)
                ->groupBy('stock.id')
                ->get();
        }

        $listNoti = Notificaciones::orderBy('created_at', 'DESC')->paginate(10);

        return view('notificaciones.index', compact('listNoti', 'data', 'notyid'));
    }

    public function verificaEstadoNotifiacion($notificacion_id){
        $existNote = Notificacion_estados::where('notificacion_id', $notificacion_id)
            ->where('usuario_id', Auth::user()->id)
            ->first();
        if(!empty($existNote->estado)) {
            $id = [
                "notificacion_id" => $notificacion_id,
                "estado" => "VISTO"
            ];
        }  else {
            Notificacion_estados::create([
                'notificacion_id' => $notificacion_id,
                'usuario_id' => Auth::user()->id,
                'estado' => "VISTO",
            ]);
            $id = [
                "notificacion_id" => $notificacion_id,
                "estado" => "VISTO"
            ];
        }
        return $id;
    }

}
