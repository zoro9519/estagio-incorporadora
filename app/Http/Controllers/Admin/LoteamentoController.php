<?php

namespace App\Http\Controllers\Admin;

use App\Models\Loteamento;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\LandingPage;
use App\Models\Lote;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class LoteamentoController extends Controller
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
        $loteamentos = Loteamento::get()->all();
        return view("admin.loteamentos.index")->with("loteamentos", $loteamentos);
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
        ];

        $request->validate([
            'nome' => 'required',
            'descricao'     => 'required',
            'link'     => 'required',
            'area'     => 'required'
        ]);

        $data = $request->all();

        $loteamentoSearch = Loteamento::where("nome", $data['nome'])->orWhere("link", $data['link'])->first();

        if($loteamentoSearch){
            $return['message'] = "Nome já cadastrado";

            if(strtolower($loteamentoSearch->link) == strtolower($data['link']))
                $return['message'] = 'Link já cadastrado. Tente outros valores';
        } else{

            $loteamento = new Loteamento();

            $loteamento->nome = $data['nome'];
            $loteamento->descricao = $data['descricao'];
            $loteamento->link = $data['link'];
            $loteamento->area = $data['area'];
            $loteamento->coordenada_id = 0;

            $loteamento->save();

            // Salva landing page e vincula ao loteamento
            $landing = new LandingPage;
            $landing->loteamento_id = $loteamento->id;
            $landing->save();

            $return['success'] = true;
        }

        return redirect("admin/loteamentos");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loteamento  $loteamento
     * @return \Illuminate\Http\Response
     */
    public function show(Loteamento $loteamento)
    {
        return view("admin.loteamentos.view")->with("loteamento", $loteamento);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loteamento  $loteamento
     * @return \Illuminate\Http\Response
     */
    public function edit(Loteamento $loteamento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loteamento  $loteamento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loteamento $loteamento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loteamento  $loteamento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loteamento $loteamento)
    {
        //
    }

    public function updateLandingPage(Loteamento $loteamento, Request $request){

        $validator = Validator::make($request->all(), [
            'descricao' => "required|min:1"
        ])->validate();

        $data = $request->all();

        $landing = new LandingPage();

        $landing->descricao = $data['descricao'];
        $landing->cor_fundo = $data['cor_fundo'];
        $landing->cor_texto = $data['cor_texto'];
        $landing->loteamento_id = $loteamento->id;

        $loteamento->landingPage()->updateOrCreate([
            'loteamento_id' => $landing->loteamento_id
        ], [
            'descricao' => $landing->descricao,
            'cor_fundo' => $landing->cor_fundo,
            'cor_texto' => $landing->cor_texto,
        ]);
        
        return redirect()->back()->withErrors($validator, 'landing_layout');
    }

    public function uploadFile(Loteamento $loteamento, Request $request){

        $validator = Validator::make($request->all(), [
            'file' => "required|file|mimes:jpeg,png,bmp,tiff,mpeg,ogg,mp4,webm,3gp,mov,flv,avi,wmv,ts",
            'type' => "required|in:image,video"
        ])->validate();

        $data = $request->all();
        
        try {

            $fileToSend = $request->file("file");

            $AWSFile = $fileToSend->storePublicly("assets", 's3');
            
            $asset = new Asset();

            $asset->filepath = $AWSFile;
            $asset->type = $data['type'] == 'image' ? "I" : "V";

            $asset->save();

            $loteamento->assets()->attach($asset->id);

        } catch(Exception $e){
            $return['message'] = __("Não foi possível realizar o upload");
        }
        
        return redirect()->back()->withErrors($validator, 'assets');
    }

    public function updateLocation(Loteamento $loteamento, Request $request){

        $validator = Validator::make($request->all(), [
            'latitude' => "required",
            'longitude' => "required"
        ])->validate();

        $data = $request->all();
        

        $loteamento->coordenada()->updateOrCreate([
            'id' => $loteamento->coordenada_id
        ], [
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'zoom'      => $data['zoom']
        ]);

        return redirect()->back()->withErrors($validator, 'assets');
    }
}
