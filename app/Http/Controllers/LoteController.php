<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lote;
use App\Models\Loteamento;
use App\Models\Quadra;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("loteamentos.index");
    }

    public function all()
    {
        $loteamentos = Quadra::get()->all();
        return view("admin.quadras.index")->with("loteamentos", $loteamentos);
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

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function show(Lote $lote)
    {
        return view("admin.lote.view")->with("lote", $lote);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loteamento  $loteamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Loteamento $loteamento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loteamento  $loteamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loteamento $loteamento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loteamento  $loteamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loteamento $loteamento)
    {
        //
    }
}
