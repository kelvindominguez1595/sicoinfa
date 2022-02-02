<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriasController extends Controller
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
        $name = $request->name;
        if(!empty($request->name)){
            $query = DB::table('categories')
                ->select('id','name', 'state');
            $query->where('name','LIKE', '%'.$request->name.'%');
            $data = $query->paginate($pages);

        } else {
            $data = Categorias::paginate($pages);
        }
        return view('categorias.index', compact('data', 'name', 'pages'));
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
        $data = Categorias::create($request->all());
        if($data){
            $message = "Nueva categoría registrada correctamente";
            $code = 200;
        } else {
            $message = "No se pudo registrar la categoría";
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
        $data = DB::table('categories as ma')
            ->join('stocks as s', 'ma.id', '=', 's.category_id')
            ->select('ma.id','ma.name', DB::raw("COUNT(s.id) as marcacount"), 's.category_id')
            ->where('s.category_id', '=', $id)
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
        $data = Categorias::find($id);
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
        $data = Categorias::find($id);
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
        $data = Categorias::find($id);
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
