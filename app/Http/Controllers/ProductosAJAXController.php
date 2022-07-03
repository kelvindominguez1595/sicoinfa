<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sucursales;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductosAJAXController extends Controller
{
    public function index() {
        $almaceneslist = Sucursales::all();
        return view('productos.indextest', compact('almaceneslist'));
    }

    public function loadproducts(Request $request) {

        $orderby    = $request->orderby;
        $nameorder = $request->nameorder;
        // FRM
        $codigo     = $request->codigo;
        $codbarra   = $request->codbarra;
        $categoria  = $request->categoria;
        $marca      = $request->marca;
        $nombre     = $request->nombre;
        $almacen    = $request->almacen;
        $estado     = $request->estado;

        if (!empty($request->pages)) {
            $pages = $request->pages;
        } else {
            $pages = 25;
        }

        $oldprice = DB::table('detalle_stock')
        ->select( DB::raw('MAX(id) as iddstock'), 'stocks_id', DB::raw('MAX(created_at) as created_at'))
        ->groupBy('stocks_id');

        $precionew = DB::table('precios')
        ->select(DB::raw('MAX(id) as idprice'), 'producto_id', DB::raw('MAX(created_at) as created_at'))
        ->groupBy('producto_id');

        $cansum = DB::table('detalle_products')
        ->select('id as idsupro', 'branch_offices_id', 'stocks_id', DB::raw('SUM(quantity) as cantidadnew'))
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
            'sk.state',
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


        // busqueda por codigo
        if(!empty($codigo)){
            $query->where('sk.code', 'LIKE', '%' . $codigo . '%');
        }
        // busqueda por codigo de barra
        if(!empty($codbarra)){
            $query->where('sk.barcode', 'LIKE', '%'.$codbarra.'%');
        }
        // busqueda por categoria
        if(!empty($categoria)){
            $query->where('c.name', 'LIKE', '%'.$categoria.'%');
        }
        // busqueda por marca
        if(!empty($marca)){
            $query->where('man.name', 'LIKE', '%'.$marca.'%');
        }
        // busqueda por codigo
        if(!empty($nombre)){
            $query->where('sk.name', 'LIKE', '%'.$nombre.'%');
        }
        // por estados de productos

        if(empty($estado)) {
            $query->where('sk.state', '=', 1);
        } else {
            if($estado == "activos"){
                $query->where('sk.state', '=', 1);
            } else {
                $query->where('sk.state', '=', 0);
            }
        }
        // busqueda por almacen
        if(empty($almacen) || $almacen === "todos" ){ // esta vacio si lo esta debe agrupar todo
            $query->groupBy('sk.id');
        } else {
            $query->where('dp.branch_offices_id', '=', $almacen);
            $query->groupBy(
                'sk.id',
                'sk.image',
                'sk.code',
                'sk.barcode',
                'sk.name',
                'sk.exempt_iva',
                'sk.stock_min',
                'sk.description',
                'dp.quantity',
                'dp.branch_offices_id',
                'c.name',
                'man.name',
                'me.name',
                'sk.category_id',
                'sk.manufacturer_id');
        }

        if( empty($orderby) && empty($nameorder) ) {
            $query->orderBy("sk.code", "ASC");
        } else {
            $query->orderBy($nameorder, $orderby);
        }

        $data = $query->paginate($pages);
        if($request->ajax()){
            return response()->json([
                "data" => view('productos.components.tblproductos', compact('data'))->render(),
                "pagination" =>  view('productos.components.paginationtbl', compact('data'))->render()
            ], 200);
        }
    }

    public function loadlastproduct(Request $request) {
        $oldprice = DB::table('detalle_stock')
        ->select(DB::raw('MAX(id) as iddstock'), 'stocks_id', DB::raw('MAX(created_at) as created_at'))
        ->groupBy('stocks_id');

        $precionew = DB::table('precios')
        ->select(DB::raw('MAX(id) as idprice'), 'producto_id', DB::raw('MAX(created_at) as created_at'))
        ->groupBy('producto_id');

        $cansum = DB::table('detalle_products')
        ->select('id as idsupro', 'branch_offices_id', 'stocks_id', DB::raw('SUM(quantity) as cantidadnew'))
        ->groupBy('stocks_id');
        // obtenemos los ultiumos 5 productos registrados
        $data = DB::table('stocks as sk')
        ->leftJoinSub($oldprice, 'detallestock', function($join){
            $join->on('sk.id', '=', 'detallestock.stocks_id');
        })
        ->leftJoin('detalle_stock as detsto', 'detallestock.iddstock', 'detsto.id')
        ->leftJoinSub($precionew, 'precio', function($join){
            $join->on('sk.id', '=', 'precio.producto_id');
        })
        ->leftJoin('precios as price', 'precio.idprice', 'price.id')
        ->leftJoinSub($cansum, 'canprodu', function($join){
            $join->on('sk.id', '=', 'canprodu.stocks_id');
        })
        ->select(
            'sk.id',
            'sk.name',
            'sk.category_id',
            'sk.manufacturer_id',
            'detsto.invoice_number',
            'detsto.updated_at',
            'price.costosiniva',
            'canprodu.cantidadnew'
        )
        ->where('sk.state','=', 1)
        ->orderBy('sk.updated_at', 'DESC')
        ->take(5)
        ->get();
        if($request->ajax()){
            return response()->json(view('productos.components.tbllastproduct', compact('data'))->render(), 200);
        }
    }
}
