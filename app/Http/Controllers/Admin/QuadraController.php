<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coordenada;
use App\Models\Loteamento;
use App\Models\Quadra;
use Illuminate\Http\Request;

class QuadraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("loteamentos.index");
    }

    public function all()
    {
        $loteamentos = Quadra::get()->all();
        return view("admin.quadras.index")->with("loteamentos", $loteamentos);
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

        $data = $request->all();

        $latitudes = $data['latitudes_quadra'] ?? [];
        $longitudes = $data['longitudes_quadra'] ?? [];

        $loteamento = Loteamento::find($data['loteamento_id']);

        
        if(!$loteamento){
            $return['message'][] = "Loteamento não encontrado";
        }
        if(count($latitudes) != count($longitudes)) {
            $return['message'][] = "Dados de localização inválidos";
        }
        if(count($longitudes) < 3) {
            $return['message'][] = "São necessários 3 pontos pelo menos para formar uma nova quadra";
        } 
        if(empty($return['message'])) {
            $quadraSearch = Quadra::where("descricao", $data['descricao'])
            ->where("loteamento_id", $data['loteamento_id'])
            ->first();

            if($quadraSearch){
                $return['message'][] = "Descrição de quadra já cadastrada";
            } else {

                $quadra = new Quadra;

                $quadra->descricao = $data['descricao'];
                $quadra->loteamento_id = $loteamento->id;

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
                $quadra->save();
                
                $quadra->coordenadas()->createMany($coords);

                $return['success'] = true;
                $return['message'][] = 'Quadra criada com sucesso';
            }
        }

        $return['message'] = implode("<br>", $return['message']);
        return redirect("admin/loteamentos/{$data['loteamento_id']}")->with("return", $return);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quadra  $quadra
     * @return \Illuminate\Http\Response
     */
    public function show(Quadra $quadra)
    {
        // var_dump($quadra);
        // die;
        return view("admin.quadras.view")->with("quadra", $quadra);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quadra  $quadra
     * @return \Illuminate\Http\Response
     */
    public function edit(Quadra $quadra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quadra  $quadra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quadra $quadra)
    {
        $return = [
            'success' => false,
            'message' => []
        ];

        $data = $request->all();

        if(empty($data['descricao'])) {
            $return['message'][] = 'Descrição não informada';
        }
        if($quadra->loteamento->quadras->where('descricao', $data['descricao'])->whereNotIn('id', $quadra->id)->count()){
            $return['message'][] = 'Não foi possível salvar. Descrição aplicada em outra quadra do mesmo lote.';
        }
        if(empty($return['message'])) {
            $quadra->descricao = $data['descricao'];
            $quadra->save();

            $return['success'] = true;
            $return['message'][] = 'Quadra atualizada com sucesso';
        }

        $return['message'] = implode("<br>", $return['message']);

        return redirect("admin/quadras/{$quadra->id}")->with("return", $return);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quadra  $quadra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quadra $quadra)
    {
        $parent_id = $quadra->loteamento_id;
        $quadra->delete();

        return redirect("admin/loteamentos/{$parent_id}");
    }
}
