<?php

namespace App\Http\Controllers;

use App\Models\Almacenes;
use App\Models\DatosIngresos;
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
        /**
         * *************** PASO 1 ***************
         * Realizamos el ingreso a la tabla ingresos
         */
        $ingre = Ingresos::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'register_date' => $request->register_date,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'stocks_id' => $stock_id,
            'state' => 1,
            'clientefacturas_id' => $request->suppliers_id,
        ]);
        /**
         * *************** PASO 2 ***************
         * Realizamos el calculo de multiplicar costo stock actual por cantidad actual
         * y multiplicar costo ingreso por cantidad ingresos luego sumar cantidad y subtotales
         * por ultimo divitor suma de subtotales entre suma de cantidad
         * RESULTADO ES EL COSTO PROMEDIO NUEVO
         */
        /** BUSCAMOS EL ultimo INGRESO */
        $ultimoingreso = Ingresos::where('stocks_id', $stock_id)
            ->limit(1)
            ->orderBy('id','DESC')
            ->first();

        /**
         * *************** PASO 3 ***************
         * Buscamos el producto en el almacen
         * si existe actualizamos si no creamos en el almacen principal
         */

        // aqui debemos de verificar si ya existe el producto
        $data = Almacenes::where('branch_offices_id', $request->branch_offices_id)
            ->where('stocks_id', $stock_id)
            ->first();
        // si ya existe el producto debemos de sumar
        if($data){
            // se busca el producto y se actualiza
            $cantidad = $request->quantity + $data->quantity;
            $almacen = Almacenes::find($data->id);
            $almacen->quantity = $cantidad;
            $almacen->save();
        } else {
            Almacenes::create([
                'stock_min' => 2,
                'quantity' => $request->quantity,
                'branch_offices_id' => $request->branch_offices_id,
                'stocks_id' => $stock_id
            ]);
        }


        $iva = $request->unit_price  + ($request->unit_price * 0.13);
      return response()->json(["message" => 200, 'sinva' =>$request->unit_price, 'coniva' =>  $iva ]);
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

}
