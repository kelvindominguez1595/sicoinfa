<?php

namespace App\Http\Controllers;

use App\Models\Proveedores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProveedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!empty($request->pages)) {
            $pages = $request->pages;
        } else {
            $pages = 25;
        }
        if (!empty($request->estado)) {
            if($request->estado == 'activos'){
                $estado = 1;
            } else {
                $estado = 2;
            }
        } else {
            $estado = 1;
        }
        $proveedor = $request->proveedor;
        $negocio = $request->negocio;
        $giro = $request->giro;
        $nit = $request->nit;
        $registro = $request->registro;

        if(
            !empty($proveedor) OR
            !empty($negocio) OR
            !empty($giro) OR
            !empty($nit) OR
            !empty($registro) OR
            !empty($estado)
        ){
            $query = DB::table('clientefacturas')
                ->select('id', 'cliente', 'nombre_comercial', 'giro', 'nit', 'num_registro', 'state');
            if(!empty($proveedor)) {
                $query->where('cliente', 'LIKE', '%'.$proveedor.'%');
            }
            if(!empty($negocio)) {
                $query->where('nombre_comercial', 'LIKE', '%'.$negocio.'%');
            }
            if(!empty($giro)) {
                $query->where('giro', 'LIKE', '%'.$giro.'%');
            }
            if(!empty($nit)) {
                $query->where('nit', 'LIKE', '%'.$nit.'%');
            }
            if(!empty($registro)) {
                $query->where('num_registro', 'LIKE', '%'.$registro.'%');
            }
            if(!empty($estado)) {
                $query->where('state', '=', $estado);
            }
            $data = $query->paginate($pages);
        } else {
            $data = Proveedores::where('state', 1)->paginate($pages);
        }
        return view('proveedores.index', compact('data', 'proveedor', 'negocio', 'giro', 'nit', 'registro', 'pages', 'estado'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // si el registro es de tipo de cliente 3 es un proveedor
        $data = Proveedores::create([
            'cliente' => $request->cliente,
            'direccion' => $request->direccion,
            'nombre_comercial' => $request->nombre_comercial,
            'razon_social' => $request->razon_social,
            'giro' => $request->giro,
            'nit' => $request->nit,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'num_registro' => $request->num_registro,
            'tipo_cliente' => 3,
            'state' => $request->estado,
        ]);
        if($data){
            $message = "Nuevo proveedor registrado correctamente";
            $code = 200;
        } else {
            $message = "No se pudo registrar el proveedor";
            $code = 400;
        }
        return response()->json(["message" => $message], $code);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $data = Proveedores::find($id);
       return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Proveedores::find($id);
        $data->cliente          = $request->cliente;
        $data->direccion        = $request->direccion;
        $data->nombre_comercial = $request->nombre_comercial;
        $data->razon_social     = $request->razon_social;
        $data->giro             = $request->giro;
        $data->nit              = $request->nit;
        $data->email            = $request->email;
        $data->telefono         = $request->telefono;
        $data->num_registro     = $request->num_registro;
        $data->state            = $request->estado;
        $data->save();
        if($data){
            $message = "Registro actualizado correctamente";
            $code = 200;
        } else {
            $message = "No se pudo actualizar el proveedor";
            $code = 400;
        }
        return response()->json(["message" => $message], $code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Proveedores::find($id);
        $data->delete();
        if($data){
            $message = "El registro se ha borrado!";
            $code = 200;
        } else {
            $message = "Ah ocurrido un error";
            $code = 400;
        }
        return response()->json(["message" => $message], $code);
    }

    public function desactivarproveedores($id) {
        $data = Proveedores::find($id);
        if( $data->state == 1){
            $data->state = 2;
        } else {
            $data->state = 1;
        }
        $data->save();
        if($data){
            $message = true;
            $code = 200;
        } else {
            $message = false;
            $code = 400;
        }
        return response()->json(["message" => $message], $code);
    }
}
