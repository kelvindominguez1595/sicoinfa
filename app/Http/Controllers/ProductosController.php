<?php

namespace App\Http\Controllers;

use App\Models\Almacenes;
use App\Models\Categorias;
use App\Models\DetalleIngreso;
use App\Models\Ingresos;
use App\Models\Marcas;
use App\Models\Precios;
use App\Models\Productos;
use App\Models\Proveedores;
use App\Models\Unidaddemedidas;
use Illuminate\Http\Request;
use App\Models\Sucursales;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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
        $estado     = $request->estado;
        $orderby    = $request->orderby;

        if (!empty($request->orderby)) {
            $otherorder = $request->orderby;
        } else {
            $otherorder = 'ASC';
        }

        if (!empty($request->pages)) {
            $pages = $request->pages;
        } else {
            $pages = 25;
        }

        switch ($request->titletable){
                case 'barra':
                    $nameorder = 'sk.barcode';
                    $nametitle = $this->orderValidaName($request->titletable);
                    $ordervali = $this->orderByvalidate($orderby);
                break;
                case 'categoria':
                    $nameorder = 'category_name';
                    $nametitle = $this->orderValidaName($request->titletable);
                    $ordervali = $this->orderByvalidate($orderby);
                break;
                case 'marca':
                    $nameorder = 'marca_name';
                    $nametitle = $this->orderValidaName($request->titletable);
                    $ordervali = $this->orderByvalidate($orderby);
                break;
                case 'nombre':
                    $nameorder = 'sk.name';
                    $nametitle = $this->orderValidaName($request->titletable);
                    $ordervali = $this->orderByvalidate($orderby);
                break;
            default:
                $nameorder = 'sk.code';
                $nametitle = $this->orderValidaName($request->titletable);
                $ordervali = $this->orderByvalidate($orderby);
                break;
        }
        $request->icoorderby;

      if(!empty($codigo) ||
        !empty($codbarra) ||
        !empty($categoria) ||
        !empty($marca) ||
        !empty($nombre) ||
        !empty($almacen) ||
        !empty($orderby) ||
        !empty($estado) ){
          // si hay datos mostramos este filtrado
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
          if($estado == "activos"){
              $query->where('sk.state', '=', 1);
          } else {
              $query->where('sk.state', '=', 0);
          }
          // busqueda por almacen
          if(empty($almacen) || $almacen =="todos" ){ // esta vacio si lo esta debe agrupar todo
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

          // aqui pondria la logica para ordernar los productos
//          if(!empty($orderby)){
//              $query->orderBy($nameorder, $ordervali);
//          } else {
//              $query->orderBy('sk.code', 'ASC');
//          }
          $query->orderBy($nameorder, $ordervali);
      } else {
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
              );
          $query->where('sk.state', '=', 1);
          $query->groupBy('sk.id');
          $query->orderBy($nameorder, $ordervali);
      }
        $data = $query->paginate($pages);

        // obtenemos los ultiumos 5 productos registrados
        $ultimoPro = DB::table('stocks as sk')
        ->leftJoinSub($subds, 'detallestock', function($join){
            $join->on('sk.id', '=', 'detallestock.stocks_id');
        })
        ->leftJoin('detalle_stock as detsto', 'detallestock.iddstock', 'detsto.id')
        ->leftJoinSub($precionew, 'precio', function($join){
            $join->on('sk.id', '=', 'precio.producto_id');
        })
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
            'precio.costosiniva',
            'canprodu.cantidadnew',)
        ->where('sk.state','=', 1)
        ->orderBy('sk.updated_at', 'DESC')
        ->take(5)
        ->get();
        // ver los almacenes
        $almaceneslist = Sucursales::all();
        return view('productos.index', compact(
        'data',
        'orderby',
        'otherorder',
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
        'nametitle',
        'ordervali'
        ));
    }

    public function orderByvalidate($order){

        if(empty($order)){
            $res = 'ASC';
        } else {
            if($order == 'ASC'){
                $res = 'DESC';
            } else {
                $res = 'ASC';
            }
        }
        return $res;
    }

    public function orderValidaName($name){
        if(empty($name)){
            $res = 'codigo';
        } else {
            $res = $name;
        }
        return $res;
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
            if( $precios['ganancia'] != $ganancia && $precios['porcentaje'] != $porcentaje && $precios['precioventa'] != $preciventa)
            {
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

        }
        return response()->json(["message" =>  "succes", "precio" => $precios, "data" => $data], 200);
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
    public function ajusteproducto(Request $request)
    {
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

                //dd($quantity);
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
        $data = $query->paginate($pages);
        // ver los almacenes
        $almaceneslist = Sucursales::all();
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
}
