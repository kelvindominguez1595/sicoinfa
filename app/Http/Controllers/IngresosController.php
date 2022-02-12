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
        $stock_id = $request->stocks_id;
        $sucursal_id = $request->branch_offices_id;
        $cantidad_ingreso = $request->quantity;
        $costo_ingreso = $request->unit_price;
        $proveedor = $request->suppliers_id;
        $creditofiscal = $request->invoice_number;
        $fechafactura = $request->invoice_date;
        $fechaingreso = $request->register_date;
        /**
         * *************** PASO 1 ***************
         * Consultar los precios y validar los precios viejos y nuevos
         */
        $this->costoPromedio($stock_id, $sucursal_id, $cantidad_ingreso, $costo_ingreso);
        /**
         * ************** PASO 2 ****************
         * realizamos el ingreso a la tabla ingreso
         */
        DatosIngresos::created([
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
        ]);
        // respondemos
        return response()->json(["message" => "success"],200);
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

    public function ingresofactura(Request $request){
        // registramos los datos de la factura
       $datoingreso = DatosIngresos::created([
            'proveedor_id' => $request->proveedor_id,
            'numerofiscal' => $request->creditofiscal,
            'fechafactura' => $request->fechafactura,
            'fechaingreso' => $request->fechaingreso
        ]);
        // recorremos los datos de la tabla registrada
        foreach($request['productid'] as $key => $value){
            // hacemos el ingreso del producto
            $ingreso = Ingresos::create([
                'invoice_number' => $request->creditofiscal,
                'invoice_date' => $request->fechafactura,
                'register_date' => $request->fechaingreso,
                'quantity' => $request['cant'][$key],
                'unit_price' => $request['cotsin'][$key],
                'stocks_id' => $request['productid'][$key],
                'state' => 1,
                'clientefacturas_id' => $request->proveedor_id,
                'datosingresos_id' => $datoingreso->id,
            ]);

            // creamos un precio
            Precios::create([
                'cost_s_iva' => $request['cotsin'][$key],
                'cost_c_iva' => 0,
                'earn_c_iva' => 0,
                'earn_porcent' => 0,
                'sale_price' => 0,
                'detalle_stock_id' => $ingreso->id
            ]);
            /**
             * DEBEMOS DE PREGUNTAR SI EL PRODUCTO EXISTE EN EL ALMACEN
            */
            $dataalmacenes = Almacenes::where('branch_offices_id', $request->branch_offices_id)
                ->where('stocks_id', $request['productid'][$key])
                ->exists();
            if($dataalmacenes){
                // si existe solo actualizamos la cantidad del producto
                $data = Almacenes::where('branch_offices_id', $request->branch_offices_id)
                    ->where('stocks_id', $request['productid'][$key])
                    ->first();

                // se busca el producto y se actualiza
                $cantidad = $request['cant'][$key] + $data->quantity;
                $buscarinfo = Almacenes::find($data->id);
                $buscarinfo->quantity = $cantidad;
                $buscarinfo->save();
            } else {
                // creamos el producto
                Almacenes::create([
                    'stock_min' => 2,
                    'quantity' =>  $request['cant'][$key],
                    'branch_offices_id' => $request->branch_offices_id,
                    'stocks_id' => $request['productid'][$key]
                ]);
            }

        }
        return response()->json(["message" => "Guardado"], 200);
    }

    // calculos del costo promedio
    public function costoPromedio($stock_id, $sucursal_id, $cantidad_ingreso, $costo_ingreso){
        $precio = $this->validarPrecio($stock_id);
        // creamos una formula para multiplicar los precios actuales
        $almacenmain = Almacenes::where('branch_offices_id', '=', $sucursal_id)->where('stocks_id', '=', $stock_id)
            ->first();
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
        // para ver si ha subrido un cambio el precio
        if($precio['costosiniva'] == 0){
            $cambio = "nuevo";
        } else {
            if($costoPromedio > $precio['costosiniva']){
                $cambio = "subio";
            }
            if($costoPromedio == $precio['costosiniva']){
                $cambio = "mantiene";
            }
            if($costoPromedio < $precio['costosiniva']){
                $cambio = "bajo";
            }
        }
        // multiplicamos el nuevo costo con iva
        $precioconiva = $costoPromedio + ($costoPromedio * 0.13);
        // guardar en la table precios
        $resprecio = $this->guardarPrecios($stock_id, $costoPromedio,$precioconiva, $precio['ganancia'], $precio['porcentaje'], $precio['precioventa'], $cambio, $sumaCantidad, $almacenmain->id);

        $response = array(
            "costosiniva"       => $precio['costosiniva'], // este es el costo viejo
            "costoconiva"       => $precio['costoconiva'],
            "ganancia"          => $precio['ganancia'],
            "porcentaje"        => $precio['porcentaje'],
            "precioventa"       => $precio['precioventa'],
            "canxcostactual"    => $preciomain,
            "canxcostingres"    => $precioingreso,
            "cantidaai"         => $sumaCantidad,
            "subtotal"          => $sumoSubtotales,
            "costopromedio"     => $costoPromedio,
            "resprecio"         => $resprecio
        );
        return $response;
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

            $upprecioviejo = DetalleIngreso::find($precioviejo->id);
            $upprecioviejo->state = 10;
            $upprecioviejo->save();
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
            'producto_id' => $productoid,
            'costosiniva' => $costosin,
            'costoconiva' => $precioconiva,
            'ganancia' => $ganancia,
            'porcentaje' => $porcentaje,
            'precioventa' => $precioventa,
            'cambio' => $cambio,
        ]);
        if($precio){
        // actualizamos la cantidad de ingreso
            $update = Almacenes::find($almacenid);
            $update->quantity = $sumaCantidad;
            $update->save();
            if($update){
                $res = true;
            }
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
/*        $preciocantidad = Precios::where('producto_id', $producto_id)->get();
        if($preciocantidad->count() > 2){
            $precio = Precios::where('producto_id', $producto_id)
                ->limit(1)
                ->orderBy('id','DESC')
                ->first();
        } else {
            // vamos atraer el precio que este en estado 10 de la tabla vieja

            //$precioviejo = DetalleIngreso::where('detalle_stock_id', '=', $sucursal_id)->first();
        }*/
        $precioviejoingreso = Ingresos::where('stocks_id', $producto_id)
            ->orderBy('id','DESC')
            ->limit(2,1)
            ->get();
        $precioviejoingreso[1];
        return response()->json(["data" => $precioviejoingreso, "message" => "success"]);
    }
}
