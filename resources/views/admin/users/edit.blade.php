@extends("templates.admin")

@section('content')
<section class="content p-2">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{route("admin.users.update", ['user' => $user->id])}}">
                        @csrf
                        <div class="row">
                            @if(session('return'))
                            <div class="col-12">
                                <div class="alert alert-{{session('return')['success'] ? 'success' : 'warning'}}">
                                    {{ session('return')['message'] }}
                                </div>
                            </div>
                            @endif
                            {{-- <div class="col-12 col-md-12 col-lg-6 order-2 order-md-1"> --}}
                            <div class="col-12">
                                <h4 class="">Dados do Cliente</h4>
                                <div class="row">

                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="nome">Nome: *</label>
                                            <input type="text" class="form-control" id="nome" name="nome" value="{{$user->nome}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="cpf">CPF: *</label>
                                            <input type="text" class="cpf form-control" id="cpf" name="cpf" value="{{$user->cpf}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="phone">Celular: *</label>
                                            <input type="text" id="phone" name='phone' class="phone form-control" value="{{$user->phone}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="email">Email: *</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{$user->email}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="status">Status: *</label>
                                            <select class="form-control" id="status" name="status" required>
                                                @foreach ($user_status as $key => $status)
                                                    <option value="{{$key}}" {{ $key == $user->status ? "selected" : ""}}>{{$status}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Criado em:</label>
                                            <input type="text" class="form-control" disabled value='{{ $user->created_at ? date("d/m/Y H:i:s", strtotime($user->created_at)) : ""}}'>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="col-12 mt-2">
                                <h4 class="">Dados de Endereço</h4>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="cep">CEP: *</label>
                                            <input type="text" class="form-control" id="cep" name="cep" value="{{$user->cep ?? ""}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="logradouro">Logradouro: *</label>
                                            <input type="text" class="form-control" id="logradouro" name="logradouro" value="{{$user->logradouro}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <div class="form-group">
                                            <label for="numero">Número:</label>
                                            <input type="number" class="form-control" id="numero" name="numero" value="{{$user->numero}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-sm-12">
                                        <div class="form-group">
                                            <label for="bairro">Bairro: *</label>
                                            <input type="text" id="bairro" name='bairro' class="bairro form-control" value="{{$user->bairro}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-sm-12">
                                        <div class="form-group">
                                            <label for="complemento">Complemento:</label>
                                            <input type="text" class="form-control" id="complemento" name="complemento" value="{{$user->complemento ?? ""}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <div class="form-group">
                                            <label for="cidade">Cidade: *</label>
                                            <input type="text" class="form-control" id="cidade" name="cidade" value="{{$user->cidade ?? ""}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-3">
                                        <div class="form-group">
                                            <label for="uf">UF: *</label>
                                            <input type="text" class="form-control" id="uf" name="uf" value="{{$user->uf ?? ""}}" required>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        
                            <div class="col-12">
                                <a class="btn btn-info" href="{{route('admin.users.show', [ 'user' => $user->id])}}">Voltar</a>
                                <button type="submit" class="btn btn-success">Salvar</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection
