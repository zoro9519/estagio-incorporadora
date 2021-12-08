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
        return view("admin.loteamentos.edit")->with('loteamento', $loteamento);
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
        $return = [
            'success' => false,
            'message' => []
        ];
        
        $data = $request->all();

        if(empty($data['nome']))
            $return['message'][] = "Nome precisa ser preenchido";
        elseif(empty($data['link']))
            $return['message'][] = "Link precisa ser preenchido";
        elseif(Loteamento::where("link", $data['link'])->where('id', '!=', $loteamento->id)->count())
            $return['message'][] = 'Link já cadastrado na base';
        elseif(empty($data['area']))
            $return['message'][] = "Área precisa ser preenchida";
        else {
            $loteamento->nome = $data['nome'];
            $loteamento->link = $data['link'];
            $loteamento->area = $data['area'];
            $loteamento->save();

            $return['success'] = true;
            $return['message'][] = 'Loteamento atualizado com sucesso';
        }

        $return['message'] = implode("<br>", $return['message']);

        return redirect("admin/loteamentos/{$loteamento->id}")->with("return", $return);
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

    public function updateLandingPage(Loteamento $loteamento, Request $request)
    {
        $return = [
            'success' => false,
            'message' => []
        ];

        // $validator = Validator::make($request->all(), [
        //     'descricao' => "required|min:1"
        // ])->validate();

        $data = $request->all();

        $landing = new LandingPage();

        $landing->descricao = $data['descricao'];
        $landing->texto_acompanhe_a_obra = $data['texto_acompanhe_a_obra'];
        $landing->percentual_acompanhe_a_obra = $data['percentual_conclusao'];
        $landing->endereco_completo = $data['endereco_completo'];
        $landing->cor_fundo = $data['cor_fundo'];
        $landing->cor_texto = $data['cor_texto'];
        $landing->loteamento_id = $loteamento->id;

        $loteamento->landingPage()->updateOrCreate([
            'loteamento_id' => $landing->loteamento_id
        ], [
            'descricao' => $landing->descricao,
            'texto_acompanhe_a_obra' => $landing->texto_acompanhe_a_obra,
            'percentual_acompanhe_a_obra' => $landing->percentual_acompanhe_a_obra,
            'endereco_completo' => $landing->endereco_completo,
            'cor_fundo' => $landing->cor_fundo,
            'cor_texto' => $landing->cor_texto,
        ]);
        $return['success'] = true;
        $return['message'][] = 'Dados salvos com sucesso';

        $return['message'] = implode("<br>", $return['message']);
        
        return redirect("admin/loteamentos/{$loteamento->id}")
        // ->withErrors($validator, 'landing_layout')
        ->with('return', $return);
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
            'id' => $loteamento->coordenada->id
        ], [
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'zoom'      => $data['zoom'] ?? 7
        ]);

        return redirect()->back()->withErrors($validator, 'assets');
    }
}
