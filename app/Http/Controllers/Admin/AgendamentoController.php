<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agendamento;
use App\Models\Corretor;
use App\Models\Loteamento;
use Illuminate\Http\Request;

class AgendamentoController extends Controller
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

    public function all(Request $request)
    {
        $filters = [];

        if(!empty($request->get("filterStatus", "")))
            $filters['status'] = $request->get("filterStatus");

        if(!empty($request->get("filterLoteamento", "")))
            $filters['loteamento_id'] = $request->get("filterLoteamento");

        if(!empty($request->get("filterType", "")))
            $filters['type'] = $request->get("filterType");


        $agendamentos = Agendamento::where($filters)->get()->all();

        $corretores = Corretor::orderBy("nome", 'asc')->get();
        $loteamentos = Loteamento::orderBy("nome", 'asc')->get();

        return view("admin.agendamentos.index")->with("agendamentos", $agendamentos)->with("corretores", $corretores)->with("loteamentos", $loteamentos);
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
     * @param  \App\Models\Agendamento  $agendamento
     * @return \Illuminate\Http\Response
     */
    public function show(Agendamento $agendamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Agendamento  $agendamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Agendamento $agendamento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agendamento  $agendamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agendamento $agendamento)
    {
        $allowed_status = [ 
            'A', 
            'C', 
            'E', 
            'N', 
            'R' 
        ]; 
        // A - Agendado, C - Cancelado, E - Esperando aprovação admin, N - Negado pelo admin, R - Realizado

        $novo_status = $request->input("status");

        if(in_array($novo_status, $allowed_status)){

            $agendamento->status = $novo_status;

        }

        $corretor = Corretor::find($request->input("corretor"))->first();

        if(!$agendamento->corretor && !$corretor){
            return back()->with("error", "É necessário definir um corretor");
        }

        $agendamento->corretor_id = $corretor->id;
        $agendamento->save();
        return back()->with("success", $corretor ? "Corretor atribuído com sucesso" : "Corretor removido");
            $agendamento->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agendamento  $agendamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Agendamento $agendamento)
    {
        //
    }

    public function changeStatus(Request $request, Agendamento $agendamento)
    {
        $allowed_status = [ 
            'A', 
            'C', 
            'E', 
            'N', 
            'R' 
        ]; 
        // A - Agendado, C - Cancelado, E - Esperando aprovação admin, N - Negado pelo admin, R - Realizado

        $novo_status = $request->input("status");

        if(in_array($novo_status, $allowed_status)){

            $agendamento->status = $novo_status;
            $agendamento->save();

            switch($novo_status)
            {

                case 'C':
                    // Enviar email para user
                    // Enviar email para corretor
                    break;
                case 'N':
                    // Enviar email para user sobre cancelamento
                    break;
                case 'A':
                    // Enviar email para user e corretor sobre efetivação do agendamento
                    break;
                case 'R':
                    // Enviar email para cliente solicitando feedback

            }

            return back();
        }
        return redirect("admin/agendamentos")->with("error", __("Status inválido para o agendamento desejado"));
    }

    public function setCorretor(Request $request, Agendamento $agendamento,$id_corretor){
        
        $corretor = Corretor::find($id_corretor)->get()->id ?? null;

        if(!$agendamento->corretor && !$corretor){
            return back()->with("error", "É necessário definir um corretor");
        }

        $agendamento->corretor = $corretor;
        $agendamento->save();
        return back()->with("success", $corretor ? "Corretor atribuído com sucesso" : "Corretor removido");
    }
}
