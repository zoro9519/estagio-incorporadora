<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agendamento;
use App\Models\Corretor;
use App\Models\Imobiliaria;
use App\Models\Lote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RelatorioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function agendamentos(Request $request)
    {
        $return = [
            'success' => true,
            'message' => []
        ];

        $filterLoteamento = $request->get('filterLoteamento');

        if(!empty($filterLoteamento)){
            $loteamento = Loteamento::find($filterLoteamento);

            if(!$loteamento){
                $return['message'][] = 'Loteamento não encontrado';
                $return['success'] = false;
            }
            $agendamentos = $loteamento->agendamentos();

        } else {
            $agendamentos = Agendamento::query();
        }

        $agendamentos = $agendamentos->where('type', Agendamento::TYPE_VISITA);

        $filterDataInicial = $request->get('filterDataInicial');
        $filterDataFinal = $request->get('filterDataFinal');
        if(!empty($filterDataInicial)){
            $agendamentos = $agendamentos->where("data_inicio", '>=', $filterDataInicial);
        }
        if(!empty($filterDataFinal)){
            $agendamentos = $agendamentos->where("data_fim", '>=', $filterDataFinal);
        }

        $agendamentos = $agendamentos->get();

        return view('admin.relatorios.agendamentos')
        ->with('agendamentos', $agendamentos)
        ->with('return', $return);
    }

    public function lotes(Request $request)
    {
        $return = [
            'success' => true,
            'message' => []
        ];

        $filterLoteamento = $request->get('filterLoteamento');

        if(!empty($filterLoteamento)){
            $loteamento = Loteamento::find($filterLoteamento);

            if(!$loteamento){
                $return['message'][] = 'Loteamento não encontrado';
                $return['success'] = false;
            }
            $lotes = $loteamento->quadras()->lotes();

        } else {
            $lotes = Lote::query();
        }

        $filterStatus = $request->get('filterStatus');

        if(!empty($filterStatus)){
        
            if(in_array($filterStatus, [Lote::STATUS_AVAILABLE])){

                $lotes = $lotes->where('status', $filterStatus);
            }
            else {
                $return['message'][] = 'Loteamento não encontrado';
                $return['success'] = false;
            }
        }

        // $lotes = $lotes->where('type', Agendamento::TYPE_VISITA);

        $filterDataInicial = $request->get('filterDataInicial');
        $filterDataFinal = $request->get('filterDataFinal');
        if(!empty($filterDataInicial)){
            $lotes = $lotes->where("created_at", '>=', $filterDataInicial);
        }
        if(!empty($filterDataFinal)){
            $lotes = $lotes->where("created_at", '>=', $filterDataFinal);
        }

        $lotes = $lotes->get();

        return view('admin.relatorios.lotes')
        ->with('lotes', $lotes)
        ->with('return', $return);
    }

    public function all()
    {
        $corretores = Corretor::doesntHave('imobiliaria')->get();
        return view("admin.corretores.index")->with("corretores", $corretores);
    }

    
}
