@extends('templates.mail')

@section('content')
<div class="row mb-4">
    <div class="col-12 text-center">
        <h3>Lote comprado!</h3>
    </div>
</div>

<div class="row">
    <div class="col-12">
        Olá {{$venda->comprador->nome}}, o lote {{ $venda->lote->descricao }} foi comprado por você!
    </div>
</div>

<div class="row">
    <div class="col-12">
        Dados do lote
        <table>
            <tr>
                <td>Data de processamento</td>
                <td>Loteamento</td>
                <td>Quadra / Lote</td>
                <td>Valor</td>
                <td>Forma de Pagamento</td>
            </tr>
            <tr>
                <td>{{date("d/m/Y H:i:s", strtotime($venda->created_at))}}</td>
                <td>{{$venda->lote->quadra->loteamento->nome}}</td>
                <td>{{$venda->lote->quadra->descricao}} / {{$venda->lote->descricao}}</td>
                <td>{{numberToMoney($venda->lote->valor)}}</td>
                <td>{{$formas_pagamento[$venda->forma_pagamento]}}</td>
            </tr>
        </table>
    </div>
    <div class="col-12">
        Em breve um de nossos administradores entrará em contato para mais detalhes sobre pagamento, escriturações e tirar qualquer dúvida sobre o processo.
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