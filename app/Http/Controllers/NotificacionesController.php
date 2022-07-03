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


    public function detalleProductoNotificaction($id) {

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
            DB::raw('MAX(created_at) as created_at')
            )
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
            'c.name as category_name',
            'man.name as marca_name',
            'me.name as medida_name',
            'sk.category_id',
            'sk.manufacturer_id',
            'detsto.created_at as dtellastock',
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
    $query->where('sk.id', '=', $id);
    $query->groupBy('sk.id');
    $data = $query->first();

    $ruta = public_path()."/images/productos/";
    $image =  $data->image;
    $pathrouter = $ruta.$image;
    $exist = false;
    if(!empty($image)){
        if(file_exists($pathrouter)){
            $exist = true;
        } else {
            $exist = false;
        }
    } else {
        $exist = false;
    }
    return response()->json([
        "data" => $data,
        "image" => "/images/productos/".$image,
        "existimage" => $exist
    ], 200);

}

}
