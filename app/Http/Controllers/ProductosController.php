<?php

namespace App\Http\Controllers;

use App\Models\Almacenes;
use App\Models\Categorias;
use App\Models\Ingresos;
use App\Models\Marcas;
use App\Models\Precios;
use App\Models\Productos;
use App\Models\Proveedores;
use App\Models\Unidaddemedidas;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Sucursales;
use App\Http\Requests\StoreProductosRequest;
use App\Http\Requests\UpdateProductosRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // para filtrar por paginas
        $pages = 25;
        $estado = "activos";

        $codigo = $request->codigo;
        $codbarra = $request->codbarra;
        $categoria = $request->categoria;
        $marca = $request->marca;
        $nombre = $request->nombre;
        $almacen = $request->almacen;


        if (!empty($request->pages)) {
            $pages = $request->pages;
        } else {
            $pages = 25;
        }
        // si hay algun dato en una de las viarbales realizar la busqueda
        if(
            !empty($codigo) OR
            !empty($codbarra) OR
            !empty($categoria) OR
            !empty($marca) OR
            !empty($nombre) OR
            !empty($almacen) OR
            !empty($request->estado)){
            $query = DB::table('stocks as sk')
                ->leftJoin('categories as c', 'sk.category_id', 'c.id')
                ->leftJoin('manufacturers as man', 'sk.manufacturer_id', 'man.id')
                ->leftJoin('measures as me', 'sk.measures_id', 'me.id')
                ->leftJoin('detalle_products as dp', 'sk.id', 'dp.stocks_id')
                ->select(
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
                    'c.name as category_name',
                    'man.name as marca_name',
                    'me.name as medida_name',
                    'sk.category_id',
                    'sk.manufacturer_id',
                    DB::raw('(SELECT ds.id  FROM detalle_stock AS ds WHERE ds.stocks_id = sk.id  ORDER BY ds.created_at DESC LIMIT 1) as iddetalllestock'),
                    DB::raw('(SELECT dp.cost_c_iva  FROM detalle_price AS dp WHERE dp.detalle_stock_id = iddetalllestock ORDER BY dp.created_at DESC LIMIT 1) as costosiniva'),
                    DB::raw('(SELECT dp.sale_price  FROM detalle_price AS dp WHERE dp.detalle_stock_id = iddetalllestock ORDER BY dp.created_at DESC LIMIT 1) as precioventa'),
                );
            /** buscar por parametros especificos */
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
                $query->where('sk.category_id', 'LIKE', '%'.$categoria.'%');
            }
            // busqueda por marca
            if(!empty($marca)){
                $query->where('sk.manufacturer_id', 'LIKE', '%'.$marca.'%');
            }
            // busqueda por codigo
            if(!empty($nombre)){
                $query->where('sk.name', 'LIKE', '%'.$nombre.'%');
            }
            // por estados de productos
            if (!empty($request->estado)) {
                $estado = $request->estado;
                if($estado == "activos"){
                    $query->where('sk.state', '=', 1);
                } else {
                    $query->where('sk.state', '=', 0);
                }
            }
            // busqueda por almacen
            if(!empty($almacen)){
                if($almacen=="todos"){
                    // se mostraran todos los productos del almacen
                    $query->groupBy('sk.id', 'sk.image', 'sk.code',  'sk.barcode',
                        'sk.name',
                        'sk.exempt_iva',
                        'sk.stock_min',
                        'sk.description',
                        'dp.quantity',
                        'dp.branch_offices_id', 'c.name','man.name', 'me.name','sk.category_id', 'sk.manufacturer_id');
                } else {
                    // se mostraran los productos por almacen
                    $query->where('dp.branch_offices_id', '=', $almacen);
                    $query->groupBy('sk.id', 'sk.image', 'sk.code',  'sk.barcode',
                        'sk.name',
                        'sk.exempt_iva',
                        'sk.stock_min',
                        'sk.description',
                        'dp.quantity',
                        'dp.branch_offices_id', 'c.name','man.name', 'me.name','sk.category_id', 'sk.manufacturer_id');
                }
            }
            // aqui pondria la logica para ordernar los productos
            $query->orderBy('sk.code', 'ASC');
            $data = $query->paginate($pages);
        } else {
            $data = DB::table('stocks as sk')
                ->leftJoin('categories as c', 'sk.category_id', 'c.id')
                ->leftJoin('manufacturers as man', 'sk.manufacturer_id', 'man.id')
                ->leftJoin('measures as me', 'sk.measures_id', 'me.id')
                ->leftJoin('detalle_products as dp', 'sk.id', 'dp.stocks_id')
                ->select(
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
                    'c.name as category_name',
                    'man.name as marca_name',
                    'me.name as medida_name',
                    DB::raw('(SELECT ds.id  FROM detalle_stock AS ds WHERE ds.stocks_id = sk.id  ORDER BY ds.created_at DESC LIMIT 1) as iddetalllestock'),
                    DB::raw('(SELECT dp.cost_c_iva  FROM detalle_price AS dp WHERE dp.detalle_stock_id = iddetalllestock ORDER BY dp.created_at DESC LIMIT 1) as costosiniva'),
                    DB::raw('(SELECT dp.sale_price  FROM detalle_price AS dp WHERE dp.detalle_stock_id = iddetalllestock ORDER BY dp.created_at DESC LIMIT 1) as precioventa'),
                )
                ->where('sk.state', '=', 1)
                ->groupBy('sk.id', 'sk.image', 'sk.code',  'sk.barcode',
                    'sk.name',
                    'sk.exempt_iva',
                    'sk.stock_min',
                    'sk.description',
                    'dp.quantity',
                    'dp.branch_offices_id', 'c.name','man.name', 'me.name')
                ->orderBy('sk.code', 'ASC')
                ->paginate($pages);
        }
        // para ver los ultimos registro  de ingresos
        $ultimoPro = DB::table('stocks as s')
            ->leftJoin('detalle_stock as ds', 's.id', 'ds.stocks_id')
            ->leftJoin('detalle_price as dprice', 'ds.id', 'dprice.detalle_stock_id')
            ->select(
                'dprice.sale_price',
                'dprice.state',
                'dprice.created_at',
                'dprice.updated_at',
                'ds.unit_price',
                'ds.quantity',
                'ds.invoice_number',
                'ds.state',
                's.state',
                's.name',
                'ds.register_date',
                'ds.created_at',
            )
            ->where('ds.state', '=', 1)
            ->orderBy('dprice.updated_at', 'DESC')
            ->take(5)
            ->get();
        // ver los almacenes
        $almaceneslist = Sucursales::all();
        return view('productos.index', compact('data', 'estado', 'codigo', 'codbarra', 'categoria', 'marca', 'nombre', 'almacen', 'pages', 'ultimoPro', 'almaceneslist'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductosRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductosRequest $request)
    {
        //
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
        $detalle_stock = Ingresos::where('stocks_id', $id)
            ->limit(1)
            ->orderBy('id','DESC')
            ->first();

        // para mostrar el ultimo registro y extraer fecha y numero de factura
        $detalle_stock2 = Ingresos::select('invoice_date', 'invoice_number', 'created_at')
            ->latest('created_at')
            ->first();

        if (isset($detalle_stock)) {
            $detalle_price = Precios::where('detalle_stock_id', $detalle_stock->id)
                ->limit(1)
                ->orderBy('id','DESC')
                ->first();
        } else {
            $detalle_price = "";
        }

        $detalle_pro = Almacenes::where('branch_offices_id', $sucursalid)->where('stocks_id', $id)->first();
        $almacenes = Sucursales::all();
        $Detalle_products = DB::table('detalle_products as dp')
            ->leftJoin('branch_offices as bf', 'dp.branch_offices_id', 'bf.id')
            ->select('dp.quantity', 'bf.name', 'dp.stocks_id')
            ->where('stocks_id', $id)->get();
        return view('productos.actualizar', compact('stock', 'detalle_stock', 'detalle_stock2', 'id', 'detalle_price','detalle_pro', 'almacenes'));
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
        $message = "";
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

        // creamos un nuevo precio solo en caso que el precio haya cambiando
        $ingreso = Ingresos::where('stocks_id', '=', $id)
            ->limit(1)
            ->orderBy('id', 'DESC')
            ->first();

        $precioingreso = Precios::where('detalle_stock_id', '=', $ingreso->id)
            ->where('sale_price', '=', $request->sale_price)
            ->limit(1)
            ->orderBy('detalle_stock_id', 'DESC')
            ->exists();
        //->first();
        // si encuentro el mismo precio de venta no realizar nada
        if (!$precioingreso) {
            Precios::where('detalle_stock_id', $ingreso->id)->update(['state' => 0]);
            Precios::create([
                'unit_price' => $request->unit_price,
                'cost_s_iva' => $request->cost_s_iva,
                'cost_c_iva' => $request->cost_c_iva,
                'earn_c_iva' => $request->earn_c_iva,
                'earn_porcent' => $request->earn_porcent,
                'sale_price' => $request->sale_price,
                'state' => 1,
                'detalle_stock_id' => $ingreso->id,
            ]);
            $message = 'Producto y precio de venta actualizado correctamente';

        } else {
            $message = 'Producto actualizado correctamente';

        }
        return response()->json(["message" =>  $message], 200);
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
            $manufacturer = Marcas::select('id', 'name as text')
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
        /** */
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
                $cantidad =  $cantidad + $almacenhasta->quantity;
                // destino final de envio
                $updatehasta = Almacenes::find($almacenhasta->id);
                $updatehasta->quantity = $cantidad;
                $updatehasta->save();
                $message = "Traslado realizado correctamente";
                $code = 200;
            }
        }
            return response()->json(["message"=> $message], $code);
    }

    public function inventarios(Request $request) {
        // para filtrar por paginas
        $pages = 25;
        $estado = "activos";

        $codigo = $request->codigo;
        $codbarra = $request->codbarra;
        $categoria = $request->categoria;
        $marca = $request->marca;
        $nombre = $request->nombre;
        $almacen = $request->almacen;

        if (!empty($request->pages)) {
            $pages = $request->pages;
        } else {
            $pages = 25;
        }
        // si hay algun dato en una de las viarbales realizar la busqueda
        if(
            !empty($codigo) OR
            !empty($codbarra) OR
            !empty($categoria) OR
            !empty($marca) OR
            !empty($nombre) OR
            !empty($almacen) OR
            !empty($request->estado)){
            $query = DB::table('stocks as sk')
                ->leftJoin('categories as c', 'sk.category_id', 'c.id')
                ->leftJoin('manufacturers as man', 'sk.manufacturer_id', 'man.id')
                ->leftJoin('measures as me', 'sk.measures_id', 'me.id')
                ->leftJoin('detalle_products as dp', 'sk.id', 'dp.stocks_id')
                ->select(
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
                    'c.name as category_name',
                    'man.name as marca_name',
                    'me.name as medida_name',
                    'sk.category_id',
                    'sk.manufacturer_id',
                    DB::raw('(SELECT ds.id  FROM detalle_stock AS ds WHERE ds.stocks_id = sk.id  ORDER BY ds.created_at DESC LIMIT 1) as iddetalllestock'),
                    DB::raw('(SELECT dp.cost_c_iva  FROM detalle_price AS dp WHERE dp.detalle_stock_id = iddetalllestock ORDER BY dp.created_at DESC LIMIT 1) as costosiniva'),
                    DB::raw('(SELECT dp.sale_price  FROM detalle_price AS dp WHERE dp.detalle_stock_id = iddetalllestock ORDER BY dp.created_at DESC LIMIT 1) as precioventa'),
                );
            /** buscar por parametros especificos */
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
                $query->where('sk.category_id', 'LIKE', '%'.$categoria.'%');
            }
            // busqueda por marca
            if(!empty($marca)){
                $query->where('sk.manufacturer_id', 'LIKE', '%'.$marca.'%');
            }
            // busqueda por codigo
            if(!empty($nombre)){
                $query->where('sk.name', 'LIKE', '%'.$nombre.'%');
            }
            // por estados de productos
            if (!empty($request->estado)) {
                $estado = $request->estado;
                if($estado == "activos"){
                    $query->where('sk.state', '=', 1);
                } else {
                    $query->where('sk.state', '=', 0);
                }
            }
            // busqueda por almacen
            if(!empty($almacen)){
                if($almacen=="todos"){
                    // se mostraran todos los productos del almacen
                    $query->groupBy('sk.id', 'sk.image', 'sk.code',  'sk.barcode',
                        'sk.name',
                        'sk.exempt_iva',
                        'sk.stock_min',
                        'sk.description',
                        'dp.quantity',
                        'dp.branch_offices_id', 'c.name','man.name', 'me.name','sk.category_id', 'sk.manufacturer_id');
                } else {
                    // se mostraran los productos por almacen
                    $query->where('dp.branch_offices_id', '=', $almacen);
                    $query->groupBy('sk.id', 'sk.image', 'sk.code',  'sk.barcode',
                        'sk.name',
                        'sk.exempt_iva',
                        'sk.stock_min',
                        'sk.description',
                        'dp.quantity',
                        'dp.branch_offices_id', 'c.name','man.name', 'me.name','sk.category_id', 'sk.manufacturer_id');
                }
            }
            // aqui pondria la logica para ordernar los productos
            $query->orderBy('sk.code', 'ASC');
            $data = $query->paginate($pages);
        } else {
            $data = DB::table('stocks as sk')
                ->leftJoin('categories as c', 'sk.category_id', 'c.id')
                ->leftJoin('manufacturers as man', 'sk.manufacturer_id', 'man.id')
                ->leftJoin('measures as me', 'sk.measures_id', 'me.id')
                ->leftJoin('detalle_products as dp', 'sk.id', 'dp.stocks_id')
                ->select(
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
                    'c.name as category_name',
                    'man.name as marca_name',
                    'me.name as medida_name',
                    DB::raw('(SELECT ds.id  FROM detalle_stock AS ds WHERE ds.stocks_id = sk.id  ORDER BY ds.created_at DESC LIMIT 1) as iddetalllestock'),
                    DB::raw('(SELECT dp.cost_c_iva  FROM detalle_price AS dp WHERE dp.detalle_stock_id = iddetalllestock ORDER BY dp.created_at DESC LIMIT 1) as costosiniva'),
                    DB::raw('(SELECT dp.sale_price  FROM detalle_price AS dp WHERE dp.detalle_stock_id = iddetalllestock ORDER BY dp.created_at DESC LIMIT 1) as precioventa'),
                )
                ->where('sk.state', '=', 1)
                ->groupBy('sk.id', 'sk.image', 'sk.code',  'sk.barcode',
                    'sk.name',
                    'sk.exempt_iva',
                    'sk.stock_min',
                    'sk.description',
                    'dp.quantity',
                    'dp.branch_offices_id', 'c.name','man.name', 'me.name')
                ->orderBy('sk.code', 'ASC')
                ->paginate($pages);
        }
        // para ver los ultimos registro  de ingresos
        $almaceneslist = Sucursales::all();
        return view('productos.empleados', compact('data', 'estado', 'codigo', 'codbarra', 'categoria', 'marca', 'nombre', 'almacen', 'pages', 'almaceneslist'));
    }
}
