<?php

namespace App\Http\Controllers;

use App\Models\Almacenes;
use App\Models\DatosIngresos;
use App\Models\DetalleIngreso;
use App\Models\Ingresos;
use App\Models\Precios;
use App\Http\Requests\StoreIngresosRequest;
use App\Http\Requests\UpdateIngresosRequest;
use App\Models\Sucursales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;


class IngresosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sucursal = Sucursales::all();
        return view('ingresos.index', compact('sucursal'));
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
     * @param  \App\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['suppliers_id' => 'required']);
        $stock_id           = $request->stocks_id;
        $sucursal_id        = $request->branch_offices_id;
        $cantidad_ingreso   = $request->quantity;
        $costo_ingreso      = $request->unit_price;
        $proveedor          = $request->suppliers_id;
        $creditofiscal      = $request->invoice_number;
        $fechafactura       = $request->invoice_date;
        $fechaingreso       = $request->register_date;
        /**
         * *************** PASO 1 ***************
         * Consultar los precios y validar los precios viejos y nuevos
         */
       $res = $this->costoPromedio($stock_id, $sucursal_id, $cantidad_ingreso, $costo_ingreso);
        /**
         * ************** PASO 2 ****************
         * realizamos el ingreso a la tabla ingreso
         */
        $dataingre = DatosIngresos::create([
            'proveedor_id' => $proveedor,
            'numerofiscal' => $creditofiscal,
            'fechafactura' => $fechafactura,
            'fechaingreso' => $fechaingreso
        ]);

        Ingresos::create([
            'invoice_number' => $creditofiscal,
            'invoice_date' => $fechafactura,
            'register_date' => $fechaingreso,
            'quantity' => $cantidad_ingreso,
            'unit_price' => $costo_ingreso,
            'stocks_id' => $stock_id,
            'state' => 1,
            'clientefacturas_id' => $proveedor,
            'datosingresos_id' => $dataingre->id,
        ]);
        // respondemos
        return response()->json(["message" => "Nuevo ingreso guardado correctamente", "data" => $res],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingresos  $ingresos
     * @return \Illuminate\Http\Response
     */
    public function show(Ingresos $ingresos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ingresos  $ingresos
     * @return \Illuminate\Http\Response
     */
    public function edit(Ingresos $ingresos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateIngresosRequest  $request
     * @param  \App\Models\Ingresos  $ingresos
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIngresosRequest $request, Ingresos $ingresos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingresos  $ingresos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ingresos $ingresos)
    {
        //
    }

    // calculos del costo promedio
    public function costoPromedio($stock_id, $sucursal_id, $cantidad_ingreso, $costo_ingreso){
        $precio = $this->validarPrecio($stock_id);

        // creamos una formula para multiplicar los precios actuales
        $valid = Almacenes::where('branch_offices_id', '=', $sucursal_id)
            ->where('stocks_id', '=', $stock_id)
            ->first();

        if($valid){
            $almacenmain = Almacenes::where('branch_offices_id', '=', $sucursal_id)
                ->where('stocks_id', '=', $stock_id)
                ->first();
        } else{
            $almacenmain = Almacenes::create([
                'stock_min' => 2,
                'quantity' => 0,
                'branch_offices_id' => $sucursal_id,
                'stocks_id' => $stock_id,
            ]);
        }
        if($precio['costosiniva'] == 0){
            $cambio = "nuevo";
            // multiplicamos el nuevo costo con iva
            $costoPromedio = $costo_ingreso;
            $precioconiva = $costoPromedio + ($costoPromedio * 0.13);
            $priceVenta = $this->preciofinalVenta($precio['precioventa'], $precioconiva);

            $ganancia =  $priceVenta['ganancia'];
            $porcentaje = $priceVenta['porcentaje'];
            $precioventa = $precio['precioventa'];
            $sumaCantidad = $cantidad_ingreso;
        } else {
            // multiplico cantidad por precio costo sin iva almacen actual
            $preciomain = $almacenmain->quantity * $precio['costosiniva'];
            // multiplico cantidad por precio ingreso del producto
            $precioingreso = intval($cantidad_ingreso) * floatval($costo_ingreso);
            // Sumo cantidad actual e ingreso
            $sumaCantidad = $almacenmain->quantity + $cantidad_ingreso;
            // Sumo subtotales de ingreso y actual
            $sumoSubtotales = $preciomain + $precioingreso;
            // divimos el resultado por la cantidad y esto sera el nuevo costo promedio
            $costoPromedio = $sumoSubtotales / $sumaCantidad;
            $costoPromedioFormat = floatval(number_format($costoPromedio, 5));
            // para ver si ha subrido un cambio el precio
                if($costoPromedioFormat > $precio['costosiniva']){
                    $cambio = "subio";
                    // multiplicamos el nuevo costo con iva
                    $precioconiva = $costoPromedioFormat + ($costoPromedioFormat * 0.13);
                    $precioventaFinal = $this->porcentaje($precio['porcentaje'], $precioconiva);

                    $precioventa = $precioventaFinal['preciofinal'];
                    $ganancia = $precioventaFinal['ganancia'];
                    $porcentaje = $precio['porcentaje'];
                }
                if($costoPromedioFormat == $precio['costosiniva']){
                    $cambio = "mantiene";
                    // multiplicamos el nuevo costo con iva
                    $precioconiva = $precio['costoconiva'];
                    $precioventaFinal = $this->porcentaje($precio['porcentaje'], $precioconiva);
                    $precioventa = $precioventaFinal['preciofinal'];
                    $ganancia = $precioventaFinal['ganancia'];
                    $porcentaje = $precio['porcentaje'];
                }
                if($costoPromedioFormat < $precio['costosiniva']){
                    $cambio = "bajo";
                    // multiplicamos el nuevo costo con iva
                    $precioconiva = $costoPromedioFormat + ($costoPromedioFormat * 0.13);
                    $precioventaFinal = $this->porcentaje($precio['porcentaje'], $precioconiva);
                    $precioventa = $precioventaFinal['preciofinal'];
                    $ganancia = $precioventaFinal['ganancia'];
                    $porcentaje = $precio['porcentaje'];
                }
        }
        $precioconivaFormat = floatval(number_format($precioconiva, 5));
        // guardar en la table precios
       $this->guardarPrecios(
           $stock_id,
           $costoPromedio,
           $precioconiva,
           $ganancia,
           $porcentaje,
           $precioventa,
           $cambio,
           $sumaCantidad,
           $almacenmain->id);

        return $cambio;
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
            $existIngreso= Ingresos::where('stocks_id', $id)
                ->limit(1)
                ->orderBy('id','DESC')
                ->exists();
            if($existIngreso){
                $precioviejoingreso = Ingresos::where('stocks_id', $id)
                    ->limit(1)
                    ->orderBy('id','DESC')
                    ->first();
                $precioviejo = DetalleIngreso::where('detalle_stock_id', '=', $precioviejoingreso->id)->first();
                /**
                 * aqui pondre que pase a estado 10
                 * El 10 significa que este el precio base que se tomo como referencia
                 * para el producto en pocas palabras seria el paciente cero de los precios
                 * del producto
                 *  NOTA: Esta fue la forma vieja de llevar el control de precio, pero en realidad
                 *  el costo promedio no se podia sacar y por eso se tomo una decision de crear una tabla aparte que
                 *  apunte almacen.
                 */

                $upingreso = Ingresos::find($precioviejoingreso->id);
                $upingreso->state = 10;
                $upingreso->save();
                if($precioviejo){
                    $upprecioviejo = DetalleIngreso::find($precioviejo->id);
                    $upprecioviejo->state = 10;
                    $upprecioviejo->save();
                } else {
                    $costosiniva    = 0;
                    $costoconiva    = 0;
                    $ganancia       = 0;
                    $porcentaje     = 0;
                    $precioventa    = 0;
                }
            } else {
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

    // aquí dejare para guardar los precios en la nueva tabla precios
    public function guardarPrecios($productoid, $costosin, $precioconiva, $ganancia, $porcentaje, $precioventa, $cambio, $sumaCantidad, $almacenid){
        // guardamos el nuevo precio
        $precio = Precios::create([
            'producto_id'   => $productoid,
            'costosiniva'   => $costosin,
            'costoconiva'   => $precioconiva,
            'ganancia'      => $ganancia,
            'porcentaje'    => $porcentaje,
            'precioventa'   => $precioventa,
            'cambio'        => $cambio,
        ]);
        if($precio){
        // actualizamos la cantidad de ingreso
            $update = date('Y-m-d H:i:s');
            DB::table('detalle_products')
                ->where([
                    ['id', '=', $almacenid],
                    ['stocks_id', '=', $productoid]
                ])
                ->update([
                    'quantity' => $sumaCantidad,
                    'updated_at' => $update
                ]);
            $res = true;
//            $update = Almacenes::find($almacenid);
//            $update->quantity = $sumaCantidad;
//            $update->save();
//            if($update){
//                $res = true;
//            }
        } else {
            $res = false;
        }
        return $res;
    }
    /**
     * IMPORTANTE ESTA FUNCION YA QUE SERA LA QUE CONTROLARÁ LOS COSTOS DEL PRODUCTOS
     * ESTA CONSULTA LA REALIZARA VIA AJAX
     */
    public function precioRealdelProducto($producto_id, $sucursal_id) {
        // 1 necesitamos obtener el ultimo y antepenultimo registros del los precios del producto
        /**
         * PREGUNTAMOS QUE SI EN LA NUEVA TABLA PRECIOS EXISTEN POR LO MENOS DOS REGISTROS
         * ENTONCES DE AHI SACAMOS EL ULTIMO Y ANTEPENULTIMO REGISTRO
         * EN CASO QUE NO SE CUMPLA ENTONCES BUSCAMOS EL PRECIO EN LA TABLA ANTIGUA DONDE
         * SU ESTADO SEA IGUAL A 10
         */
       $preciocantidad = Precios::where('producto_id', $producto_id)->get();
        if($preciocantidad->count() >= 2){
            $precio = Precios::where('producto_id', $producto_id)
                ->limit(2)
                ->orderBy('id','DESC')
                ->get();
            // Precio Nuevo
            $idnuevo        = $precio[0]->id;
            $costosiniva    = $precio[0]->costosiniva;
            $costoconiva    = $precio[0]->costoconiva;
            $ganancia       = $precio[0]->ganancia;
            $porcentaje     = $precio[0]->porcentaje;
            $precioventa    = $precio[0]->precioventa;
            $cambio         = $precio[0]->cambio;
            // Precio Anterior
            $idviejo                = $precio[1]->id;
            $costosinivaViejos    = $precio[1]->costosiniva;
            $costoconivaViejos    = $precio[1]->costoconiva;
            $gananciaViejos       = $precio[1]->ganancia;
            $porcentajeViejos     = $precio[1]->porcentaje;
            $precioventaViejos    = $precio[1]->precioventa;
            $cambioViejos         = $precio[1]->cambio;

        } else if($preciocantidad->count() == 1){
            // vamos atraer el precio que este en estado 10 de la tabla vieja
            // si ya un precio en la nueva tabla traemos el ultimo precio de ingreso
            $precio = Precios::where('producto_id', $producto_id)
                ->limit(1)
                ->orderBy('id','DESC')
                ->first();

            $exiin = Ingresos::where('stocks_id', '=',$producto_id)
                ->where('state', '=', 10)
                ->orderBy('id','DESC')
                ->limit(1)
                ->exists();
            if($exiin){
                $pinviejo = Ingresos::where('stocks_id', '=',$producto_id)
                    ->where('state', '=', 10)
                    ->orderBy('id','DESC')
                    ->limit(1)
                    ->first();
                $precioviejo = DetalleIngreso::where('detalle_stock_id', '=', $pinviejo->id)
                    ->where('state', '=', 10)
                    ->first();
                if($precioviejo){
                    // Precio Anterior
                    $idviejo              = "no id viejo antiguo";
                    $costosinivaViejos    = $precioviejo->cost_s_iva;
                    $costoconivaViejos    = $precioviejo->cost_c_iva;
                    $gananciaViejos       = $precioviejo->earn_c_iva;
                    $porcentajeViejos     = $precioviejo->earn_porcent;
                    $precioventaViejos    = $precioviejo->sale_price;
                    $cambioViejos         = "no viejo";
                    // Precio Anterior
                } else {
                    // Precio Anterior
                    $idviejo              = "no id viejo antiguo";
                    $costosinivaViejos    = 0;
                    $costoconivaViejos    = 0;
                    $gananciaViejos       = 0;
                    $porcentajeViejos     = 0;
                    $precioventaViejos    = 0;
                    $cambioViejos         = "no viejo";
                    // Precio Anterior
                }

            } else {
                $idviejo              = "no id viejo antiguo";
                $costosinivaViejos    = 0;
                $costoconivaViejos    = 0;
                $gananciaViejos       = 0;
                $porcentajeViejos     = 0;
                $precioventaViejos    = 0;
                $cambioViejos         = "no viejo";
            }
            // Precio Nuevo
            $idnuevo        = $precio->id;
            $costosiniva    = $precio->costosiniva;
            $costoconiva    = $precio->costoconiva;
            $ganancia       = $precio->ganancia;
            $porcentaje     = $precio->porcentaje;
            $precioventa    = $precio->precioventa;
            $cambio         = $precio->cambio;
        } else {
            // si no hay nada en el precio nueva tabla entonces obtenemos el ultimo dos precios de las tablas antiguas
            $existpro = Ingresos::where('stocks_id', $producto_id)
                ->orderBy('id','DESC')
                ->limit(1)
                ->exists();
            if($existpro){
                $pinviejo = Ingresos::where('stocks_id', $producto_id)
                    ->orderBy('id','DESC')
                    ->limit(1)
                    ->first();
                $precioviejo = DetalleIngreso::where('detalle_stock_id', '=', $pinviejo->id)
                    ->first();
                // Precio Nuevo
                $idnuevo        = "no id nuevo";
                $costosiniva    = 0;
                $costoconiva    = 0;
                $ganancia       = 0;
                $porcentaje     = 0;
                $precioventa    = 0;
                $cambio         = "no hay nuevo precio";
                // Precio Anterior
                $costosinivaViejos    = $precioviejo->cost_s_iva;
                $costoconivaViejos    = $precioviejo->cost_c_iva;
                $gananciaViejos       = $precioviejo->earn_c_iva;
                $porcentajeViejos     = $precioviejo->earn_porcent;
                $precioventaViejos    = $precioviejo->sale_price;
                $cambioViejos         = "no viejo";
                $idviejo              = "no id ni nuevo ni viejo";
            } else {
                // Precio Nuevo
                $idnuevo        = "no id nuevo";
                $costosiniva    = 0;
                $costoconiva    = 0;
                $ganancia       = 0;
                $porcentaje     = 0;
                $precioventa    = 0;
                $cambio         = "no hay nuevo precio";
                // Precio Anterior
                $costosinivaViejos    = 0;
                $costoconivaViejos    = 0;
                $gananciaViejos       = 0;
                $porcentajeViejos     = 0;
                $precioventaViejos    = 0;
                $cambioViejos         = "no viejo";
                $idviejo              = "no id ni nuevo ni viejo";
            }

        }
        return response()->json([
            "idnuevo"           => $idnuevo,
            "costosiniva"       => $costosiniva,
            "costoconiva"       => $costoconiva,
            "ganancia"          => $ganancia,
            "porcentaje"        => $porcentaje,
            "precioventa"       => $precioventa,
            "cambio"            => $cambio,
            "costosinivaViejos" => $costosinivaViejos,
            "costoconivaViejos" => $costoconivaViejos,
            "gananciaViejos"    => $gananciaViejos,
            "porcentajeViejos"  => $porcentajeViejos,
            "precioventaViejos" => $precioventaViejos,
            "cambioViejos"      => $cambioViejos,
            "idviejo"           => $idviejo,
        ],200);
    }

    // método para calcular porcentaje
    public function porcentaje($porcentaje, $costoconiva) {
        $ganancia = $costoconiva * ($porcentaje / 100);
        $precioventa = $ganancia + $costoconiva;
        return array( "preciofinal" => $precioventa, "ganancia" => $ganancia);
    }
    // método para calcular Ganancia
    public function ganancia($costoconiva, $ganancia) {
        $precioFinal = $ganancia + $costoconiva;
        $porcentaje = ( ( ($precioFinal / $costoconiva) - 1 ) * 100);
        return array( "preciofinal" => $precioFinal, "porcentaje" => $porcentaje );
    }
    // método para mostrar el precio de venta final
    public function preciofinalVenta($precioventa, $costoconiva) {
        $porcentaje = ( ( ($precioventa / $costoconiva) - 1 ) * 100);
        $ganancia = $precioventa - $costoconiva;
        return array( "ganancia" => $ganancia, "porcentaje" => $porcentaje );
    }
    // método para calcular el IVA
    public function costomasIVA($costosiniva) {
        return $costosiniva + ($costosiniva * 0.13);
    }

    public function existPriceProduct($producto_id){
        $res = "NO";
        $result = Precios::where('producto_id', '=', $producto_id)->exists();
        if($result){
            $res = "SI";
        }
        return $res;
    }

    public function existProductSucursal($producto_id, $sucursal_id){
        $res = "NO";
        $result = Almacenes::where('branch_offices_id', '=', $sucursal_id)
            ->where('stocks_id', '=', $producto_id)
            ->exists();
        if($result){
            $res = "SI";
        }
        return $res;
    }

    public function priceDataNew($producto_id) {
        return Precios::where('producto_id', $producto_id)
            ->limit(1)
            ->orderBy('id','DESC')
            ->first();
    }

    public function precio_Antiguo($producto_id) {
        $existIngreso= Ingresos::where('stocks_id', $producto_id)
            ->limit(1)
            ->orderBy('id','DESC')
            ->exists();
        if($existIngreso){
            $ingreso = Ingresos::where('stocks_id', $producto_id)
                ->limit(1)
                ->orderBy('id','DESC')
                ->first();
            $res = DetalleIngreso::where('detalle_stock_id', '=', $ingreso->id)->first();
            if($res){
                $result = $res;
            } else {
                $result = "SIN PRECIO VIEJO";
            }
        } else {
            $result = "NO HAY INGRESOS";
        }
        return $result;
    }

    public function ingresofactura(Request $request){
        // registramos los datos de la factura
        $proveedor_id = $request->proveedor_id;
        $creditofiscal = $request->creditofiscal;
        $fechafactura = $request->fechafactura;
        $fechaingreso = date('Y-m-d h:i:s', strtotime($request->fechaingreso)) ;

        $datoingreso = DatosIngresos::create([
            'proveedor_id' => $proveedor_id,
            'numerofiscal' => $creditofiscal,
            'fechafactura' => $fechafactura,
            'fechaingreso' => $fechaingreso
        ]);
        // recorremos los datos de la tabla registrada
        $almacenid =  $request->branch_offices_id;
        foreach($request['product_id'] as $key => $value){
            // hacemos el ingreso del producto
            $productoid             = $request['product_id'][$key];
            $cantidadingreso        = $request['cant'][$key];
            $costonsinivaingreso    = $request['cot_sin'][$key];

            if ($this->existPriceProduct($productoid) == "SI") {
                $res = $this->priceDataNew($productoid);
                $costsiniva     = $res->costosiniva;
                $costoconiva    = $res->costoconiva;
                $ganancia       = $res->ganancia;
                $porcentaje     = $res->porcentaje;
                $precioventa    = $res->precioventa;
            } else {
                if ($this->precio_Antiguo($productoid) == "SIN PRECIO VIEJO") {
                    $costsiniva     = 0;
                    $costoconiva    = 0;
                    $ganancia       = 0;
                    $porcentaje     = 0;
                    $precioventa    = 0;
                } else if ($this->precio_Antiguo($productoid) == "NO HAY INGRESOS") {
                    $costsiniva     = 0;
                    $costoconiva    = 0;
                    $ganancia       = 0;
                    $porcentaje     = 0;
                    $precioventa    = 0;
                } else {
                    $res = $this->precio_Antiguo($productoid);
                    $costsiniva     = $res->cost_s_iva ?? 0;
                    $costoconiva    = $res->cost_c_iva ?? 0;
                    $ganancia       = $res->earn_c_iva ?? 0;
                    $porcentaje     = $res->earn_porcent ?? 0;
                    $precioventa    = $res->sale_price ?? 0;
                }
            }

            if($this->existProductSucursal($productoid, $almacenid) == "SI") {
                $almacen = Almacenes::where('branch_offices_id', '=', $almacenid)
                    ->where('stocks_id', '=', $productoid)
                    ->first();
            } else {
                $almacen = Almacenes::create([
                    'stock_min' => 2,
                    'quantity' => 0,
                    'branch_offices_id' => $almacenid,
                    'stocks_id' => $productoid,
                ]);
            }
            /** ESTO ES POR SI EL PRODUCTO EXISTE PERO NO HAY INGRESO O SI HAY INGRESO PERO NO TIENE PRECIO DETALLE ANTIGUO*/

            if($costsiniva == 0 && $costoconiva  == 0 && $ganancia == 0 && $porcentaje == 0 && $precioventa == 0)  {
                $cambio = "mantiene";
                $costoFormat            = $costonsinivaingreso;
                $precioconivaFinal      = $this->costomasIVA($costonsinivaingreso);
                $gananciaSave           = 0;
                $porcentajeSave         = 0;
                $precioventaSave        = 0;
                $cantidadPromedio       = $cantidadingreso;
            } else {
                /** COSTO ACTUAL*/
                $costoTotal = $almacen->quantity * $costsiniva;
                /** COSTO DE INGRESO */
                $costoTotalIngreso = intval($cantidadingreso) * floatval($costonsinivaingreso);
                /** SUMAR CANTIDAD ACTUAL Y NUEVA */
                $cantidadPromedio = $almacen->quantity + $cantidadingreso;
                /** SUMAR COSTO SIN IVA ACTUAL MAS COSTO SIN IVA NUEVO */
                $costoPromedio = $costoTotal + $costoTotalIngreso;
                /** DIVIDIMOS EL COSTO PROMEDIO ENTRE LA CANTIDAD PROMEDIO*/
                $costoFinal = $costoPromedio / $cantidadPromedio;
                /** EL COSTO FINAL LE PONDREMOS 5 DECIMALES */
                $costoFormat = floatval(number_format($costoFinal, 5));
                $precioconivaFinal = $this->costomasIVA($costoFormat);

                if($ganancia == 0 && $porcentaje == 0 && $precioventa == 0)  {
                    $cambio = "mantiene";
                    $gananciaSave       = 0;
                    $porcentajeSave     = 0;
                    $precioventaSave    = 0;
                } else {
                    if($costoFormat > $costsiniva){
                        $cambio = "subio";
                        $CalprecioventaFinal    = $this->porcentaje($porcentaje, $precioconivaFinal);
                        $gananciaSave           = $CalprecioventaFinal['ganancia'];
                        $porcentajeSave         = $porcentaje;
                        $precioventaSave        = $CalprecioventaFinal['preciofinal'];
                    }

                    if($costoFormat == $costsiniva){
                        $cambio = "mantiene";
                        $CalprecioventaFinal    = $this->porcentaje($porcentaje, $precioconivaFinal);
                        $gananciaSave          = $CalprecioventaFinal['ganancia'];
                        $porcentajeSave        = $porcentaje;
                        $precioventaSave       = $CalprecioventaFinal['preciofinal'];
                    }

                    if($costoFormat < $costsiniva){
                        $cambio = "bajo";
                        $CalprecioventaFinal    = $this->porcentaje($porcentaje, $precioconivaFinal);
                        $gananciaSave          = $CalprecioventaFinal['ganancia'];
                        $porcentajeSave        = $porcentaje;
                        $precioventaSave       = $CalprecioventaFinal['preciofinal'];
                    }
                }
            }
            /** ACTUALIZO LA CANTIDAD DEL ALMACEN */
            $update = date('Y-m-d H:i:s');
            DB::table('detalle_products')
                ->where('branch_offices_id', $almacenid)
                ->where('stocks_id', $productoid)
                ->update([
                    'quantity'      => $cantidadPromedio,
                    'updated_at'    => $update
                ]);

            /** GUARDO EL INGRESO DE LOS PRODUCTOS */

            Ingresos::create([
                'invoice_number' => $creditofiscal,
                'invoice_date' => $fechafactura,
                'register_date' => $fechaingreso,
                'quantity' => $cantidadPromedio,
                'unit_price' => $costoFormat,
                'stocks_id' => $productoid,
                'state' => 1,
                'clientefacturas_id' => $proveedor_id,
                'datosingresos_id' => $datoingreso->id,
            ]);

            /** GUARDO EN LA NUEVA TABLA DE PRECIOS */
            Precios::create([
                'producto_id'   => $productoid,
                'costosiniva'   => $costoFormat,
                'costoconiva'   => $precioconivaFinal,
                'ganancia'      => $gananciaSave,
                'porcentaje'    => $porcentajeSave,
                'precioventa'   => $precioventaSave,
                'cambio'        => $cambio,
            ]);
        }
     //   $cryp = Crypt::encryptString($datoingreso->id);
       return response()->json(["message" => "Guardado", "factura" => $datoingreso->id], 200);
    }

    public function modificarPrecioVenta($factura){

       // $factura_id = Crypt::decryptString($factura);


        $precionew = DB::table('precios')
            ->select(
                DB::raw('MAX(id) as price_id'),
                'producto_id',
                DB::raw('MAX(created_at) as created_at'))
            ->groupBy('producto_id');

        $data = DB::table('stocks as stock')
            ->Join('detalle_stock as d_stock', 'd_stock.stocks_id', 'stock.id')
            ->JoinSub($precionew, 'precio', function($join){
                $join->on('stock.id', '=', 'precio.producto_id');
            })
            ->Join('precios as price', 'precio.price_id', 'price.id')
            ->select(
                'stock.id',
                'stock.name',
                'price.costosiniva',
                'price.costoconiva',
                'price.ganancia',
                'price.porcentaje',
                'price.precioventa',
                'price.cambio',
                'price.producto_id',
            )
            ->where('d_stock.datosingresos_id', '=', $factura)
            ->get();

        return view('ingresos.precioventa', compact('data'));
    }

    public function modprecioventa(Request $request){
        foreach ($request['product_id'] as $key => $value){
            $product_id     = $request['product_id'][$key];
            $costosiniva    = $request['costosiniva'][$key];
            $costoconiva    = $request['costoconiva'][$key];
            $ganancia       = $request['ganancia'][$key];
            $porcentaje     = $request['porcentaje'][$key];
            $cambio         = $request['cambio'][$key];
            $precioventa    = $request['precioventa'][$key];

            Precios::create([
                'producto_id'   => $product_id,
                'costosiniva'   => $costosiniva,
                'costoconiva'   => $costoconiva,
                'ganancia'      => $ganancia,
                'porcentaje'    => $porcentaje,
                'precioventa'   => $precioventa,
                'cambio'        => $cambio,
            ]);
        }
        return response()->json(["message" => "Precio de venta Actualizados"], 200);
    }

}
