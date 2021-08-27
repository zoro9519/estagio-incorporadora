<?php

namespace App\Http\Controllers\Admin;

use App\Models\Loteamento;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoteamentoController extends Controller
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
        $return = [
            'success' => false,
        ];

        $request->validate([
            'nome' => 'required',
            'descricao'     => 'required',
            'link'     => 'required',
            'area'     => 'required'
        ]);

        $data = $request->all();

        $loteamentoSearch = Loteamento::where("nome", $data['nome'])->orWhere("link", $data['link'])->first();

        if($loteamentoSearch){
            $return['message'] = "Nome já cadastrado";

            if(strtolower($loteamentoSearch->link) == strtolower($data['link']))
                $return['message'] = 'Link já cadastrado. Tente outros valores';
        } else{

            $loteamento = new Loteamento();

            $loteamento->nome = $data['nome'];
            $loteamento->descricao = $data['descricao'];
            $loteamento->link = $data['link'];
            $loteamento->area = $data['area'];
            $loteamento->coordenada_id = 0;

            $loteamento->save();

            $return['success'] = true;
        }

        return redirect("admin/loteamentos");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loteamento  $loteamento
     * @return \Illuminate\Http\Response
     */
    public function show(Loteamento $loteamento)
    {
        return view("admin.loteamentos.view")->with("loteamento", $loteamento);
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
