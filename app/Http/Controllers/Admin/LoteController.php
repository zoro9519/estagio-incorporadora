<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agendamento;
use App\Models\Corretor;
use App\Models\Imobiliaria;
use App\Models\Lote;
use App\Models\Proprietario;
use App\Models\Quadra;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("lotes.index");
    }

    public function all()
    {
        $lotes = Lote::get()->all();
        return view("admin.lotes.index")->with("lotes", $lotes);
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
            'quadra_id'     => 'required',
            'descricao'     => 'required',
            'area'          => 'required',
            'valor'         => 'required',
        ]);

        $data = $request->all();

        $latitudes = $data['latitudes_lote'] ?? [];
        $longitudes = $data['longitudes_lote'] ?? [];

        if(count($latitudes) != count($longitudes)) {
            $return['message'][] = "Dados de localização inválidos";
        } 
        if(count($longitudes) < 3) {
            $return['message'][] = "São necessários 3 pontos pelo menos para formar o lote";
        } 
        if(empty($return['message'])) {
            $quadra = Quadra::find($data['quadra_id']);

            $lote = new Lote();

            $data['valor'] = str_replace(",", ".", $data['valor']);
            $data['valor'] = str_replace(".", "", $data['valor']);
            $data['valor'] /= 100;

            $lote->descricao = $data['descricao'];
            $lote->status = 'L';
            $lote->area = $data['area'];
            $lote->valor = $data['valor'];
            
            $lote->quadra_id = $quadra->id;

            $coords = [];
            foreach($longitudes as $i => $long)
            {
                if($latitudes[$i]){
                    $coord = [
                        "latitude" => $latitudes[$i],
                        "longitude" => $long,
                        "zoom"      => 7
                    ];
                    $coords[] = $coord;
                }
            }

            $lote->save();
            $lote->coordenadas()->createMany($coords);
            $return['success'] = true;
            $return['message'][] = 'Lote criado com sucesso';
        }

        $return['message'] = implode("<br>", $return['message']);

        return redirect("admin/quadras/{$data['quadra_id']}")->with('return', $return);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function show(Lote $lote)
    {
        $allCorretores = Corretor::query()->orderBy('imobiliaria_id')->orderBy('nome')->get();

        $corretores = Corretor::whereNull("imobiliaria_id")->get();
        $imobiliarias = Imobiliaria::has("corretores")->get();

        $today = date('Y-m-d');
        $currentReserva = $lote->reservas()
        ->where('data_inicio', '<=', $today)
        ->where('data_fim', '>=', $today)
        ->where('status', Agendamento::STATUS_AGENDADO)
        ->first();

        $reservas = $lote->agendamentos()
        ->where('type', Agendamento::TYPE_RESERVA)
        ->orderBy('data_inicio', 'desc')
        ->orderBy('data_fim', 'desc')
        ->orderBy('created_at', 'desc')
        ->get();

        return view("admin.lotes.view")
        ->with("lote", $lote)
        ->with("corretores", $corretores)
        ->with("imobiliarias", $imobiliarias)
        ->with('allCorretores', $allCorretores)
        ->with('reservas', $reservas)
        ->with('currentReserva', $currentReserva);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function edit(Lote $lote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lote $lote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lote  $lote
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lote $lote)
    {
        $parent_id = $lote->quadra_id;
        $lote->delete();

        return redirect("admin/quadras/{$parent_id}");
    }

    public function reservar(Lote $lote, Request $request)
    {
        $return = [
            'success' => false,
            'message' => []
        ];

        $data = $request->all();

        $dataInicio = $data['data_inicio'] ? date($data['data_inicio']) : false;
        $dataFim = $data['data_fim'] ? date($data['data_fim']) : false;

        $now = date('Y-m-d');
        
        if($dataInicio < $now){
            $return['message'][] = 'Data inicial inválida';
        }
        if($dataFim < $dataInicio){
            $return['message'][] = 'Data final menor que data inicial';
        }
        if(!($corretor = Corretor::find($data['corretor'] ?? 0))){
            $return['message'][] = 'Corretor não encontrado';
        }

        if(empty($return['message'])){
            $reserva = new Agendamento();
            $reserva->data_inicio = $dataInicio;
            $reserva->data_fim = $dataFim;
            $reserva->observacao = empty($data['observacao']) ? $data['observacao'] : "Reserva de lote";
            $reserva->status = Agendamento::STATUS_AGENDADO;
            $reserva->type = Agendamento::TYPE_RESERVA;
            $reserva->lote_id = $lote->id;
            $reserva->loteamento_id = $lote->quadra->loteamento->id;
            $reserva->corretor_id = $corretor->id;

            $reserva->save();

            $return['success'] = true;
            $return['message'][] = 'Lote reservado com sucesso';

        }

        $return['message'] = implode("<br>", $return['message']);
        return redirect("admin/lotes/{$lote->id}")->with('return', $return);
    }

    public function liberar(Lote $lote, Request $request)
    {
        $return = [
            'success' => false,
            'message' => []
        ];

        $data = $request->all();

        // var_dump($data);
        // die;
        $reserva = Agendamento::find($data['reservas']);
        $reserva->status = Agendamento::STATUS_CANCELADO;
        $reserva->save();
        $return['message'][] = 'Lote liberado com sucesso';
        $return['success'] = true;
        
        $return['message'] = implode("<br>", $return['message']);
        return redirect("admin/lotes/{$lote->id}")->with('return', $return);
    }

}
