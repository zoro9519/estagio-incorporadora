<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(){        
        return view("user.profile.index");
    }

    public function update(Request $request){
        
        $return = [
            'success' => false,
            'message' => []
        ];

        $user = Auth::user();

        $data = $request->all();

        $userByCPF = User::where('cpf', $data['cpf'] ?? '')->whereNotIn('id', [$user->id])->first();
        if($userByCPF){
            $return['message'][] = 'CPF indisponível';
        } else {

            $user->cpf = $request->get('cpf');
            $user->phone = $request->get('phone');
            $user->nome = $request->get('nome');

            $user->logradouro = $request->get('logradouro');
            $user->numero = $request->get('numero');
            $user->complemento = $request->get('complemento');
            $user->bairro = $request->get('bairro');
            $user->cidade = $request->get('cidade');
            $user->uf = $request->get('uf');
            $user->cep = $request->get('cep');
            
            $user->is_new = 0;

            $user->save();

            $return['success'] = true;
            $return['message'][] = 'Perfil atualizado com sucesso';
        }

        $return['message'] = implode("<br>", $return['message']);

        return redirect(route("user.profile"))->with("return", $return);
    }
}
