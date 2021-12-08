<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lote;
use App\Models\Proprietario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProprietarioController extends Controller
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
     * @param  \App\Models\Proprietario  $proprietario
     * @return \Illuminate\Http\Response
     */
    public function show(Proprietario $proprietario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proprietario  $proprietario
     * @return \Illuminate\Http\Response
     */
    public function edit(Proprietario $proprietario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proprietario  $proprietario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proprietario $proprietario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proprietario  $proprietario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proprietario $proprietario)
    {
        //
    }

    public function transferir(Lote $lote, Request $request){
        // TODO: 
        // - Definir ultimos 1...n proprietários com data_fim = atual para (hoje -1)
        // - Salvar 1...n proprietários com data atual
        $request->validate([
            'documento'     => 'required',
            'nome'          => 'required',
            'data_inicio'   => 'required'
            // 'data_fim'      => ''
        ]);

        $return['success'] = false;
        $data = $request->all();

        $lote = Lote::find($lote->id);

        $canAddProprietario = $lote->atual()->where("documento", $data['documento'])->count() === 0;
        
        if($canAddProprietario){

            DB::beginTransaction();

            // aplica data final para todos os proprietários atuais
            $dateEnd = date("Y-m-d H:i:s", strtotime('-1 second'));
            $lote->atual()->update([
                'data_fim' => $dateEnd
            ]);

            $proprietario = new Proprietario();
            
            $proprietario->nome = $data['nome'];
            $proprietario->documento = $data['documento'];
            $proprietario->email = $data['email'];
            $proprietario->phone = $data['phone'];

            $proprietario->data_inicio = $data['data_inicio'];
            $proprietario->data_fim = $data['data_fim'] ?? null;
            
            $proprietario->logradouro = $data['logradouro'] ?? null;
            $proprietario->numero = $data['numero'] ?? null;
            $proprietario->bairro = $data['bairro'] ?? null;
            $proprietario->complemento = $data['complemento'] ?? null;
            $proprietario->cidade = $data['cidade'] ?? null;
            $proprietario->uf = $data['uf'] ?? null;
            $proprietario->cep = $data['cep'] ?? null;

            $proprietario->lote_id = $lote->id;
            
            $proprietario->save();

            DB::commit();

            $return['success'] = true;

            return redirect("admin/lotes/{$lote->id}");

        } else {
            $return['message'] = "Documento já cadastrado para proprietário atual";
        }
        return back()->with("error", $return['message']);
    }


    public function adicionarProprietario(Lote $lote, Request $request){
        $request->validate([
            'documento'     => 'required',
            'nome'          => 'required',
            'data_inicio'   => 'required'
            // 'data_fim'      => ''
        ]);

        $return['success'] = false;
        $data = $request->all();

        $lote = Lote::find($lote->id);

        $canAddProprietario = $lote->atual()->where("documento", $data['documento'])->count() === 0;
        
        if($canAddProprietario){

            $proprietario = new Proprietario();
            
            $proprietario->nome = $data['nome'];
            $proprietario->documento = $data['documento'];
            $proprietario->email = $data['email'];
            $proprietario->phone = $data['phone'];

            $proprietario->data_inicio = $data['data_inicio'];
            $proprietario->data_fim = $data['data_fim'] ?? null;
            
            $proprietario->logradouro = $data['logradouro'] ?? null;
            $proprietario->numero = $data['numero'] ?? null;
            $proprietario->bairro = $data['bairro'] ?? null;
            $proprietario->complemento = $data['complemento'] ?? null;
            $proprietario->cidade = $data['cidade'] ?? null;
            $proprietario->uf = $data['uf'] ?? null;
            $proprietario->cep = $data['cep'] ?? null;

            $proprietario->lote_id = $lote->id;
            
            $proprietario->save();
            
            $return['success'] = true;

            return redirect("admin/lotes/{$lote->id}");

        } else {
            $return['message'] = "Documento já cadastrado para proprietário atual";
        }
        return back()->with("error", $return['message']);
    }

    public function removerProprietario(Proprietario $proprietario)
    {
        $parent_id = $proprietario->lote_id;
        $proprietario->delete();

        return redirect("admin/lotes/{$parent_id}");
    }
}
