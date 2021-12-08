@extends("templates.admin")

@section('content')
<section class="content p-2">

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-6 order-2 order-md-1">

                            <h4 class="">Dados do Cliente</h4>

                            <div class=" table">
                                <table class="">
                                    <tr>
                                        <td>Nome:</td>
                                        <td>{{ $user->nome }}</td>
                                    </tr>
                                    <tr>
                                        <td>CPF:</td>
                                        <td>{{ $user->cpf }}</td>
                                    </tr>
                                    <tr>
                                        <td>Celular:</td>
                                        <td>{{ $user->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status:</td>
                                        <td>
                                            {{$user_status[$user->status]}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Criado Em:</td>
                                        <td>{{ date('d/m/Y H:i:s', strtotime($user->created_at)) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><a href="{{route("admin.users.edit", ['user' => $user->id])}}" class='btn btn-block btn-info'>Editar</a></td>
                                       
                                    </tr>

                                </table>
                            </div>
                        </div>

                        <div class="col-12 col-md-12 col-lg-6 order-1 order-md-2">
                            <h4 class="">Dados de endereço</h4>
                            <div class="table">
                                <table class="">
                                    <tr>
                                        <td>Logradouro:</td>
                                        <td>{{ $user->logradouro }}</td>
                                    </tr>
                                    <tr>
                                        <td>Número:</td>
                                        <td>{{ $user->numero }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bairro:</td>
                                        <td>{{ $user->bairro }}</td>
                                    </tr>
                                    <tr>
                                        <td>Complemento:</td>
                                        <td>{{ $user->complemento }}</td>
                                    </tr>
                                    <tr>
                                        <td>Cidade</td>
                                        <td>{{ $user->cidade }}</td>
                                    </tr>
                                    <tr>
                                        <td>UF</td>
                                        <td>{{ $user->uf }}</td>
                                    </tr>
                                    <tr>
                                        <td>CEP</td>
                                        <td>{{ $user->cep }}</td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col" id="lista_exibe">

            <div class="card">
                <div class="card-header">
                    <div class="row p-3">
                        <div class="col col-8">
                            <h4 class="card-title ">
                                <a class="d-block " data-toggle="collapse" href="#compras" aria-expanded="true">
                                    <h4 class="___class_+?17___"> Compras</h4>
                                </a>
                            </h4>
                        </div>
                    </div>

                    <div id="compras" class="collapse show w-100" data-parent="#lista_exibe" style="">
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
                                    <th>Corretor</th>
                                    <th>Lote</th>
                                    <th>Valor Total</th>
                                    <th>Ações</th>
                                </thead>
                                <tbody>
                                    @foreach ($user->compras()->get() as $venda)
                                        <tr>
                                            <td>{{ $venda->id }}</td>
                                            <td>{{ date('H:i:s d/m/Y', strtotime($venda->created_at)) }}</td>
                                            <td><a href="{{route("admin.users.show", [ 'user' => $venda->corretor->id ])}}">{{ $venda->corretor->nome }}</a></td>
                                            <td><a href="{{route("admin.lotes.show", [ 'lote' => $venda->lote->id ])}}">{{ $venda->lote->descricao }}</a></td>
                                            <td>{{ $venda->valor }}</td>
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
                                                    href="{{ route('admin.compras.delete', ['venda' => $venda]) }}">
                                                    <i class="fas fa-trash">
                                                    </i>
                                                </a> --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
