<?php

namespace App\Http\Controllers;

use App\Models\Sucursales;
use Illuminate\Http\Request;

class SucursalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('sucursales.index');
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
     * @param  \App\Http\Requests\StoreSucursalesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Sucursales::create($request->all());
        return response()->json(["message" => "Nueva sucursal registrada"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sucursales  $sucursales
     * @return \Illuminate\Http\Response
     */
    public function show(Sucursales $sucursales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sucursales  $sucursales
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Sucursales::find($id);
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSucursalesRequest  $request
     * @param  \App\Models\Sucursales  $sucursales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Sucursales::find($id);
        $data->name     = $request->name;
        $data->phone    = $request->phone;
        $data->address  = $request->address;
        $data->state    = $request->state;
        $data->save();
        return response()->json(["message" => "Sucursal Actualizada correctamente!"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sucursales  $sucursales
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Sucursales::find($id);
        $data->delete();
        return response()->json(["message" => "Sucursal borrada correctamente!"]);
    }

    function listsubcursal(Request $request){
        $nombre    = $request->namesearch;
        $phone     = $request->phonesearch;
        if(empty($request->statesearch)){
            $state = 1;
        }else{
            $state  = $request->statesearch;
        }
        $query = Sucursales::where('state', $state);
        if(!empty($request->namesearch)){
            $query->where('name', 'LIKE', '%'.$request->namesearch.'%');
        }
        if(!empty($request->phonesearch)){
            $query->where('phone', 'LIKE', '%'.$request->phonesearch.'%');
        }

        $data = $query->paginate(25);
        if($request->ajax()){
            return response()->json(view('sucursales.partials.table', compact('data', 'nombre', 'phone', 'state' ))->render());
        }
        return view('sucursales.index', compact('data', 'nombre', 'phone', 'state'));

    }
}
