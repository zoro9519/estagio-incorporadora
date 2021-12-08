@extends('templates.mail')

@section('content')
<div class="row mb-4">
    <div class="col-12 text-center">
        <h3>Seja bem-vindo(a) <b>{{$user->nome}}</b>!</h3>
    </div>
</div>

<div class="row">
    <div class="col-12">
        
        A partir de agora você possui um acesso temporário aos loteamentos <i>{{env("APP_NAME")}}</i> para te ajudar a fechar sua próxima propriedade.        
    </div>
</div>

<div class="row">
    <div class="col-12">
        
        Para acessar é simples:
        <ol>
            <li><a href="{{route('user.auth')}}" class="btn btn-info">Acesse este link </a></li>
            <li>Confirme que é você</li>
            <li>Preencha os dados faltantes</li>
            <li>Pronto! A partir daqui você pode solicitar visitas aos loteamentos e acompanhar os lançamentos</li>
        </ol>

        <div class="card p-3">
            <div class="card-body">
                <div class="row">
                    <h4>Seus dados de acesso:</h4>
                </div>
                <div class="row">
                    <p>Email: {{$user->email}}</p>
                </div>
                <div class="row">
                    <p>Senha: Os primeiros 6 caracteres do seu email</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        Desejamos sucesso em suas negociações! Para qualquer dúvida, entre em contato conosco: <a href="mailto:{{env("APP_EMAIL")}}">{{env("APP_EMAIL")}}</a>
    </div>
</div>
    
<br>
<br>

@endsection