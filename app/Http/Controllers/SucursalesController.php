<?php

namespace App\Http\Controllers;

use App\Models\Sucursales;
use App\Http\Requests\StoreSucursalesRequest;
use App\Http\Requests\UpdateSucursalesRequest;

class SucursalesController extends Controller
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
     * @param  \App\Http\Requests\StoreSucursalesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSucursalesRequest $request)
    {
        //
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
    public function edit(Sucursales $sucursales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSucursalesRequest  $request
     * @param  \App\Models\Sucursales  $sucursales
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSucursalesRequest $request, Sucursales $sucursales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sucursales  $sucursales
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sucursales $sucursales)
    {
        //
    }
}
