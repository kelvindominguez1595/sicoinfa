<?php

namespace App\Http\Controllers;

use App\Models\Marcas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarcasController extends Controller
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
        $marca = $request->marca;
        if(!empty($request->marca)){
            $query = DB::table('manufacturers')
            ->select('id','name', 'state');
            $query->where('name','LIKE', '%'.$request->marca.'%');
            $data = $query->paginate($pages);

        } else {
            $data = Marcas::paginate($pages);
        }
        return view('marcas.index', compact('data', 'marca', 'pages'));
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
        $marca = Marcas::create($request->all());
        if($marca){
            $message = "Nueva marca registrada correctamente";
            $code = 200;
        } else {
            $message = "No se pudo registrar la marca";
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

        $data = DB::table('manufacturers as ma')
            ->join('stocks as s', 'ma.id', '=', 's.manufacturer_id')
            ->select('ma.id','ma.name', DB::raw("COUNT(s.id) as marcacount"), 's.manufacturer_id')
            ->where('s.manufacturer_id', '=', $id)
            ->first();
        return response()->json([$data],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Marcas::find($id);
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
        $data = Marcas::find($id);
        $data->name = $request->name;
        $data->save();
        if($data){
            $message = "Registro actualizado correcatemente";
            $code = 200;
        } else {
            $message = "No se pudo registrar la marca";
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
        $data = Marcas::find($id);
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
}
