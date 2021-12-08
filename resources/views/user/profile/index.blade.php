@extends("templates.user")
@section('page_title')Meus Dados
@endsection
@section('content')
<div class="content">
    <div class="row p-3">
        @if(session('return'))
        <div class="col-12">
            <div class="alert alert-{{session('return')['success'] ? 'success' : 'warning'}}">
                {{ session('return')['message'] }}
            </div>
        </div>
        @endif
        <div class="col col-12">
            <div class="card ">
                <div class="card-body">

                    <form action="{{ route('user.profile.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <h3>Dados Pessoais</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <label for="nome">Nome: *</label>
                                        <input type="text" class="form-control" name="nome"
                                            value="{{ Auth::user()->nome ?? '' }}" required>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="cpf">CPF: *</label>
                                            <input type="text" class="form-control cpf" name="cpf"
                                                value="{{ Auth::user()->cpf ?? '' }}" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-sm-12">
                                        <label for="phone">Celular: *</label>
                                        <input type="text" class="form-control phone" name="phone"
                                            value="{{ Auth::user()->phone ?? '' }}" required>
                                    </div>

                                    <div class="col-lg-6 col-sm-12">
                                        <label for="email">Email: *</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ Auth::user()->email ?? '' }}" required disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-4">

                                <h3>Endereço</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="cep">CEP: *</label>
                                            <input type="text" class="form-control cep" name="cep"
                                                value="{{ Auth::user()->cep ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="logradouro">Logradouro: *</label>
                                            <input type="text" class="form-control" name="logradouro"
                                                value="{{ Auth::user()->logradouro ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="numero">Número</label>
                                            <input type="number" class="form-control" name="numero"
                                                value="{{ Auth::user()->numero ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="bairro">Bairro: *</label>
                                            <input type="text" class="form-control" name="bairro"
                                                value="{{ Auth::user()->bairro ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="complemento">Complemento</label>
                                            <input type="text" class="form-control" name="complemento"
                                                value="{{ Auth::user()->complemento ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label for="cidade">Cidade: *</label>
                                            {{-- <select class="form-control" name="cidade" required>
                                                @foreach ($cities as $city)
                                                <option value="{{$city['city']}}" {{$city['city'] == Auth::user()->cidade ? 'selected' : ''}}>{{$city['city']}}
                                                </option>
                                                @endforeach
                                            </select> --}}
                                            <input type="text" class="form-control" name="cidade"
                                                value="{{ Auth::user()->cidade ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="uf">UF: *</label>
                                            <select class="form-control" name="uf" required>
                                                @foreach ($ufs as $uf => $state)
                                                <option value="{{$uf}}" {{$uf == Auth::user()->uf ? 'selected' : ''}}>{{$state}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group text-center">
                                            <button type="submit" class="btn btn-success">Salvar dados</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection