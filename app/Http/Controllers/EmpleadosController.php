<?php

namespace App\Http\Controllers;

use App\Models\Empleados;
use Illuminate\Http\Request;

class EmpleadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('empleados.index');
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
            'first_name' => 'required',
            'last_name' => 'required',
            'codigo' => 'required',
            'address' => 'required',
        ]);
        Empleados::create($request->all());
        return response()->json(["message" => "Nuevo Empleado registrado"],200);
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
       $data = Empleados::find($id);
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
        $data = Empleados::find($id);
        $data->codigo       = $request->codigo;
        $data->first_name   = $request->first_name;
        $data->last_name    = $request->last_name;
        $data->email        = $request->email;
        $data->dui          = $request->dui;
        $data->nit          = $request->nit;
        $data->nup          = $request->nup;
        $data->isss         = $request->isss;
        $data->phone        = $request->phone;
        $data->address      = $request->address;
        if(empty($request->state)){
            $sta = 2;
        } else {
            $sta = 1;
        }
        $data->state        = $sta;
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
        $data = Empleados::find($id);
        $data->delete();
        return response()->json(["message" => "Datos borrados"],200);
    }
    public function listdateemp(Request $request){
        $codigo     = $request->codigosearch;
        $nombre     = $request->first_namesearch;
        $apellido   = $request->last_namesearch;
        $email      = $request->emailsearch;
        $dui        = $request->duisearch;
        $nit        = $request->nitsearch;
        $nup        = $request->nupsearch;
        $iss        = $request->issssearch;
        $phone      = $request->phonesearch;
        if(empty($request->statesearch)){
            $state = 1;
        }else{
            $state  = $request->statesearch;
        }
        $query = Empleados::where('state', '=', $state);
        if(!empty($request->codigosearch)){
            $query->where('codigo', 'LIKE', '%'.$request->codigosearch.'%');
        }
        if(!empty($request->first_namesearch)){
            $query->where('first_name', 'LIKE', '%'.$request->first_namesearch.'%');
        }
        if(!empty($request->last_namesearch)){
            $query->where('last_name', 'LIKE', '%'.$request->last_namesearch.'%');
        }
        if(!empty($request->emailsearch)){
            $query->where('email', 'LIKE', '%'.$request->emailsearch.'%');
        }

        if(!empty($request->duisearch)){
            $query->where('dui', 'LIKE', '%'.$request->duisearch.'%');
        }

        if(!empty($request->nitsearch)){
            $query->where('nit', 'LIKE', '%'.$request->nitsearch.'%');
        }

        if(!empty($request->nupsearch)){
            $query->where('nup', 'LIKE', '%'.$request->nupsearch.'%');
        }

        if(!empty($request->issssearch)){
            $query->where('isss', 'LIKE', '%'.$request->issssearch.'%');
        }

        if(!empty($request->phonesearch)){
            $query->where('phone', 'LIKE', '%'.$request->phonesearch.'%');
        }

        $data = $query->paginate(25);
        if($request->ajax()){
            return response()->json(view('empleados.partials.table', compact('data', 'codigo', 'nombre', 'apellido', 'email', 'dui', 'nit', 'nup', 'iss', 'phone', 'state' ))->render());
        }
        return view('empleados.index', compact('data', 'codigo', 'nombre', 'apellido', 'email', 'dui', 'nit', 'nup', 'iss', 'phone', 'state'));
    }
}
