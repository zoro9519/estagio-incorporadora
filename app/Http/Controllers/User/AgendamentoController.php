<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\AgendamentoCriado;
use App\Models\Agendamento;
use App\Models\User;
use App\Models\Lote;
use App\Models\Loteamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgendamentoController extends Controller
{

    public function __invoke()
    {
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()){
            $user = Auth::user();
            $agendamentos = $user->agendamentos()->orderBy("data_fim", "desc")->get();

            $loteamentos = Loteamento::all();
            return view("user.agendamentos.index")->with("agendamentos", $agendamentos)->with("loteamentos", $loteamentos);
        }
        return redirect("user");
    }

    public function all()
    {
        $agendamentos = Agendamento::get()->all();
        return view("user.agendamentos.index")->with("agendamentos", $agendamentos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $loteamentos = Loteamento::all()->toArray();
        return view("user.agendamentos.create")->with("loteamentos", $loteamentos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(Auth::user()->status != User::STATUS_APROVADO){
            return redirect(route('user.home'))->with('return', [
                'success' => false,
                'message' => 'Sua conta não foi ativada. Para salvar um agendamento, aguarde a aprovação.'
            ]);
        }
        // $request->validate([
        //     ''
        // ]);
        
        $ret = [
            'success' => false
        ];

        $now = date("Y-m-d H:i:s");

        $limit_date = date("Y-m-d H:i:s", strtotime($now . " + 1 day"));

        $strDate = "{$request->input('data_selecionada')} {$request->input('horario')}:{$request->input('minutos')}:00";

        $data_agendamento = date("Y-m-d H:i:s", strtotime($strDate));
        
        if($data_agendamento > $limit_date ){
            $loteamento = Loteamento::find($request->input("loteamento_id"));

            if($loteamento){

                $lote = Lote::find($request->input("lote_id"));

                $agendamento = new Agendamento;

                $agendamento->data_inicio   = $data_agendamento;
                $agendamento->data_fim      = date("Y-m-d H:i:s", strtotime($data_agendamento . "+ 1 hour"));
                $agendamento->status        = 'E';
                $agendamento->observacao    = '';
                $agendamento->user_id       = Auth::user()->id;
                $agendamento->loteamento_id = $loteamento->id;
                if($lote)
                    $agendamento->lote_id = $lote->id;

                $agendamento->save();
                $ret['success'] = true;

                // TODO: Enviar email para admin sobre novo agendamento pendente
                Mail::to(Auth::user()->email)->send(new AgendamentoCriado($user, $agendamento));

            } else {
                $ret['error_message'] = "Loteamento não encontrado";
                
            }
        } else {
            $ret['error_message'] = "Data muito próxima";
        }
        

        return $ret['success'] ? redirect()->back() : redirect()->back()->with("error_message", $ret['error_message']);
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

    public function showAgenda(Loteamento $loteamento, Lote $lote = null)
    {
        if(Auth::user()->status != User::STATUS_APROVADO) {
            return redirect(route('user.agendamentos.showMap', ['loteamento' => $loteamento]))->with('return', [
                'success' => false,
                'message' => 'Sua conta não foi ativada. Para fazer um agendamento, aguarde a aprovação.'
            ]);
        }

        $view = view("user.agendamentos.agenda")->with("loteamento", $loteamento);
        
        $agendamentos = Agendamento::where("loteamento_id", $loteamento->id);

        if($lote) {
            if(!$lote->disponivelParaUser()) {
                return back()->withMessage('error', 'Lote indisponível');
            }
            $agendamentos = $agendamentos->where('lote_id', $lote->id);
            $view = $view->with("lote", $lote);
        }
        
        $agendamentos = $agendamentos->get();

        $view = $view->with("agendamentos", $agendamentos);

        return $view;
    }

    public function showMap(Loteamento $loteamento)
    {
        $quadrasToShow = $loteamento->quadrasDisponiveis()->get();

        return view("user.agendamentos.map")->with("loteamento", $loteamento)->with("quadrasToShow", $quadrasToShow);
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
        //
    }

    public function cancel(Agendamento $agendamento)
    {
        $ret['success'] = false;

        $limit_date = date("Y-m-d H:i:s", strtotime("today + 2 day"));

        if(in_array($agendamento->status, [ 'A', 'E'])){
            $data_evento = date("Y-m-d H:i:s", strtotime($agendamento->data_inicio));

            if($data_evento > $limit_date){

                $agendamento->status = 'C';
                $agendamento->save();
                
                $ret['success'] = true;

            } else {
                $ret['message'] = "Data do agendamento muito próxima. Entre em contato com a administração para mais detalhes.";
            }

        } else {
            $ret['message'] = "Status do agendamento não permite cancelamento";
        }
        if($ret['success']){
            return back()->with("error_message", $ret['message']);
        }
        return back()->with("success", "Agendamento cancelado com sucesso");
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agendamento  $agendamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Agendamento $agendamento)
    {

        $now = date("Y-m-d H:i:s");

        $limit_date = date("Y-m-d H:i:s", strtotime($now . " + 1 day"));

        

        $data_agendamento = date("Y-m-d H:i:s", strtotime($agendamento->data_inicio));

        $error_message = "";

        if($data_agendamento > $limit_date){
            if(!in_array($agendamento->status, ['R', 'C'])){
                $agendamento->status = 'C'; // Cancelado por desistência
                $agendamento->save();

                // TODO: Enviar email para corretor e admin sobre cancelamento/desistencia da visita

                return back();
            } else {
                $error_message = "Status do agendamento não permite cancelamento";
            }
        } else {
            $error_message = "Data muito próxima para cancelamento. Contate a administração";
        }
        return back()->with("error_message", $error_message);
    }
}
