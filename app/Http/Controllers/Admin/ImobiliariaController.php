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
            'message' => []
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
            $return['message'][] = "CNPJ já cadastrado";

            if(strtolower($imobiliariaSearch->razao_social) == strtolower($data['razao_social']))
                $return['message'][] = 'Razão Social já cadastrada';
        } 
        
        if(empty($return['message'])){

            $imobiliaria = new Imobiliaria();

            $imobiliaria->nome = $data['nome'];
            $imobiliaria->cnpj = $data['cnpj'];
            $imobiliaria->razao_social = $data['razao_social'];
            $imobiliaria->creci = $data['creci'];
            $imobiliaria->email = $data['email'];
            $imobiliaria->phone = $data['phone'];

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

        $return['message'] = implode("<br>", $return['message']);

        return redirect("admin/imobiliarias")->with('return', $return);
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
        return view("admin.imobiliarias.edit")->with('imobiliaria', $imobiliaria);
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
        $return = [
            'success' => false,
            'message' => []
        ];
        
        $data = $request->all();

        if(empty($data['nome'])) {
            $return['message'][] = "Nome precisa ser preenchido";
        }
        if(empty($data['razao_social'])) {
            $return['message'][] = "Razão Social precisa ser preenchida";
        }
        if(empty($data['cnpj'])) {
            $return['message'][] = "CNPJ precisa ser preenchido";
        }
        if(Imobiliaria::where("cnpj", $data['cnpj'])->where('id', '!=', $imobiliaria->id)->count()) {
            $return['message'][] = 'CNPJ já cadastrado na base';
        }
        if(empty($data['phone'])) {
            $return['message'][] = "Celular precisa ser preenchido";
        }
        if(empty($data['email'])) {
            $return['message'][] = "Email precisa ser preenchido";
        }
        if(Imobiliaria::where("email", $data['email'])->where('id', '!=', $imobiliaria->id)->count()) {
            $return['message'][] = 'Email já cadastrado na base';
        }
        if(empty($data['cep'])) {
            $return['message'][] = 'CEP precisa ser preenchido';
        }
        if(empty($data['logradouro'])) {
            $return['message'][] = 'Logradouro precisa ser preenchido';
        }
        if(empty($data['bairro'])) {
            $return['message'][] = 'Bairro precisa ser preenchido';
        }
        if(empty($data['cidade'])) {
            $return['message'][] = 'Cidade precisa ser preenchida';
        }
        if(empty($data['uf'])) {
            $return['message'][] = 'UF precisa ser preenchida';
        }
        
        if(empty($return['message'])) {
            $imobiliaria->nome = $data['nome'];
            $imobiliaria->razao_social = $data['razao_social'];
            $imobiliaria->cnpj = $data['cnpj'];
            $imobiliaria->phone = $data['phone'];
            $imobiliaria->email = $data['email'];

            $imobiliaria->logradouro = $data['logradouro'];
            $imobiliaria->numero = $data['numero'];
            $imobiliaria->bairro = $data['bairro'];
            $imobiliaria->complemento = $data['complemento'] ?? '';
            $imobiliaria->cidade = $data['cidade'];
            $imobiliaria->uf = $data['uf'];
            $imobiliaria->cep = $data['cep'];

            $imobiliaria->save();

            $return['success'] = true;
            $return['message'][] = 'Imobiliária atualizada com sucesso';
        }

        $return['message'] = implode("<br>", $return['message']);

        return redirect("admin/imobiliarias/{$imobiliaria->id}/edit")->with("return", $return);
    }

    public function toggleStatus(Imobiliaria $imobiliaria)
    {
        $imobiliaria->status = !$imobiliaria->status;
        $imobiliaria->save();

        return redirect(route('admin.imobiliarias.all'));
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
