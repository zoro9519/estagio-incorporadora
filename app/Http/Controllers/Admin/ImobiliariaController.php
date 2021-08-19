<?php

namespace App\Http\Controllers\Admin;

use App\Models\Imobiliaria;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImobiliariaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view("admin.imobiliarias.index");
    }

    public function all()
    {
        $imobiliarias = Imobiliaria::get()->all();
        return view("admin.imobiliaria.index")->with("imobiliarias", $imobiliarias);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Imobiliaria  $imobiliaria
     * @return \Illuminate\Http\Response
     */
    public function show(Imobiliaria $imobiliaria)
    {
        return view("admin.imobiliaria.view")->with("imobiliaria", $imobiliaria);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Imobiliaria  $imobiliaria
     * @return \Illuminate\Http\Response
     */
    public function edit(Imobiliaria $imobiliaria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Imobiliaria  $imobiliaria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Imobiliaria $imobiliaria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Imobiliaria  $imobiliaria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Imobiliaria $imobiliaria)
    {
        //
    }
}
