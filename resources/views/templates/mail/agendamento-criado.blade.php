@extends('templates.mail')

@section('content')
<div class="row mb-4">
    <div class="col-12 text-center">
        <h3>Novo agendamento realizado!</h3>
    </div>
</div>

<div class="row">
    <div class="col-12">
        Olá {{$user->nome}}, um novo agendamento foi criado em sua conta!
    </div>
</div>

<div class="row">
    <div class="col-12">
        Dados do agendamento
        <table>
            <tr>
                <td>Data</td>
                <td>Loteamento</td>
                @if($agendamento->lote)
                    <td>Quadra</td>
                    <td>Lote</td>
                @endif
            </tr>
            <tr>
                <td>{{date("d/m/Y H:i:s", strtotime($agendamento->data_inicio))}}</td>
                <td>{{$agendamento->loteamento->nome}}</td>
                @if($agendamento->lote)
                    <td>{{$agendamento->lote->quadra->descricao}}</td>
                    <td>{{$agendamento->lote->descricao}}</td>
                @endif
            </tr>
        </table>
    </div>
    <div class="col-12">
        Em breve você terá a confirmação do seu agendamento, além das informações sobre o guia que fará o acompanhamento. 
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