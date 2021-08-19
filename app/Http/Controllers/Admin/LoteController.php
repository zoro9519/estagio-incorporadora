<?php

namespace App\Http\Controllers\Admin;

use App\Models\Loteamento;
use App\Http\Controllers\Controller;
use App\Models\Lote;
use App\Models\Proprietario;
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
        $loteamentos = Loteamento::get()->all();
        return view("admin.loteamentos.index")->with("loteamentos", $loteamentos);
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
            'quadra_id'     => 'required',
            'descricao'     => 'required',
            'area'          => 'required',
            'valor'         => 'required',
        ]);

        $data = $request->all();

        $quadra = Quadra::find($data['quadra_id']);

        $lote = new Lote();

        $lote->descricao = $data['descricao'];
        $lote->status = 'L';
        $lote->area = $data['area'];
        $lote->valor = $data['valor'];
        
        $lote->quadra_id = $quadra->id;

        $lote->save();

        return view("admin.quadras.view")->with("quadra", $quadra);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function show(Lote $lote)
    {
        // var_dump($lote);
        // die;
        
        return view("admin.lotes.view")->with("lote", $lote);
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

    public function adicionarProprietario(Lote $lote, Request $request){
        $request->validate([
            'documento'     => 'required',
            'nome'          => 'required',
            'data_inicio'   => 'required',
            'data_fim'      => 'required'
        ]);

        $data = $request->all();

        $lote = Lote::find($lote->id);

        $proprietario = new Proprietario();

        $proprietario->nome = $data['nome'];
        $proprietario->documento = $data['documento'];
        $proprietario->data_inicio = $data['data_inicio'];
        $proprietario->data_fim = $data['data_fim'];
        
        $proprietario->lote_id = $lote->id;

        $proprietario->save();

        return view("admin.lotes.view")->with("lote", $lote);
    }
}
