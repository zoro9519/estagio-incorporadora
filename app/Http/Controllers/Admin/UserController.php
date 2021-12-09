<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
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
        $return = [
            'success' => true
        ];

        $filters = [];

        $users = User::query();

        $statusFilter = trim($request->get("filterStatus", ""));
        if(!empty($statusFilter)){
            if(!in_array($statusFilter, [User::STATUS_APROVADO, User::STATUS_EMESPERA, User::STATUS_RECUSADO])){
                $return['success'] = false;
                $return['message'] = 'Status inválido';
            } else{
                $users = $users->where('status', $statusFilter);
            }
        }

        $emailFilter = trim($request->get("filterEmail", ""));
        if(!empty($emailFilter)){
            $users = $users->where('email', 'like', '%'. $emailFilter . '%');
        }
        $users = $users->orderBy('created_at', 'desc')->get();
        // die($users->toSql());

        return view("admin.users.index")->with("users", $users);
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

        if(empty($data['nome']))
            $return['message'][] = "Nome precisa ser preenchido";
        elseif(empty($data['cpf']))
            $return['message'][] = "CPF precisa ser preenchido";
        elseif(User::where("cpf", $data['cpf'])->where('id', '!=', $user->id)->count())
            $return['message'][] = 'CPF já cadastrado na base';
        elseif(empty($data['phone']))
            $return['message'][] = "Celular precisa ser preenchido";
        elseif(empty($data['email']))
            $return['message'][] = "Email precisa ser preenchido";
        elseif(User::where("email", $data['email'])->where('id', '!=', $user->id)->count())
            $return['message'][] = 'Email já cadastrado na base';
        elseif(empty($data['cep']))
            $return['message'][] = 'CEP precisa ser preenchido';
        elseif(empty($data['logradouro']))
            $return['message'][] = 'Logradouro precisa ser preenchido';
        elseif(empty($data['bairro']))
            $return['message'][] = 'Bairro precisa ser preenchido';
        elseif(empty($data['cidade']))
            $return['message'][] = 'Cidade precisa ser preenchida';
        elseif(empty($data['uf']))
            $return['message'][] = 'UF precisa ser preenchida';
        elseif(empty($data['status']))
            $return['message'][] = 'Status precisa ser enviado';
        elseif(!in_array($data['status'], [User::STATUS_APROVADO, User::STATUS_EMESPERA, User::STATUS_RECUSADO]))
            $return['message'][] = 'Status inválido';
        else {
            $user = new User();

            $user->nome = $data['nome'];
            $user->cpf = $data['cpf'];
            $user->phone = $data['phone'];
            $user->email = $data['email'];
            
            $user->status = User::STATUS_APROVADO;

            $user->logradouro = $data['logradouro'];
            $user->numero = $data['numero'];
            $user->bairro = $data['bairro'];
            $user->complemento = $data['complemento'] ?? '';
            $user->cidade = $data['cidade'];
            $user->uf = $data['uf'];
            $user->cep = $data['cep'];
            $user->is_new = 0;

            $user->save();

            $return['success'] = true;
            $return['message'][] = 'Cliente criado com sucesso';
        }

        $return['message'] = implode("<br>", $return['message']);

        return redirect("admin/users/{$user->id}/edit")->with("return", $return);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view("admin.users.view")->with("user", $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $return = [
            'success' => false,
            'message' => []
        ];
        
        $data = $request->all();

        if(empty($data['nome']))
            $return['message'][] = "Nome precisa ser preenchido";
        elseif(empty($data['cpf']))
            $return['message'][] = "CPF precisa ser preenchido";
        elseif(User::where("cpf", $data['cpf'])->where('id', '!=', $user->id)->count())
            $return['message'][] = 'CPF já cadastrado na base';
        elseif(empty($data['phone']))
            $return['message'][] = "Celular precisa ser preenchido";
        elseif(empty($data['email']))
            $return['message'][] = "Email precisa ser preenchido";
        elseif(User::where("email", $data['email'])->where('id', '!=', $user->id)->count())
            $return['message'][] = 'Email já cadastrado na base';
        elseif(empty($data['cep']))
            $return['message'][] = 'CEP precisa ser preenchido';
        elseif(empty($data['logradouro']))
            $return['message'][] = 'Logradouro precisa ser preenchido';
        elseif(empty($data['bairro']))
            $return['message'][] = 'Bairro precisa ser preenchido';
        elseif(empty($data['cidade']))
            $return['message'][] = 'Cidade precisa ser preenchida';
        elseif(empty($data['uf']))
            $return['message'][] = 'UF precisa ser preenchida';
        elseif(empty($data['status']))
            $return['message'][] = 'Status precisa ser enviado';
        elseif(!in_array($data['status'], [User::STATUS_APROVADO, User::STATUS_EMESPERA, User::STATUS_RECUSADO]))
            $return['message'][] = 'Status inválido';
        else {
            $user->nome = $data['nome'];
            $user->cpf = $data['cpf'];
            $user->phone = $data['phone'];
            $user->email = $data['email'];
            
            $user->status = $data['status'];

            $user->logradouro = $data['logradouro'];
            $user->numero = $data['numero'];
            $user->bairro = $data['bairro'];
            $user->complemento = $data['complemento'] ?? '';
            $user->cidade = $data['cidade'];
            $user->uf = $data['uf'];
            $user->cep = $data['cep'];

            $user->save();

            $return['success'] = true;
            $return['message'][] = 'Cliente atualizado com sucesso';
        }

        $return['message'] = implode("<br>", $return['message']);

        return redirect("admin/users/{$user->id}/edit")->with("return", $return);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function aprovar(User $user){

        if($user->status == User::STATUS_EMESPERA){
            
            // Define status de aprovado
            $user->status = User::STATUS_APROVADO;
            $user->save();


            return back()->with("success", "Conta aprovada!");
        } else {
            return back()->with("error", "Conta não está apta para ser aprovada");
        }
    }
    
    public function recusar(User $user){

        if($user->status == User::STATUS_EMESPERA){
            
            // Define status de aprovado
            $user->status = User::STATUS_RECUSADO;
            $user->save();

            return back()->with("success", "Conta recusada!");
        } else {
            return back()->with("error", "Conta não está apta para ser recusada");
        }
    }
}
