<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductosAJAXController extends Controller
{
    public function index() {
        return view('productos.indextest');
    }

    public function loadproducts(Request $request) {
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
    $query->groupBy('sk.id');
    //  $query->orderBy($nameorder, $ordervali);
    $data = $query->paginate(25);
    if($request->ajax()){
        return response()->json(view('productos.components.tblproductos', compact('data'))->render());
    }

    }
}
