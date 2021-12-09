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
    public function store(Lote $lote, Request $request){
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
            
            $lote->save($proprietario);
            
            $return['success'] = true;

            return redirect("admin/lotes/{$lote->id}");

        } else {
            $return['message'] = "Documento já cadastrado para proprietário atual";
        }
        return back()->with("error", $return['message']);
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
    public function destroy(Lote $lote, Proprietario $proprietario)
    {
        $return = [
            'success' => false,
            'message' => []
        ];

        $proprietarioToDelete = $lote->proprietarios()->find($proprietario)->first();
        
        if(!empty($proprietarioToDelete)){
            $proprietarioToDelete->delete();
            $return['success'] = true;
            $return['message'][] = 'Proprietário removido com sucesso';
        }
        else {
            $return['message'][] = 'Não foi possível remover o proprietário';
        }

        $return['message'] = implode("<br>", $return['message']);


        // Disparar email para cliente de lote vendido
        return redirect(route('admin.lotes.show', ['lote' => $lote->id]))->with('return', $return);

    }

    public function transferir(Lote $lote, Request $request){

        $return['success'] = false;
        $data = $request->all();

        $data['data_inicio'] = !empty($data['data_inicio']) ? date("Y-m-d H:i:s", strtotime($data['data_inicio'])) : null;

        if(empty($data['documento'])){
            $return['message'][] = 'Documento não foi enviado';
        } elseif(empty($data['nome'])){
            $return['message'][] = 'Nome não foi enviado';
        } elseif(empty($data['data_inicio'])){
            $return['message'][] = 'Data de início não foi enviada';
        } elseif(empty($data['phone'])){
            $return['message'][] = 'Celular não foi enviado';
        } elseif(empty($data['email'])){
            $return['message'][] = 'Email não foi enviado';
        } elseif(empty($data['cep'])){
            $return['message'][] = 'CEP não foi enviado';
        } elseif(empty($data['logradouro'])){
            $return['message'][] = 'Logradouro não foi enviado';
        } elseif(empty($data['bairro'])){
            $return['message'][] = 'Bairro não foi enviado';
        } elseif(empty($data['cidade'])){
            $return['message'][] = 'Cidade não foi enviada';
        } elseif(empty($data['uf'])){
            $return['message'][] = 'UF não foi enviado';
        } elseif(empty($data['data_inicio'])){
            $return['message'][] = 'Data inicial não foi enviada';
        } elseif(!empty($lote->atual->count()) && $data['data_inicio'] <= $lote->atual()->first()->data_inicio){
            $return['message'][] = 'A data de início desejada não é válida';
        } elseif($lote->atual()->where("documento", $data['documento'])->count() > 0){
            $return['message'][] = 'Proprietário já cadastrado';
        }

        if(empty($return['message'])){

            
            DB::beginTransaction();

            // aplica data final para todos os proprietários atuais
            $dateEnd = date("Y-m-d H:i:s", strtotime($data['data_inicio'] . ' -1 second'));
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
            $return['message'][] = 'Lote transferido com sucesso';

        }

        $return['message'] = implode("<br>", $return['message']);

        return redirect(route("admin.lotes.show", ['lote' => $lote]))->with("return", $return);
    }
}
