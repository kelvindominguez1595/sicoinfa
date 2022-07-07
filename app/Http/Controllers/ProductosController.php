<?php

namespace App\Http\Controllers;

use App\Models\Marcas;
use App\Models\Precios;
use App\Models\Ingresos;
use App\Models\Almacenes;
use App\Models\Productos;
use App\Models\Sucursales;
use App\Models\Categorias;
use App\Models\Proveedores;
use Illuminate\Http\Request;
use App\Models\DetalleIngreso;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Unidaddemedidas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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
        $ordertitleres = '';

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
            if($orderby === 'ASC'){
                $ordertitleres = 'DESC';
            } else {
                $ordertitleres = 'ASC';
            }
            $query->orderBy($nameorder, $orderby);
        }
        $data = $query->paginate($pages);

        // obtenemos los ultiumos 5 productos registrados
        $ultimoPro = DB::table('stocks as sk')
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
            'canprodu.cantidadnew',)
        ->where('sk.state','=', 1)
        ->orderBy('sk.updated_at', 'DESC')
        ->take(5)
        ->get();

        $almaceneslist = Sucursales::all();
        return view('productos.index', compact(
        'data',
        'estado',
        'codigo',
        'codbarra',
        'categoria',
        'marca',
        'nombre',
        'almacen',
        'pages',
        'almaceneslist',
        'ultimoPro',
        'orderby',
        'nameorder',
        'ordertitleres'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('productos.nuevo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $exento = 0;
        if(!empty($request->exentoiva)){
            $exento = 1;
        }
        $request->validate([
            'code' => 'required|unique:stocks|max:255',
        ]);

        $data = new Productos();
        if($request->hasFile("imagen")){
            $imagen = $request->file("imagen");
            $nombreimagen = time().".".$imagen->guessExtension();
            $ruta = public_path()."/images/productos/";
            $imagen->move($ruta,$nombreimagen);
            $data->image =  $nombreimagen;
        }
        $data->code = $request->code;
        $data->barcode = $request->codigobarra;
        $data->name = $request->nombre;
        $data->exempt_iva = $exento;
        $data->stock_min = 1;
        $data->state = 1;
        $data->category_det = $request->category_det;
        $data->reference_det = $request->reference_det;
        $data->manufacturer_id = $request->marca;
        $data->category_id = $request->categoria;
        $data->measures_id = $request->medidas;
        $data->save();
        // debo guardar en almacen
        $sucursal = new Almacenes();
        $sucursal->stock_min = 1;
        $sucursal->quantity = 0;
        $sucursal->branch_offices_id = 1;
        $sucursal->stocks_id = $data->id;
        $sucursal->save();
        // return redirect()->route('actualizaringresos', [$data->id, 1]);
        return response()->json(["message" => "Nuevo producto Registrado", "productoid" => $data->id, "sucursal" => 1]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function show(Productos $productos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $sucursalid)
    {
        $stock = Productos::where('id', $id)->first();
        // obtendre el ultimo registro de ingreso
        $ultimoingreso = Ingresos::where('stocks_id', $id)
            ->limit(1)
            ->orderBy('id','DESC')
            ->first();

        $detalle_pro = Almacenes::where('branch_offices_id', $sucursalid)->where('stocks_id', $id)->first();
        $almacenes = Sucursales::all();
        $promedio = Ingresos::where('stocks_id', '=', $id)->get();
        return view('productos.actualizar', compact('stock',  'id','detalle_pro', 'almacenes', 'promedio', 'ultimoingreso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Request  $request
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // esto para actualizar los datos de los productos
        $data = Productos::find($id);
        $data->category_id      = $request->category_id;
        $data->manufacturer_id  = $request->manufacturer_id;
        $data->code             = $request->code;
        $data->measures_id      = $request->measures_id;
        $data->barcode          = $request->barcode;
        $data->category_det     = $request->category_det;
        $data->name             = $request->name;
        $data->reference_det    = $request->reference_det;
        $data->description      = $request->editor;
        $data->stock_min        = $request->stock_min_pro;
        $data->state            = $request->state;
        $data->exempt_iva       = $request->exempt_iva;

        if($request->hasFile("imagen")){
            $imagen = $request->file("imagen");
            $nombreimagen = time().".".$imagen->guessExtension();
            $ruta = public_path()."/images/productos/";
            $imagen->move($ruta,$nombreimagen);
            $data->image =  $nombreimagen;
        }
        $data->save();
        $updatedate = date('Y-m-d H:m:s');
        DB::table('detalle_products')
            ->where('branch_offices_id',  $request->alidsucursal)
            ->where('stocks_id', $id)
            ->update([

                'quantity' => $request->stock_min_pro,
                'updated_at' => $updatedate
            ]);
        $costosiniva = $request->cost_s_iva;
        $costoconiva = $request->cost_c_iva;
        $ganancia = $request->earn_c_iva;
        $porcentaje = $request->earn_porcent;
        $preciventa = $request->sale_price;

        $precios = $this->validarPrecio($id);
        if( $costosiniva == 0 || $costosiniva == '' ){
            $resprice = Precios::create([
                'producto_id'   => $id,
                'costosiniva'   => $costosiniva,
                'costoconiva'   => $costoconiva,
                'ganancia'      => $ganancia,
                'porcentaje'    => $porcentaje,
                'precioventa'   => $preciventa,
                'cambio'        => 'Solo precio venta',
            ]);
        } else {
               $resprice =  Precios::create([
                    'producto_id'   => $id,
                    'costosiniva'   => $costosiniva,
                    'costoconiva'   => $costoconiva,
                    'ganancia'      => $ganancia,
                    'porcentaje'    => $porcentaje,
                    'precioventa'   => $preciventa,
                    'cambio'        => 'actualizado',
                ]);
        }
        return response()->json(["message" =>  "succes", "precio" => $precios, "data" => $data, "price" => $resprice], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Productos  $productos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Productos $productos)
    {
        //
    }

    // listar proveedores
    public function proveedores(Request $request) {
        if($request->ajax()){
            $term = trim($request->term);
            $suppliers = Proveedores::select('id', 'nombre_comercial as text')
                ->where('state', 1)
                ->where('nombre_comercial', 'LIKE', '%' . $term . '%')
                ->where('tipo_cliente', 3)
                ->orderBy('nombre_comercial', 'ASC')
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
    // listar categorias
    public function categorias(Request $request) {
        if($request->ajax()) {
            $term = trim($request->term);
            $category = Categorias::select('id', 'name as text')
                ->where('state', 1)
                ->where('name', 'LIKE', '%' . $term . '%')
                ->orderBy('name', 'ASC')
                ->simplePaginate(10);

            $morePages = true;
            if (empty($category->nextPageUrl())) {
                $morePages = false;
            }
            $results = array(
                "results" => $category->items(),
                "pagination" => array(
                    "more" => $morePages,
                ),
            );
            return response()->json($results);
        }
    }
    // listar marcas
    public function marcas(Request $request) {
        if($request->ajax()) {
            $term = trim($request->term);
            $manufacturer = Marcas::select('id', 'name as text')
                ->where('state', 1)
                ->where('name', 'LIKE', '%' . $term . '%')
                ->orderBy('name', 'ASC')
                ->simplePaginate(10);

            $morePages = true;
            $pagination_obj = json_encode($manufacturer);
            if (empty($manufacturer->nextPageUrl())) {
                $morePages = false;
            }
            $results = array(
                "results" => $manufacturer->items(),
                "pagination" => array(
                    "more" => $morePages,
                ),
            );
            return response()->json($results);
        }
    }
    // listar categorias DET
    // Listar Libros DET
    // Listar sucursales
    public function sucursales(Request $request) {
        if ($request->ajax()) {
            $term = trim($request->term);
            $manufacturer = Sucursales::select('id', 'name as text')
                ->where('name', 'LIKE', '%' . $term . '%')
                ->orderBy('name', 'ASC')
                ->simplePaginate(10);

            $morePages = true;
            $pagination_obj = json_encode($manufacturer);
            if (empty($manufacturer->nextPageUrl())) {
                $morePages = false;
            }
            $results = array(
                "results" => $manufacturer->items(),
                "pagination" => array(
                    "more" => $morePages,
                ),
            );
            return response()->json($results);
        }
    }
    // Listar unidad de Medida
    public function unidaddenedida(Request $request) {
        if($request->ajax()) {
            $term = trim($request->term);
            $manufacturer = Unidaddemedidas::select('id', 'name as text')
                ->where('name', 'LIKE', '%' . $term . '%')
                ->orderBy('name', 'ASC')
                ->simplePaginate(10);

            $morePages = true;
            if (empty($manufacturer->nextPageUrl())) {
                $morePages = false;
            }
            $results = array(
                "results" => $manufacturer->items(),
                "pagination" => array(
                    "more" => $morePages,
                ),
            );
            return response()->json($results);
        }
     }
    // listar productos
    public function listarproductos(Request $request) {
        if($request->ajax()) {
            $term = trim($request->term);
            $data = DB::table('stocks as s')
                ->join('categories as c', 's.category_id', '=', 'c.id')
                ->join('manufacturers as ma', 's.manufacturer_id', '=', 'ma.id') // esta es la marca
                ->join('measures as me', 's.measures_id', '=', 'me.id') // esta es la unidad de medida
                ->select('s.id', 's.name as text', 'c.name as categoria', 'ma.name as marca', 'me.name as unidademedida')
                ->where('s.name', 'LIKE', '%' . $term . '%')
                ->where('s.state', '=', 1)
                ->orderBy('s.code', 'ASC')
                ->simplePaginate(10);
            $morePages = true;
            if (empty($data->nextPageUrl())) {
                $morePages = false;
            }
            $results = array(
                "results" => $data->items(),
                "pagination" => array(
                    "more" => $morePages,
                ),
            );
            return response()->json($results);
        }
    }
    // buscar id
    public function productoid($id){
        $data = DB::table('stocks as s')
            ->join('categories as c', 's.category_id', '=', 'c.id')
            ->join('manufacturers as ma', 's.manufacturer_id', '=', 'ma.id') // esta es la marca
            ->join('measures as me', 's.measures_id', '=', 'me.id') // esta es la unidad de medida
            ->select('s.id', 's.name as text', 'c.name as categoria', 'ma.name as marca', 'me.name as unidademedida')
            ->where('s.id', '=', $id)
            ->where('s.state', '=', 1)
            ->orderBy('s.code', 'ASC')
            ->first();
        return response()->json($data);
    }
     // buscar por id
    public function categoriasid($id) {
        $data = Categorias::find($id);
        return response()->json($data);
    }

    public function marcasid($id) {
        $data = Marcas::find($id);
        return response()->json($data);
    }

    public function proveedoresid($id) {
        $data = Proveedores::find($id);
        return response()->json($data);
    }

    public function unidadmedidaid($id) {
        $data = Unidaddemedidas::find($id);
        return response()->json($data);
    }

    public function sucursalid($id) {
        $data = Sucursales::find($id);
        return response()->json($data);
    }

    public function existenciaProducto($id){
        $data = DB::table('stocks as sk')
            ->leftJoin('categories as c', 'sk.category_id', 'c.id')
            ->leftJoin('manufacturers as man', 'sk.manufacturer_id', 'man.id')
            ->leftJoin('measures as me', 'sk.measures_id', 'me.id')
            ->leftJoin('detalle_products as dp', 'sk.id', 'dp.stocks_id')
            ->join('branch_offices as bo', 'dp.branch_offices_id', 'bo.id')
            ->select(
                'sk.id',
                'bo.name',
                'dp.quantity',
                'dp.branch_offices_id',
                'dp.updated_at'
            )
            ->where('sk.state', '=', 1)
            ->where('sk.id','=', $id)
            ->groupBy(
                'sk.id',
                'bo.name',
                'dp.quantity',
                'dp.branch_offices_id',
                'dp.updated_at')
            ->orderBy('sk.code', 'ASC')
            ->get();
        return response()->json($data);
    }

    public function transferencia(Request $request){
        $desde = $request->desde;
        $hasta = $request->hasta;
        $cantidad = $request->cantidadtransferrer;
        $stockid = $request->stockid;
        /** message y codigo*/
        $message = "";
        $code = "";
        /**
         * ---------------------------------------------------------------
         * Debo verificar que la sucusarl este creado el producto caso contrario debo de crearlo
         */
        $desdeverify = Almacenes::where('branch_offices_id', $desde)->where('stocks_id', $stockid)->exists();
        $hastaverify = Almacenes::where('branch_offices_id', $hasta)->where('stocks_id', $stockid)->exists();

        if(!$desdeverify) {
            Almacenes::create([
                   'stock_min' => 1,
                   'quantity' => 0,
                   'branch_offices_id' => $desde,
                   'stocks_id' => $stockid,
               ]);
        }
       if(!$hastaverify) {
             Almacenes::create([
                 'stock_min' => 1,
                 'quantity' => 0,
                 'branch_offices_id' => $hasta,
                 'stocks_id' => $stockid,
             ]);
        }

            // verificar que la cantidad en la sucursal sea mayor a 0
            $almacendesde = Almacenes::where('branch_offices_id', $desde)->where('stocks_id', $stockid)->first();
            $almacenhasta = Almacenes::where('branch_offices_id', $hasta)->where('stocks_id', $stockid)->first();
            if($almacendesde->quantity == 0 ) {
                $message = "No hay suficiente productos en inventario";
                $code = 400;
            } else {
                if($cantidad > $almacendesde->quantity) {
                    $message = "La cantidad a trasladar es mayor a la de inventarios";
                    $code = 400;
                } else {

                    // esto es para descontar los produtos de donde se envio
                    $cantidaddescuento = $almacendesde->quantity - $cantidad;
                    // buscamos el origin de envio
                    $updatedesde = Almacenes::find($almacendesde->id);
                    $updatedesde->quantity = $cantidaddescuento;
                    $updatedesde->save();
                    /** --------------------------------------------------------------- */
                    // esto es para actualizar el producto hasta donde se envia
                    $cant =  $cantidad + $almacenhasta->quantity;
                    // destino final de envio
                    $updatehasta = Almacenes::find($almacenhasta->id);
                    $updatehasta->quantity = $cant;
                    $updatehasta->save();
                    $message = "Traslado realizado correctamente";
                    $code = 200;
                }
            }
            return response()->json(["message"=> $message], $code);

    }

    // para realizar los ajustes
    public function ajusteproducto(Request $request) {
        $detalle_producto = '';
        foreach ($request['update_quantity'] as $key => $value) {
            if (is_null($request['update_quantity'][$key])) {
                # code...
            } else {
                $quantity = 0;
                $valor = 0;
                $detalle_pro = Almacenes::where('stocks_id', $request['idProducto'][$key])->first();

                $valor = $request['update_quantity'][$key];
                $quantity = $detalle_pro->quantity + $valor;

                $detalle_producto =  Almacenes::find($detalle_pro->id);
                $detalle_producto->quantity = $quantity;
                $detalle_producto->save();
            }
         }
         return response()->json(['detalle_producto' => $detalle_producto]);
    }

    // para ver el historial de compras realizadas recientemente
    public function historialcompras(Request $request){

        $subds = DB::table('detalle_stock')
            ->select(
                DB::raw('MAX(id) as iddstock'),
                'stocks_id',
                DB::raw('MAX(created_at) as created_at'))
            ->groupBy('stocks_id');

        $precionew = DB::table('precios')
            ->select('id as idprice', 'producto_id', 'costosiniva', 'costoconiva', 'ganancia', 'porcentaje', 'precioventa', 'cambio', 'updated_at', DB::raw('MAX(created_at) as created_at'))
            ->groupBy('producto_id');

        $cansum = DB::table('detalle_products')
            ->select('id as idsupro', 'branch_offices_id', 'stocks_id', DB::raw('SUM(quantity) as cantidadnew'))
            ->groupBy('stocks_id');

        $codigo     = $request->codigo;
        $codbarra   = $request->codbarra;
        $categoria  = $request->categoria;
        $marca      = $request->marca;
        $nombre     = $request->nombre;
        $almacen    = $request->almacen;
        $orderby    = $request->orderby;
        $estado     = $request->estado;

        $proveedor     = $request->proveedor;
        $credito    = $request->credito;
        $desde    = $request->desde;
        $hasta     = $request->hasta;

        if (!empty($request->pages)) {
            $pages = $request->pages;
        } else {
            $pages = 25;
        }

        $query = DB::table('stocks as sk')
            ->join('categories as c', 'sk.category_id', 'c.id')
            ->join('manufacturers as man', 'sk.manufacturer_id', 'man.id')
            ->join('measures as me', 'sk.measures_id', 'me.id')
            ->leftJoinSub($subds, 'detallestock', function($join){
                $join->on('sk.id', '=', 'detallestock.stocks_id');
            })
            ->leftJoin('detalle_stock as detsto', 'detallestock.iddstock', 'detsto.id')
            ->leftJoin('detalle_price as dp', 'detallestock.iddstock', 'dp.id')
            ->leftJoinSub($precionew, 'precio', function($join){
                $join->on('sk.id', '=', 'precio.producto_id');
            })
            ->leftJoinSub($cansum, 'canprodu', function($join){
                $join->on('sk.id', '=', 'canprodu.stocks_id');
            })
            ->leftJoin('branch_offices as sucur', 'canprodu.branch_offices_id', 'sucur.id')
            ->leftJoin('clientefacturas as pro', 'pro.id', '=', 'detsto.clientefacturas_id')
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
                'precio.costosiniva',
                'precio.costoconiva',
                'precio.ganancia',
                'precio.porcentaje',
                'precio.precioventa',
                'precio.cambio',
                'canprodu.cantidadnew',
                'sucur.name as sucursal',
                'pro.cliente',
                'pro.nit',
            );

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

        //por estados de productos
        if (!empty($request->estado)) {
            $estado = $request->estado;
            if($estado == "activos"){
                $query->where('sk.state', '=', 1);
            } else {
                $query->where('sk.state', '=', 0);
            }
        }

        // busqueda por almacen
        if(empty($almacen) || $almacen == "todos" ){ // esta vacio si lo esta debe agrupar todo
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

        if(!empty($credito)){
            $query->where('detsto.invoice_number', 'LIKE', '%'.$credito.'%');
        }

        if(!empty($proveedor)){
            $query->where('pro.cliente', 'LIKE', '%'.$proveedor.'%');
        }

        if(!empty($desde) AND !empty($hasta)){
            $query->whereBetween('detsto.created_at', [$desde, $hasta]);
        }

        $query->orderBy('detsto.created_at', 'DESC');

        // ver los almacenes
        $almaceneslist = Sucursales::all();
        $date = date('d-m-Y-s');
        $code = generarCodigo(4);
        if($request['report'] == 'PDF'){
            $data = $query->get();
            $pdf = PDF::loadView('reportes.template.historialdeComprasPDF', compact('data', 'date'))->setPaper('legal', 'landscape');
            set_time_limit(300);
            return $pdf->download('Reporte-Historial-'.$code.'.pdf');
        } else if($request['report'] == 'excel'){
            $data = $query->get();
            $this->reporteHistorialExcel($data);
        } else{
            $data = $query->paginate($pages);
            return view('productos.historicocompras',  compact('data',
                'codigo',
                'codbarra',
                'categoria',
                'marca',
                'nombre',
                'almacen',
                'orderby',
                'estado',
                'pages',
                'almaceneslist',
                'proveedor',
                'credito',
                'desde',
                'hasta'
            ));
        }
    }

    // function para validar los precios
    public function validarPrecio($id){
        $buscarprecio = Precios::where('producto_id', '=', $id)->exists();
        if($buscarprecio){
            // si el precio nuevo existe tomaremos los datos de esta nueva tabla
            $precio = Precios::where('producto_id', $id)
                ->limit(1)
                ->orderBy('id','DESC')
                ->first();
        } else {
            // en caso que no exista tomaremos el precio ultimo registrado
            $exisingreso = Ingresos::where('stocks_id', '=', $id)
                ->limit(1)
                ->orderBy('id','DESC')
                ->exists();
            if($exisingreso){
                $precioviejoingreso = Ingresos::where('stocks_id', $id)
                    ->limit(1)
                    ->orderBy('id','DESC')
                    ->first();
                $exist = DetalleIngreso::where('detalle_stock_id', '=', $precioviejoingreso->id)->exists();
                if($exist){
                    $precioviejo = DetalleIngreso::where('detalle_stock_id', '=', $precioviejoingreso->id)->first();
                } else {
                    $precioviejo = "";
                    $costosiniva    = 0;
                    $costoconiva    = 0;
                    $ganancia       = 0;
                    $porcentaje     = 0;
                    $precioventa    = 0;
                }

            }else{
                $precioviejo = "";
                $costosiniva    = 0;
                $costoconiva    = 0;
                $ganancia       = 0;
                $porcentaje     = 0;
                $precioventa    = 0;
            }
        }

        if(!empty($precio)) {
            // datos precio nuevo
            $costosiniva    = $precio->costosiniva;
            $costoconiva    = $precio->costoconiva;
            $ganancia       = $precio->ganancia;
            $porcentaje     = $precio->porcentaje;
            $precioventa    = $precio->precioventa;
        }
        if(!empty($precioviejo)) {
            // datos precio viejo
            $costosiniva    = $precioviejo->cost_s_iva;
            $costoconiva    = $precioviejo->cost_c_iva;
            $ganancia       = $precioviejo->earn_c_iva;
            $porcentaje     = $precioviejo->earn_porcent;
            $precioventa    = $precioviejo->sale_price;
        }
        if(!empty($precioviejo) && !empty($precio)){
            // si el producto es nuevo no existaran precios asi que es cero
            $costosiniva    = 0;
            $costoconiva    = 0;
            $ganancia       = 0;
            $porcentaje     = 0;
            $precioventa    = 0;
        }

        $params = array(
            "costosiniva"   => $costosiniva,
            "costoconiva"   => $costoconiva,
            "ganancia"      => $ganancia,
            "porcentaje"    => $porcentaje,
            "precioventa"   => $precioventa
        );
        return $params;
    }

    public function getItemProducts($id, $sucursalid){
        $detalle_pro = Almacenes::where('branch_offices_id', $sucursalid)->where('stocks_id', $id)->first();
        $stock = Productos::where('id', $id)->first();
        return response()->json(["stock" => $stock, "almacen" => $detalle_pro],200);
    }

    // buscar productos ingreso de factura
    public function buscarProductosIngreso(Request $request)
    {
        if($request->ajax()) {
            $codigosearch     = $request->codigosearch;
            $categoriasearch  = $request->categoriasearch;
            $marcasearch      = $request->marcasearch;
            $productosearch   = $request->productosearch;
            $estado           = $request->estado;
            if($request->type == "update"){
                if($estado == 1){
                    $estado = 0;
                } else {
                    $estado = 1;
                }
                $up = Productos::find($request->id);
                $up->state = $estado;
                $up->save();
            }
            $query = DB::table('stocks as sk')
                ->join('categories as c', 'sk.category_id', 'c.id')
                ->join('manufacturers as man', 'sk.manufacturer_id', 'man.id')
                ->join('measures as me', 'sk.measures_id', 'me.id')
                ->join('detalle_products as dp', 'sk.id', 'dp.stocks_id')
                ->join('branch_offices as bo', 'dp.branch_offices_id', 'bo.id')
                ->select(
                    'sk.id',
                    'sk.image',
                    'sk.code',
                    'sk.barcode',
                    'sk.name',
                    'sk.exempt_iva',
                    'sk.stock_min',
                    'sk.description',
                    'sk.state',
                    'c.name as category_name',
                    'man.name as marca_name',
                    'me.name as medida_name',
                    'sk.category_id',
                    'sk.manufacturer_id',
                    'bo.name as sucursal'
                );

            // busqueda por codigo
            if(!empty($codigosearch)){
                $query->where('sk.code', 'LIKE', '%' . $codigosearch . '%');
            }

            // busqueda por categoria
            if(!empty($categoriasearch)){
                $query->where('c.name', 'LIKE', '%'.$categoriasearch.'%');
            }
            // busqueda por marca
            if(!empty($marcasearch)){
                $query->where('man.name', 'LIKE', '%'.$marcasearch.'%');
            }
            // busqueda por producto
            if(!empty($productosearch)){
                $query->where('sk.name', 'LIKE', '%'.$productosearch.'%');
            }
            $query->where('sk.state', '=', $estado);
            // por estados de productos
            $query->groupBy('sk.id');
            // busqueda por almacen

            $data = $query->paginate(15);

            //return $data;
            return response()->json(view('ingresos.partials.searchTable',
                compact('data',
                'codigosearch',
                'categoriasearch',
                'marcasearch',
                'productosearch',
                'estado',
            ))->render());
        }
    }

    public function reporteHistorialExcel($data){
        $username = Auth::user()->name;

        $spreadsheet = new Spreadsheet();
        $write = new Xlsx($spreadsheet);

        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()
            ->setCreator(dataTitlesExcel()['creador'])
            ->setLastModifiedBy($username)
            ->setTitle(dataTitlesExcel()['titlereportepro'])
            ->setSubject(dataTitlesExcel()['titlereportepro'])
            ->setDescription(dataTitlesExcel()['descripcionpro'])
            ->setKeywords('Reportes')
            ->setCategory(dataTitlesExcel()['titlereportepro']);

        $sheet->setCellValue('A1', 'CÓDIGO');
        $sheet->setCellValue('B1', 'CATEGORÍA');
        $sheet->setCellValue('C1', 'MARCA');
        $sheet->setCellValue('D1', 'PRODUCTO');
        $sheet->setCellValue('E1', 'PROVEEDOR');
        $sheet->setCellValue('F1', 'CANTIDAD');
        $sheet->setCellValue('G1', 'U. DE MEDIDA');
        $sheet->setCellValue('H1', 'P. UNI. SIN IVA');
        $sheet->setCellValue('I1', 'P. UNI. CON IVA');
        $sheet->setCellValue('J1', 'ALMACÉN');
        $sheet->setCellValue('K1', 'FECHA INGRESO');
        $sheet->setCellValue('L1', 'CRÉDITO FISCAL');
        $sheet->setCellValue('M1', 'FECHA FACTURA');

        $i = 2;
        foreach($data as $item) {
            $sheet->setCellValue('A'.$i, $item->code);
            $sheet->setCellValue('B'.$i, $item->category_name);
            $sheet->setCellValue('C'.$i, $item->marca_name);
            $sheet->setCellValue('D'.$i, $item->name);
            $sheet->setCellValue('E'.$i, $item->cliente);
            $sheet->setCellValue('F'.$i, $item->cantidadnew);
            $sheet->setCellValue('G'.$i, $item->medida_name);
            if(isset($item->costosiniva)){
                $costsiniva = number_format($item->costosiniva, 4);
                $costconiva = number_format($item->costoconiva, 4);
            } else {
                $costsiniva = number_format($item->cost_s_iva, 4);
                $costconiva = number_format($item->cost_c_iva, 4);
            }
            $sheet->setCellValue('H'.$i, $costsiniva);
            $sheet->setCellValue('I'.$i, $costconiva);

            $sheet->setCellValue('J'.$i, $item->sucursal);
            $sheet->setCellValue('K'.$i, date('d-m-Y h:i:s A', strtotime($item->fechaingreso)));
            $sheet->setCellValue('L'.$i, $item->nit);
            $sheet->setCellValue('M'.$i, date('d-m-Y', strtotime($item->fechafactura)));
            $i++;
        }
        $code = generarCodigo(4);
        $filename = 'historial-compras-'.$code.'.xlsx';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename='. $filename);
        header('Cache-Control: max-age=0');

        $write->save('php://output');
        exit();
    }




}
