@extends("templates.admin")

@section('content')
<section class="content card-body">
    <div class="row">
        <div class="col-12">

            <div class="card p-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3 align-self-center">
                            <img src="{{ env('AWS_BASE') . $corretor->profile_picture }}" class="img-list"
                                style="max-width:100%" />
                        </div>
                        <div class="offset-1 col-8">
                            <div class="row">
                                <h4>Dados do corretor</h4>

                                <table class="table">
                                    <tr>
                                        <td>Nome</td>
                                        <td>{{$corretor->nome}}</td>
                                    </tr>
                                    <tr>
                                        <td>Documento</td>
                                        <td>{{$corretor->cpf}}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>{{$corretor->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>Celular</td>
                                        <td>{{$corretor->phone}}</td>
                                    </tr>
                                    <tr>
                                        <td>Taxas</td>
                                        <td><b>{{$corretor->taxa_venda_porcentagem ?? 0}}% ou {{numberToMoney($corretor->taxa_venda_valor ?? 0)}}</td>
                                    </tr>
                                    @if($corretor->imobiliaria)
                                    <tr>
                                        <td>Imobiliária</td>
                                        <td>
                                            <a href="{{route("admin.imobiliarias.show", ["imobiliaria" => $corretor->imobiliaria->id])}}">
                                                {{$corretor->imobiliaria->nome}}
                                            </a>
                                        </td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td colspan='2'>
                                            <a class="btn btn-block btn-info" href="{{route("admin.corretores.edit", ['corretor' => $corretor->id])}}">Editar</a>
                                        </td>
                                        
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col" id="lista_exibe">

            <div class="card">
                <div class="card-header">
                    <div class="row p-3">
                        <div class="col col-8">
                            <h4 class="card-title ">
                                <a class="d-block " data-toggle="collapse" href="#vendas" aria-expanded="true">
                                    <h4 class="___class_+?17___"> Vendas</h4>
                                </a>
                            </h4>
                        </div>
                    </div>

                    <div id="vendas" class="collapse show w-100" data-parent="#lista_exibe" style="">
                        <div class="card-body">
                            {{-- @if(session("error_message_venda"))
                                <div class="alert alert-danger">
                                    {{session("error_message_venda")}}
                                </div>
                            @endif --}}
                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th>Data</th>
                                    <th>Comprador</th>
                                    <th>Lote</th>
                                    <th>Valor Total</th>
                                    <th>Ações</th>
                                </thead>
                                <tbody>
                                    @foreach ($corretor->vendas as $venda)
                                        <tr>
                                            <td>{{ $venda->id }}</td>
                                            <td>{{ date('H:i:s d/m/Y', strtotime($venda->created_at)) }}</td>
                                            <td><a href="{{route("admin.users.show", [ 'user' => $venda->comprador->id ])}}">{{ $venda->comprador->nome }}</a></td>
                                            <td><a href="{{route("admin.lotes.show", [ 'lote' => $venda->lote->id ])}}">{{ $venda->lote->descricao }}</a></td>
                                            <td>{{ numberToMoney($venda->valor) }}</td>
                                            <td>
                                                <a class="btn btn-primary btn-sm"
                                                    href="{{ route('admin.vendas.show', ['venda' => $venda]) }}">
                                                    <i class="fas fa-eye">
                                                    </i>
                                                </a>
                                                {{-- <a class="btn btn-info btn-sm" href="#">
                                                    <i class="fas fa-pencil-alt">
                                                    </i>
                                                    Edit
                                                </a> --}}
                                                {{-- <a class="btn btn-danger btn-sm"
                                                    href="{{ route('admin.vendas.delete', ['venda' => $venda]) }}">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                </a> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section>
        @endsection