<?php

namespace App\Http\Controllers;
use App\Models\Clientes;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('clientes.index');
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
        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required'
        ]);
        Clientes::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'dui' => $request->dui,
            'nit' => $request->nit,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'tipo_cliente' => $request->tipocliente,
            'state' => $request->state,
        ]);
        return response()->json(["message" => "Nuevo cliente registrado"],200);
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
        $data = Clientes::find($id);
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
        $data = Clientes::find($id);
        $data->nombres      = $request->nombres;
        $data->apellidos    = $request->apellidos;
        $data->dui          = $request->dui;
        $data->nit          = $request->nit;
        $data->telefono     = $request->telefono;
        $data->direccion    = $request->direccion;
        $data->tipo_cliente = $request->tipocliente;
        $data->state        = $request->state;
        $data->save();
        return response()->json(["message" => "Datos Actualizados"],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Clientes::find($id);
        $data->delete();
        return response()->json(["message" => "Datos borrados"],200);
    }

    public function clientesList(Request $request){
        $nombres    = $request->nombressearch;
        $apellidos  = $request->apellidossearch;
        $dui        = $request->duisearch;
        $telefono   = $request->telefonosearch;
        $query = Clientes::where('tipo_cliente', '=', 1);
        if(!empty($request->nombressearch)){
            $query->where('nombres', 'LIKE', '%'.$request->nombressearch.'%');
        }
        if(!empty($request->apellidossearch)){
            $query->where('apellidos', 'LIKE', '%'.$request->apellidossearch.'%');
        }
        if(!empty($request->duisearch)){
            $query->where('dui', 'LIKE', '%'.$request->duisearch.'%');
        }
        if(!empty($request->telefonosearch)){
            $query->where('telefono', 'LIKE', '%'.$request->telefonosearch.'%');
        }
        $clientes = $query->paginate(25);
        if($request->ajax()){
            return response()->json(view('clientes.partials.clientetbl', compact('clientes', 'nombres', 'apellidos', 'dui', 'telefono'))->render());
        }
        return view('clientes.index', compact('clientes', 'nombres', 'apellidos', 'dui', 'telefono'));
    }

    public function contribuyentesList(Request $request){
        $nombres    = $request->nombressearch;
        $apellidos  = $request->apellidossearch;
        $dui        = $request->duisearch;
        $nit        = $request->nitsearch;
        $telefono   = $request->telefonosearch;
        $query = Clientes::where('tipo_cliente', '=', 2);
        if(!empty($request->nombressearch)){
            $query->where('nombres', 'LIKE', '%'.$request->nombressearch.'%');
        }
        if(!empty($request->apellidossearch)){
            $query->where('apellidos', 'LIKE', '%'.$request->apellidossearch.'%');
        }
        if(!empty($request->duisearch)){
            $query->where('dui', 'LIKE', '%'.$request->duisearch.'%');
        }
        if(!empty($request->nitsearch)){
            $query->where('nit', 'LIKE', '%'.$request->nitsearch.'%');
        }
        if(!empty($request->telefonosearch)){
            $query->where('telefono', 'LIKE', '%'.$request->telefonosearch.'%');
        }
        $contribu = $query->paginate(25);
        if($request->ajax()){
            return response()->json(view('clientes.partials.contribuyentetbl', compact('contribu', 'nombres', 'apellidos', 'dui', 'nit', 'telefono'))->render());
        }
        return view('clientes.index', compact('contribu', 'nombres', 'apellidos', 'dui', 'nit', 'telefono'));
    }


    /** AQUI ESTARAN LOS REPORTES EN EXCEL Y PDF */
}
