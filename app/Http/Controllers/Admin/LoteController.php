<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Corretor;
use App\Models\Imobiliaria;
use App\Models\Lote;
use App\Models\Proprietario;
use App\Models\Quadra;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("lotes.index");
    }

    public function all()
    {
        $lotes = Lote::get()->all();
        return view("admin.lotes.index")->with("lotes", $lotes);
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

        $data['valor'] = str_replace(",", ".", $data['valor']);
        $data['valor'] = str_replace(".", "", $data['valor']);
        $data['valor'] /= 100;

        $lote->descricao = $data['descricao'];
        $lote->status = 'L';
        $lote->area = $data['area'];
        $lote->valor = $data['valor'];
        
        $lote->quadra_id = $quadra->id;

        $lote->save();

        return redirect("admin/quadras/{$data['quadra_id']}");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function show(Lote $lote)
    {
        // $lote = Lote::find($lote->id)-with(['agendamentos', 'agendamentos.cliente']);
        $corretores = Corretor::whereNull("imobiliaria_id")->get();
        $imobiliarias = Imobiliaria::has("corretores")->get();

        return view("admin.lotes.view")->with("lote", $lote)->with("corretores", $corretores)->with("imobiliarias", $imobiliarias);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function edit(Lote $lote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lote $lote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lote $lote)
    {
        $parent_id = $lote->quadra_id;
        $lote->delete();

        return redirect("admin/quadras/{$parent_id}");
    }

    public function adicionarProprietario(Lote $lote, Request $request){
        $request->validate([
            'documento'     => 'required',
            'nome'          => 'required',
            'data_inicio'   => 'required'
            // 'data_fim'      => ''
        ]);

        $data = $request->all();

        $lote = Lote::find($lote->id);

        $proprietario = new Proprietario();

        $proprietario->nome = $data['nome'];
        $proprietario->documento = $data['documento'];
        $proprietario->data_inicio = $data['data_inicio'];
        
        $proprietario->data_fim = $data['data_fim'] ?? null;
        
        $proprietario->lote_id = $lote->id;

        $proprietario->save();

        return redirect("admin/lotes/{$lote->id}");
    }

    public function removerProprietario(Proprietario $proprietario)
    {
        $parent_id = $proprietario->lote_id;
        $proprietario->delete();

        return redirect("admin/lotes/{$parent_id}");
    }

    public function vender(Lote $lote, Request $request)
    {
        $request->validate([
            "valor"             => 'required|numeric',
            "forma_pagamento"   => 'required',
            "numero_parcelas"   => 'required|numeric|min:1',
        ]);

        $dados = $request->all();

        $venda = new Venda;
        $venda->admin_id = Auth::user()->id;
        $venda->lote_id = $lote->id;
        $venda->user_id = $dados['user'];
        $venda->corretor_id = $dados['corretor'];

        $venda->nro_parcelas = $dados['numero_parcelas'];
        $venda->forma_pagamento = $dados['forma_pagamento'];
        $venda->valor = $dados['valor'];

        $venda->save();

        $lote->status = 'V'; // Lote vendido
        $lote->save();

        // Disparar email para cliente de lote vendido
        return back()->with("success", "Este lote foi vendido");
    }
}
