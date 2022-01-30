<?php

namespace App\Http\Controllers;

use App\Models\Almacenes;
use App\Models\Ingresos;
use App\Models\Precios;
use App\Http\Requests\StoreIngresosRequest;
use App\Http\Requests\UpdateIngresosRequest;
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
        //
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
        // si el precio sin iva camabia debemos de hgacer la formula para registrar un nuevo precio
        // pregunto sobre el ultimo precio registrado
        $ingreso = Ingresos::where('stocks_id', '=', $stock_id)
            ->limit(1)
            ->orderBy('id','DESC')
            ->first();

        // si es prinera ves el nuevo producto
        if(empty($ingreso ->id)){
            // creo el producto en stock si no esta
            $ds = Ingresos::create([
                'invoice_number' => $request->invoice_number,
                'invoice_date' => $request->invoice_date,
                'register_date' => $request->register_date,
                'quantity' => $request->quantity,
                'unit_price' => $request->unit_price,
                'stocks_id' => $stock_id,
                'state' => 1,
                'clientefacturas_id' => $request->suppliers_id,
            ]);
            // si no hay precios lo agregamos
            Precios::create([
                'cost_s_iva' => $request->unit_price,
                'cost_c_iva' => 0,
                'earn_c_iva' => 0,
                'earn_porcent' => 0,
                'sale_price' => 0,
                'detalle_stock_id' => $ds->id
            ]);
            // lo creo en el almacen que corresponde
            Almacenes::create([
                'stock_min' => 2,
                'quantity' => $request->quantity,
                'branch_offices_id' => $request->branch_offices_id,
                'stocks_id' => $stock_id
            ]);
        } else {
            $priceingreso = Precios::where('detalle_stock_id', '=', $ingreso->id)
                ->limit(1)
                ->orderBy('detalle_stock_id','DESC')
                ->first();

            if(empty($priceingreso->cost_s_iva)) {
                // creara un nuevo ingreso
                $ds = Ingresos::create([
                    'invoice_number' => $request->invoice_number,
                    'invoice_date' => $request->invoice_date,
                    'register_date' => $request->register_date,
                    'quantity' => $request->quantity,
                    'unit_price' => $request->unit_price,
                    'stocks_id' => $stock_id,
                    'state' => 1,
                    'clientefacturas_id' => $request->suppliers_id,
                ]);
                // aqui debemos de verificar si ya existe el producto
                $data = Almacenes::where('branch_offices_id', $request->branch_offices_id)
                    ->where('stocks_id', $stock_id)
                    ->first();
                // si ya existe el producto debemos de sumar
                if($data){
                    $cantidad = $request->quantity + $data->quantity;
                    // se busca el producto y se actualiza
                    $cantidad = $request->quantity + $data->quantity;
                    $buscarinfo = Almacenes::find($data->id);
                    $buscarinfo->quantity = $cantidad;
                    $buscarinfo->save();
                    //   toastr()->success('Nuevo ingreso de producto realizado correctamente');
                } else {
                    Almacenes::create([
                        'stock_min' => 2,
                        'quantity' => $request->quantity,
                        'branch_offices_id' => $request->branch_offices_id,
                        'stocks_id' => $stock_id
                    ]);
                    //   toastr()->success('se ha ingresado un producto pero el costo es el mismo');
                }
                // si no hay precios lo agregamos
                Precios::create([
                    'cost_s_iva' => $request->unit_price,
                    'cost_c_iva' => 0,
                    'earn_c_iva' => 0,
                    'earn_porcent' => 0,
                    'sale_price' => 0,
                    'detalle_stock_id' => $ds->id
                ]);
            } else {
                // si el costos igual a cero no hacer nada ya que por ende los productos ingresado no estan en inventario
                if($priceingreso->cost_s_iva !== 0){
                    // validamos los costos sin iva
                    if($request->unit_price !== $priceingreso->cost_s_iva){
                        // los costos son diferentes // debo alertar que debe de modificar los precios de venta
                        // esto es obligatorio registrar porque es el ingreso del producto
                        Ingresos::create([
                            'invoice_number' => $request->invoice_number,
                            'invoice_date' => $request->invoice_date,
                            'register_date' => $request->register_date,
                            'quantity' => $request->quantity,
                            'unit_price' => $request->unit_price,
                            'stocks_id' => $stock_id,
                            'state' => 1,
                            'clientefacturas_id' => $request->suppliers_id,
                        ]);
                    }
                }
                // aqui debemos de verificar si ya existe el producto
                $data = Almacenes::where('branch_offices_id', $request->branch_offices_id)
                    ->where('stocks_id', $stock_id)
                    ->first();
                if($data){
                    // se busca el producto y se actualiza
                    $cantidad = $request->quantity + $data->quantity;
                    $buscarinfo = Almacenes::find($data->id);
                    $buscarinfo->stock_min = 2;
                    $buscarinfo->quantity = $cantidad;
                    $buscarinfo->save();

                    // toastr()->success('Nuevo ingreso de producto realizado correctamente');
                } else {   // si no esta se crea el producto
                    Almacenes::create([
                        'stock_min' => 2,
                        'quantity' => $request->quantity,
                        'branch_offices_id' => $request->branch_offices_id,
                        'stocks_id' => $stock_id
                    ]);
                    // toastr()->success('se ha ingresado un producto pero el costo es el mismo');
                }
            }
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
}
