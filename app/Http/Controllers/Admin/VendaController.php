<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\VendaRealizadaUser;
use App\Mail\VendaRealizadaCorretor;
use App\Models\Agendamento;
use App\Models\Corretor;
use App\Models\Lote;
use App\Models\User;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class VendaController extends Controller
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
        $vendas = Venda::get()->all();
        return view("admin.vendas.index")->with("vendas", $vendas);
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
    public function store(Lote $lote, Request $request)
    {
        $return = [
            'success' => false,
            'message' => []
        ];

        // $request->validate([
        //     "valor"             => 'required|numeric',
        //     "forma_pagamento"   => 'required',
        //     "numero_parcelas"   => 'required|numeric|min:1',
        // ]);

        $data = $request->all();

        if(empty($data['valor'])){
            $return['message'][] = 'Valor precisa ser preenchido';
        } elseif(empty($data['forma_pagamento'])){
            $return['message'][] = 'Forma pagamento precisa ser preenchido';
        } elseif(empty($data['numero_parcelas'])){
            $return['message'][] = 'Número parcelas precisa ser preenchido';
        } elseif(!is_int($data['numero_parcelas']) || $data['numero_parcelas'] < 1){
            $return['message'][] = 'Número parcelas é inválido';
        } elseif(empty($data['user'])){
            $return['message'][] = 'Cliente precisa ser preenchido';
        } elseif(!($user = User::find($data['user']))){
            $return['message'][] = 'Cliente não encontrado';
        } elseif(empty($data['corretor'])){
            $return['message'][] = 'Corretor precisa ser preenchido';
        } elseif(!($corretor = Corretor::find($data['corretor']))){
            $return['message'][] = 'Corretor não encontrado';
        } elseif(empty($data['x'])){
            $return['message'][] = 'x precisa ser preenchido';
        }
        if(empty($return['message'])){
            DB::beginTransaction();
            $venda = new Venda;
            $venda->admin_id = Auth::user()->id;
            $venda->lote_id = $lote->id;
            $venda->user_id = $data['user'];
            $venda->corretor_id = $data['corretor'];

            $venda->nro_parcelas = $data['numero_parcelas'];
            $venda->forma_pagamento = $data['forma_pagamento'];
            $venda->valor = $data['valor'];

            $venda->save();

            $lote->status = Lote::STATUS_SOLD; // Lote vendido
            $lote->save();

            if($user->status != User::STATUS_APROVADO){
                $user->status = User::STATUS_APROVADO;
                $user->save();
            }

            // Rotina para cancelar todos agendamentos futuros
            $lote->agendamentos()
                ->where("data_fim", ">", date('Y-m-d H:i:s'))
                ->update([
                    'status' => Agendamento::STATUS_CANCELADO
                ]);

            DB::commit();

            Mail::to($user->email)->send(new VendaRealizadaUser($venda));
            Mail::to($corretor->email)->send(new VendaRealizadaCorretor($venda));

            $return['success'] = true;
            $return['message'][] = 'Venda efetuada com sucesso';
        }
        
        $return['message'] = implode("<br>", $return['message']);


        // Disparar email para cliente de lote vendido
        return back()->with("success", "Este lote foi vendido")->with('return', $return);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Venda  $venda
     * @return \Illuminate\Http\Response
     */
    public function show(Venda $venda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Venda  $venda
     * @return \Illuminate\Http\Response
     */
    public function edit(Venda $venda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venda  $venda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venda $venda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Venda  $venda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venda $venda)
    {
        //
    }
}
