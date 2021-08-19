<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loteamento;
use App\Models\Quadra;
use Illuminate\Http\Request;

class QuadraController extends Controller
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
        $request->validate([
            'loteamento_id' => 'required',
            'descricao'     => 'required'
        ]);

        $data = $request->all();

        $loteamento = Loteamento::find($data['loteamento_id']);

        $quadra = new Quadra;

        $quadra->descricao = $data['descricao'];
        $quadra->loteamento_id = $loteamento->id;

        $quadra->save();

        return view("admin.loteamentos.view")->with("loteamento", $loteamento);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quadra  $quadra
     * @return \Illuminate\Http\Response
     */
    public function show(Quadra $quadra)
    {
        // var_dump($quadra);
        // die;
        return view("admin.quadras.view")->with("quadra", $quadra);
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
