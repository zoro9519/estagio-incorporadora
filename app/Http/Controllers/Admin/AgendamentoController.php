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

        $corretores = Corretor::with(['imobiliaria' => function ($query) {
            $query->orderBy('nome', 'asc');
        }])
        ->orderBy("nome", 'asc')
        ->get();

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
        $return = [
            'success' => false,
            'message' => []
        ];

        $allowed_status = [ 
            'A', 
            'C', 
            'E', 
            'N', 
            'R' 
        ]; 
        // A - Agendado, C - Cancelado, E - Esperando aprovação admin, N - Negado pelo admin, R - Realizado

        $corretor = Corretor::find($request->input("corretor", 0));
        
        if(!$corretor){
            $return['message'][] = "Corretor não encontrado";
        } else {
            $agendamento->corretor_id = $corretor->id;
        }

        $novo_status = $request->input("status");
        
        if(in_array($novo_status, $allowed_status)){
            $agendamento->status = $novo_status;
        }
        
        if(empty($return['message'])){
            $agendamento->save();

            $return['success'] = true;
            $return['message'][] = 'Agendamento atualizado com sucesso';
            
            if($novo_status != $agendamento->status) {
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
            }
        }
        $return['message'] = implode("<br>", $return['message']);

        return redirect(route('admin.agendamentos.all'))->with("return", $return);
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
