<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Corretor;
use App\Models\Imobiliaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $corretores = Corretor::doesntHave('imobiliaria')->get();
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
            'cpf'     => 'required',
            'celular'     => 'required'
        ]);

        $data = $request->all();

        $imobiliaria_id = $data['imobiliaria_id'] ?? 0;
        $imobiliaria = Imobiliaria::find($imobiliaria_id);
        if(!$imobiliaria){
            $imobiliaria_id = 0;
        }

        $profilePicture = $request->file("profile_picture");

        $corretorSearch = Corretor::where("cpf", $data['cpf'])
            ->where("imobiliaria_id", "!=", $imobiliaria_id ? $imobiliaria_id : null)
            ->first();

        if($corretorSearch){
            $return['message'] = "CPF já cadastrado";
        } elseif(!$profilePicture){
            $return['message'] = "Foto de perfil não enviada";
        } elseif(!$profilePicture->getSize()){
            $return['message'] = "Foto de perfil inválida";
        } else {

            $AWSFile = $profilePicture->storePublicly("corretors", 's3');

            $corretor = new Corretor();

            $corretor->nome = $data['nome'];
            $corretor->cpf = $data['cpf'];
            $corretor->taxa_venda_porcentagem = $data['taxa_venda_porcentagem'] ?? 0;
            $corretor->taxa_venda_valor = $data['taxa_venda_valor'] ?? 0;
            $corretor->phone = $data['celular'];
            $corretor->email = $data['email'];

            $corretor->imobiliaria_id = $imobiliaria_id;
            $corretor->profile_picture = $AWSFile;

            $corretor->ativo = true;

            $corretor->save();

            $return['success'] = true;
        }

        $redirect = "admin/corretores";

        if($imobiliaria_id != 0)
            $redirect = "admin/imobiliarias/{$imobiliaria_id}";

        if($return['success']){
            return redirect($redirect);
        }
        return back()->withInput()->with("error", $return['message']);
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
        return view('admin.corretores.edit')->with("corretor", $corretor);
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
        $return = [
            'success' => false,
            'message' => []
        ];
        
        $data = $request->all();
        $taxaPercent = $data['taxa_percent'];
        $taxaValor = $data['taxa_valor'];
        $fotoPerfil = $request->file('profile');

        if(empty($data['nome']))
            $return['message'][] = "Nome precisa ser preenchido";
        elseif(empty($data['cpf']))
            $return['message'][] = "CPF precisa ser preenchido";
        elseif(Corretor::where("cpf", $data['cpf'])->where('id', '!=', $corretor->id)->count())
            $return['message'][] = 'CPF já cadastrado na base';
        elseif(empty($data['phone']))
            $return['message'][] = "Celular precisa ser preenchido";
        elseif(empty($data['email']))
            $return['message'][] = "Email precisa ser preenchido";
        elseif(Corretor::where("email", $data['email'])->where('id', '!=', $corretor->id)->count())
            $return['message'][] = 'Email já cadastrado na base';
        elseif($fotoPerfil && !$fotoPerfil->getSize()) {
            $return['message'][] = 'Foto de perfil inválida';
        } elseif($taxaPercent && ($taxaPercent < 0 && $taxaPercent > 100)){
            $return['message'][] = 'Taxa de porcentagem é inválida';
        } elseif($taxaValor && $taxaValor < 0){
            $return['message'][] = 'Valor de taxa é inválido';
        }
        else {
            $corretor->nome = $data['nome'];
            $corretor->cpf = $data['cpf'];
            $corretor->phone = $data['phone'];
            $corretor->email = $data['email'];

            if($fotoPerfil){
                // TODO:
                // Remover antiga na AWS
                // Fazer upload na AWS
                $awsFilePath= "";
                $corretor->profile_picture = $awsFilePath;
            }

            $corretor->taxa_venda_valor = $data['taxa_valor'] ?? 0;
            $corretor->taxa_venda_porcentagem = $data['taxa_percent'] ?? 0;
            $corretor->save();

            $return['success'] = true;
            $return['message'][] = 'Corretor atualizado com sucesso';
        }

        $return['message'] = implode("<br>", $return['message']);

        return redirect("admin/corretores/{$corretor->id}/edit")->with("return", $return);
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
