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
        return view("admin.imobiliarias.index")->with("imobiliarias", $imobiliarias);
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
            'razao_social'     => 'required',
            'cnpj'     => 'required',
            'creci'     => 'required',
            'email'     => 'required',
            'logradouro'     => 'required',
            'numero'     => 'required',
            'bairro'     => 'required',
            'cep'     => 'required',
            'uf'     => 'required'
        ]);

        $data = $request->all();

        $imobiliariaSearch = Imobiliaria::where("cnpj", $data['cnpj'])->orWhere("razao_social", $data['razao_social'])->first();

        if($imobiliariaSearch){
            $return['message'] = "CNPJ já cadastrado";

            if(strtolower($imobiliariaSearch->razao_social) == strtolower($data['razao_social']))
                $return['message'] = 'Razão Social já cadastrada';
        } else{

            $imobiliaria = new Imobiliaria();

            $imobiliaria->nome = $data['nome'];
            $imobiliaria->cnpj = $data['cnpj'];
            $imobiliaria->razao_social = $data['razao_social'];
            $imobiliaria->creci = $data['creci'];
            $imobiliaria->email = $data['email'];

            $imobiliaria->logradouro = $data['logradouro'];
            $imobiliaria->numero = $data['numero'];
            $imobiliaria->bairro = $data['bairro'];
            $imobiliaria->complemento = $data['complemento'] ?? "";
            $imobiliaria->cidade = $data['cidade'];
            $imobiliaria->cep = $data['cep'];
            $imobiliaria->uf = $data['uf'];

            $imobiliaria->status = true;

            $imobiliaria->save();

            $return['success'] = true;
        }

        return redirect("admin/imobiliarias");
        // return redirect()->route("imobiliarias.all")->with("error", __("")));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Imobiliaria  $imobiliaria
     * @return \Illuminate\Http\Response
     */
    public function show(Imobiliaria $imobiliaria)
    {
        return view("admin.imobiliarias.view")->with("imobiliaria", $imobiliaria);
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
        $imobiliaria->delete();

        return redirect("admin/imobiliarias");
    }
}
