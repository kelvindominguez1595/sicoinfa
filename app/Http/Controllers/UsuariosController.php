<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Sucursales;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $nombre     = $request->namesearch;
        $email     = $request->emailsearch;
        $almacen   = $request->almacensearch;

        if(empty($request->statesearch)){
            $state = 1;
        }else{
            $state  = $request->statesearch;
        }
        $query = User::where('state', '=', $state);
        if(!empty($request->namesearch)){
            $query->where('name', 'LIKE', '%'.$request->namesearch.'%');
        }
        if(!empty($request->emailsearch)){
            $query->where('email', 'LIKE', '%'.$request->emailsearch.'%');
        }
        if(!empty($request->almacensearch)){
            $query->where('branch_offices_id', '=', $request->almacensearch);
        }

        $data = $query->paginate(25);
        $sucursal = Sucursales::all();
        $rol = Role::all();
        if($request->ajax()){
            return response()->json(view('usuarios.partials.table', compact('data', 'nombre', 'email', 'almacen', 'state', 'sucursal', 'rol'))->render());
        }
        return view('usuarios.index', compact('data', 'nombre', 'email', 'almacen', 'state', 'sucursal', 'rol'));
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

        if(!isset($request->id)){
            $data = new User();
            $data->name                 = $request->name;
            $data->email                = $request->email;
            $data->password             = Hash::make($request['password']);
            $data->branch_offices_id    = $request->branch_offices_id;
            $data->state                = $request->state;
            if($request->hasFile("picture")){
                $imagen         = $request->file("picture");
                $nombreimagen   = time().".".$imagen->guessExtension();
                $ruta           = public_path()."/images/usuarios/";
                $imagen->move($ruta, $nombreimagen);
                $data->picture          = $nombreimagen;
            }
            $data->save();
            $r = Role::find($request->rol);
            RoleUser::create([
                'role_id' => $r->id,
                'user_id' => $data->id
            ]);
            $message = "Nuevo Usuario registrado";
        } else {
            $data = User::find($request->id);
            $data->name                 = $request->name;
            $data->email                = $request->email;
            if(!empty($request->password)){
                $data->password             = Hash::make($request->password);
            }
            $data->branch_offices_id    = $request->branch_offices_id;
            if(empty($request->state)){
                $sta = 2;
            } else {
                $sta = 1;
            }
            $data->state  = $sta;
//            $data->roles()->attach(Role::where('id', $request->rol)->first());
            if($request->hasFile("picture")){
                $imagen         = $request->file("picture");
                $nombreimagen   = time().".".$imagen->guessExtension();
                $ruta           = public_path()."/images/usuarios/";
                $imagen->move($ruta, $nombreimagen);
                $data->picture          = $nombreimagen;
            }
            $data->save();
            $message = "Datos actualizados correctamente";
        }



        return response()->json(["message" => $message],200);
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
        $data = User::find($id);
        $rol = DB::table('role_user')
            ->where('user_id', $id)
            ->first();
        return response()->json(["data" => $data, "rol" => $rol], 200);
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = User::find($id);
        $data->delete();
        return response()->json(["message" => "Datos borrados"],200);
    }

    public function profile()
    {
        $data = User::find(Auth::user()->id);
        $sucursal = Sucursales::all();
        $rol = Role::all();
        $rolselect = DB::table('role_user')
            ->where('user_id', Auth::user()->id)
            ->first();
        return view('usuarios.profile', compact('data', 'sucursal', 'rol', 'rolselect'));
    }

    public function customLogin(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/')
                ->withSuccess('Signed in');
        }
        return redirect("login")->withSuccess('Login details are not valid');

    }
}
