<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Corretor;
use App\Models\Imobiliaria;
use Illuminate\Http\Request;

class CorretorController extends Controller
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

    public function all()
    {
        $corretores = Corretor::get()->all();
        return view("admin.corretores.index")->with("corretores", $corretores);
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
            'documento'     => 'required',
            'celular'     => 'required'
        ]);

        $data = $request->all();

        $imobiliaria_id = $data['imobiliaria_id'] ?? 0;
        $imobiliaria = Imobiliaria::find($imobiliaria_id);
        if(!$imobiliaria){
            $imobiliaria_id = 0;
        }

        $corretorSearch = Corretor::where("documento", $data['documento'])->first();

        if($corretorSearch){
            $return['message'] = "Documento já cadastrado";
        } else{

            $corretor = new Corretor();

            $corretor->nome = $data['nome'];
            $corretor->documento = $data['documento'];
            $corretor->taxa_venda_porcentagem = $data['taxa_venda_porcentagem'] ?? 0;
            $corretor->taxa_venda_valor = $data['taxa_venda_valor'] ?? 0;
            $corretor->celular = $data['celular'];
            $corretor->imobiliaria_id = $imobiliaria_id;

            $corretor->ativo = true;

            $corretor->save();

            $return['success'] = true;
        }

        $redirect = "admin/corretores";

        if($imobiliaria_id != 0)
            $redirect = "admin/imobiliarias/{$imobiliaria_id}";

        return redirect($redirect);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Corretor  $corretor
     * @return \Illuminate\Http\Response
     */
    public function show(Corretor $corretor)
    {
        return view("admin.corretores.view")->with("corretor", $corretor);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Corretor  $corretor
     * @return \Illuminate\Http\Response
     */
    public function edit(Corretor $corretor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Corretor  $corretor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Corretor $corretor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Corretor  $corretor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Corretor $corretor)
    {
        $imobiliaria_id = $corretor->imobiliaria_id;
        $corretor->delete();

        $redirect = "admin/corretores";
        if($imobiliaria_id != 0)
            $redirect = "admin/imobiliarias/{$imobiliaria_id}";

        return redirect($redirect);
    }
}
