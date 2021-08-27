<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $request->validate([
            'loteamento_id' => 'required',
            'descricao'     => 'required'
        ]);

        $data = $request->all();

        $loteamento = Loteamento::find($data['loteamento_id']);

        if(!$loteamento){
            $return['message'] = "Loteamento não encontrado";
        } else {

            $quadraSearch = Quadra::where("descricao", $data['descricao'])
            ->where("loteamento_id", $data['loteamento_id'])
            ->get();

            if($quadraSearch){
                $return['message'] = "Descrição de lote já cadastrado";
            } else {

                $quadra = new Quadra;

                $quadra->descricao = $data['descricao'];
                $quadra->loteamento_id = $loteamento->id;

                $quadra->save();
            }
        }

        return redirect("admin/loteamentos/{$data['loteamento_id']}");
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
        //
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
