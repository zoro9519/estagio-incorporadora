@extends("templates.admin")

@section('content')

<section class="content p-2">

    @if ($currentReserva)
    <div class="row">
        <div class="col-12">
            <p class="alert alert-warning">Atenção! Este lote está reservado 
                @if(!empty($currentReserva->data_inicio))
                a partir de <b>{{
                    date("d/m/Y", strtotime($currentReserva->data_inicio))}}</b>
                @endif
                @if(!empty($currentReserva->data_fim))
                até <b>{{
                date("d/m/Y", strtotime($currentReserva->data_fim))}}</b>
                @endif
            </p>
        </div>
    </div>
    @endif

    <div class="row ">
        <div class="col">
            <div class="card">

                <div class="card-body">
                    <div class="row overflow-auto">

                        @if(session('return'))
                            <div class="col-12">
                                <div class="alert alert-{{session('return')['success'] ? 'success' : 'warning'}}">
                                    {{ session('return')['message'] }}
                                </div>
                            </div>
                            @endif

                        <div class="col-12 col-md-12 col-lg-6 order-2 order-md-1">

                            <h4 class="">Dados do Lote</h4>
                            <div class=" row">
                                <div class="col-12">

                                    <table class="table">
                                        <tr>
                                            <td>Descrição:</td>
                                            <td>{{ $lote->descricao }}</td>
                                        </tr>
                                        <tr>
                                            <td>Quadra:</td>
                                            <td><a href="{{route('admin.quadras.show', [ 'quadra' => $lote->quadra_id ])}}">{{ $lote->quadra->descricao }}</a></td>
                                        </tr>
                                        <tr>
                                            <td>Último(s) Dono(s):</td>
                                            <td>
                                                @if(!count($lote->atual()->all()))
                                                -
                                                @endif
                                                @foreach ($lote->atual() as $atual_prop)
                                                - {{ $atual_prop->nome }}<br>

                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Status:</td>
                                            <td>{{ $lote_status[$lote->status] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Criado Em:</td>
                                            <td>{{ date('d/m/Y H:i:s', strtotime($lote->created_at)) }}</td>
                                        </tr>
                                        {{-- @if ($lote->status != Lote::STATUS_SOLD)
                                        <tr>
                                            <td colspan="2">
                                                <a href="" data-toggle="modal"
                                                data-target="#modal-editar-lote" class="btn btn-info btn-block">Editar</a>
                                            </td>
                                        </tr>
                                        @endif --}}
                                        <tr>
                                            <td colspan="2">
                                                <div class="row p-2">
                                                    @if ($currentReserva)
                                                    <div class="col col-lg-6 col-sm-12 mb-2">
                                                        <button class="btn btn-block btn-primary" data-toggle="modal"
                                                        data-target="#modal-liberar-lote">Liberar
                                                            Lote
                                                        </button>
                                                    </div>
                                                    @endif
                                                    @if ($lote->status != Lote::STATUS_SOLD && empty($currentReserva))
                                                    <div class="col col-lg-6 col-sm-12 mb-2">
                                                        <button class="btn btn-block btn-primary" data-toggle="modal"
                                                        data-target="#modal-reservar-lote">Reservar
                                                            Lote</button>
                                                    </div>
                                                    @endif
                                                    @if ($lote->status == Lote::STATUS_AVAILABLE)
                                                    <div class="col col-lg-6 col-sm-12">
                                                        <button class="btn btn-block btn-success" data-toggle="modal"
                                                            data-target="#modal-vender-lote">Vender
                                                            Lote</button>
                                                    </div>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-vender-lote" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('admin.vendas.create', ['lote' => $lote]) }}">
                                        @csrf
                                        <input type="hidden" name="user" id="user_id">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Criar Venda</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="form-group">
                                                <label>Valor vendido:</label>
                                                <input class="form-control" type="text" name="valor" required
                                                    value="{{ $lote->valor }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Forma de Pagamento:</label>
                                                <select name="forma_pagamento" required class="form-control">
                                                    <option value="">Selecione</option>
                                                    <option value="cheque">Cheque</option>
                                                    <option value="fatura_cartao">Fatura Cartão</option>
                                                    <option value="carne">Carnê</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Número de Parcelas:</label>
                                                <input class="form-control" type="number" min=1 max=360
                                                    name="numero_parcelas" required>

                                            </div>
                                            <div class="form-group">
                                                <label>Cliente: <span id="cliente_nome"></span></label>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-12">

                                                                <div class="alert alert-danger d-none"
                                                                    id="errorResultSearch">
                                                                </div>
                                                                <label>Busca por CPF:</label>
                                                                <input type="text" id="cpf_busca" class="cpf">
                                                                <button type="button" id="searchCliente"
                                                                    class="btn btn-primary">Buscar</button>
                                                            </div>
                                                            <div class="col-12">
                                                                <div id="resultSearch"></div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Corretor: <span id="corretor_nome"></span></label>
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-12">

                                                                <label>Imobiliária:</label>
                                                                <select id="imobiliaria_filter" class="form-control">
                                                                    <option value="">Não possui</option>
                                                                    @foreach ($imobiliarias as $imobiliaria)
                                                                    <option value="{{$imobiliaria->id}}">
                                                                        {{$imobiliaria->nome}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-12 mt-2">
                                                                <label>Corretor:</label>
                                                                <select id="corretores_available" name="corretor"
                                                                    class="form-control">
                                                                    <option value="">Selecione</option>
                                                                    @foreach ($corretores as $corretor)
                                                                    <option value="{{$corretor->id}}">{{$corretor->nome
                                                                        . ($corretor->creci ? " - " . $corretor->creci :
                                                                        "")}}</option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer text-right">
                                            <button type="submit" class="btn btn-primary">Salvar Venda</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>

                        <div class="modal fade" id="modal-transferir-propriedade" style="display: none;"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST"
                                        action="{{ route('admin.lotes.proprietarios.transferir', ['lote' => $lote]) }}">
                                        @csrf
                                        <div class="modal-header">
                                            <h4 class="modal-title">Transferir Propriedade</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h3>Dados pessoais</h3>
                                            <div class="form-group">
                                                <label>Nome:</label>
                                                <input type="text" name="nome" required class="form-control">
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Documento:</label>
                                                        <input type="text" name="documento" required class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Celular:</label>
                                                        <input type="text" name="phone" required class="form-control phone">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label>Email:</label>
                                                <input type="email" name="email" required class="form-control">
                                            </div>

                                            <h3>Dados de endereço</h3>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>CEP:</label>
                                                        <input type="text" required="required" name="cep"
                                                            class="form-control cep">
                                                    </div>
                                                </div>
                                                <div class="col-8">
                                                    <div class="form-group">
                                                        <label>Logradouro:</label>
                                                        <input type="text" required='required' name="logradouro"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label>Número:</label>
                                                        <input type="number" required='required' name="numero"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Bairro:</label>
                                                        <input type="text" required="required" name="bairro"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Complemento:</label>
                                                        <input type="text" name="complemento" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-8">
                                                    <div class="form-group">
                                                        <label>Cidade:</label>
                                                        <input type="text" required="required" name="cidade"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label>UF:</label>
                                                        <input type="text" required="required" name="uf"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer text-right">
                                            <button type="submit" class="btn btn-primary">Transferir Propriedade</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>

                        <div class="modal fade" id="modal-reservar-lote" style="display: none;"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST"
                                        action="{{ route('admin.lotes.reservar', ['lote' => $lote]) }}">
                                        @csrf
                                        <div class="modal-header">
                                            <h4 class="modal-title">Reservar Lote</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Data inicial:</label>
                                                        <input type="date" name="data_inicio" required class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Data final:</label>
                                                        <input type="date" name="data_fim" required class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Observação:</label>
                                                        <input type="text" name="observacao" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Corretor:</label>
                                                        <select id="corretor" name="corretor" required class="form-control">
                                                            <option value="">Selecione</option>
                                                            @foreach ($allCorretores as $corretor)
                                                            <option value="{{ $corretor->id }}">{{ ($corretor->imobiliaria ? "{$corretor->imobiliaria->nome} - " : "") . "$corretor->nome - $corretor->phone" }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="modal-footer text-right">
                                            <button type="submit" class="btn btn-primary">Reservar</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>

                        <div class="modal fade" id="modal-liberar-lote" style="display: none;"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form method="POST"
                                        action="{{ route('admin.lotes.liberar', ['lote' => $lote]) }}">
                                        @csrf
                                        <div class="modal-header">
                                            <h4 class="modal-title">Liberar Lote</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h4>Selecione as reservas que deseja remover</h4>

                                            <div class="row">
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <label>Remover</label>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label>Período</label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Observação</label>
                                                    </div>
                                                </div>
                                            </div>
                                            @foreach ($reservas->where('status', Agendamento::STATUS_AGENDADO) as $reserva)
                                            
                                            <div class="row">
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <input type="checkbox" name="reservas" value="{{$reserva->id}}" required class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <p>{{ date("d/m/Y", strtotime($lote->lastReserva->first()->data_inicio)) }} a {{date("d/m/Y", strtotime($lote->lastReserva->first()->data_fim))}}</p>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <p>
                                                            {{$reserva->observacao}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach

                                        </div>
                                        <div class="modal-footer text-right">
                                            <button type="submit" class="btn btn-primary">Liberar</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>


                        <div class="col-12 col-md-12 col-lg-6 order-1 order-md-2">
                            @if ($lote->status != 'V')
                            <h4 class="">Agendamentos marcados</h4>
                            <div class=" row">
                                <div class="col col-12">
                                    <table class="table">
                                        <th>Data da Visita</th>
                                        <th>Status</th>
                                        <th>Cliente</th>
                                        <th>Contato</th>
                                        <th>Visualizar</th>
                                        <tbody>
                                            @foreach ($lote->agendamentos()
                                            ->where('data_inicio', '>', date('Y-m-d
                                            00:00:00'))
                                            ->where('type', Agendamento::TYPE_VISITA)
                                            ->get()
                                            as $agendamento)
                                            <tr>
                                                <td>{{ date('d/m/Y H:i:s', strtotime($agendamento->data_inicio)) }}
                                                </td>
                                                <td>{{ $agendamento_status[$agendamento->status] }}</td>
                                                <td>
                                                    <a
                                                        href="{{ route('admin.users.show', ['user' => $agendamento->cliente]) }}">{{
                                                        $agendamento->cliente->nome }}</a>
                                                </td>
                                                <td>{{ $agendamento->cliente->phone }}</td>
                                                <td class="text-center"><a
                                                        href="{{ route('admin.agendamentos.show', ['agendamento' => $agendamento]) }}"
                                                        class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @else
                            <h4 class="">Dados da Venda</h4>
                            <div class=" row">
                                <div class="col col-12">
                                    <table class="table">
                                        <tr>
                                            <td>Valor vendido</td>
                                            <td>{{ numberToMoney($lote->venda->valor) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Forma de pagamento</td>
                                            <td>{{$formas_pagamento[$lote->venda->forma_pagamento]}} -
                                                {{$lote->venda->nro_parcelas}} vezes</td>
                                        </tr>
                                        <tr>
                                            <td>Corretor</td>
                                            <td><i><a href="{{route("admin.corretores.show", [ "corretor"=>
                                                        $lote->venda->corretor])}}">{{$lote->venda->corretor->nome}}</a></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Comprador</td>
                                            <td><i><a href="{{route("admin.users.show", [ "user"=>
                                                        $lote->venda->comprador])}}">{{$lote->venda->comprador->nome}}</a></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><a class="btn btn-success btn-block" href="{{route("admin.vendas.show", [ "venda"=>
                                                    $lote->venda->id])}}">Visualizar Venda</a></td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                            @endif
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
                        <div class="col col-6">
                            <h4 class="card-title ">
                                <a class="d-block" data-toggle="collapse" href="#proprietarios">
                                    <h4 class="">
                                        Proprietários
                                        <div class="badge badge-primary">{{$lote->proprietarios()->count()}}</div>
                                    </h4>
                                </a>
                            </h4>
                        </div>
                        <div class="col col-6 text-right">
                            <div class="btn-group">
                                @if($lote->proprietarios()->count())
                                <button class="btn btn-block btn-success mr-2" data-toggle="modal"
                                    data-target="#modal-transferir-propriedade">Transferir Propriedade</button>
                                @endif
                                <a class="btn btn-primary" href="#" data-toggle="modal"
                                    data-target="#modal-add-proprietario">
                                    <i class="fas fa-plus">
                                    </i>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Add Proprietario --}}
                    <div class="modal fade" id="modal-add-proprietario" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST"
                                    action="{{ route('admin.lotes.proprietarios.store', ['lote' => $lote]) }}">
                                    @csrf
                                    <div class="modal-header">
                                        <h4 class="modal-title">Adicionar Proprietário</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <h3>Informações do proprietário</h3>
                                        <div class="form-group">
                                            <label>Nome:</label>
                                            <input type="text" name="nome" required class="form-control">
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Documento:</label>
                                                    <input type="text" name="documento" required class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Celular:</label>
                                                    <input type="text" name="phone" required class="form-control phone">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input type="email" name="email" required class="form-control">
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Data Início:</label>
                                                    <input type="date" name="data_inicio" required class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Data Fim:</label>
                                                    <input type="date" name="data_fim" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                        <h3>Dados de endereço</h3>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>CEP:</label>
                                                    <input type="text" required="required" name="cep"
                                                        class="form-control cep">
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label>Logradouro:</label>
                                                    <input type="text" required='required' name="logradouro"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>Número:</label>
                                                    <input type="number" required='required' name="numero"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Bairro:</label>
                                                    <input type="text" required="required" name="bairro"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Complemento:</label>
                                                    <input type="text" name="complemento" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="form-group">
                                                    <label>Cidade:</label>
                                                    <input type="text" required="required" name="cidade"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>UF:</label>
                                                    <input type="text" required="required" name="uf"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer text-right">
                                        <button type="submit" class="btn btn-primary">Cadastrar
                                            Proprietário</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <div id="proprietarios" class="collapse w-100" data-parent="#lista_exibe" style="">
                        <div class="card-body">

                            <table class="table">
                                <thead>
                                    {{-- <th>#</th> --}}
                                    <th>Nome</th>
                                    <th>Data Início</th>
                                    <th>Data Fim</th>
                                    <th>Ações</th>
                                </thead>
                                <tbody>
                                    @foreach ($lote->proprietarios()->orderBy(DB::raw('data_fim IS NOT NULL, data_fim'),
                                    'desc')->get()
                                    as $proprietario)
                                    <tr>
                                        {{-- <td>{{ $proprietario->id }}</td> --}}
                                        <td>{{ $proprietario->nome }}</td>
                                        <td>{{ date('d/m/Y', strtotime($proprietario->data_inicio)) }}
                                        </td>
                                        <td>{{ $proprietario->data_fim ? date('d/m/Y',
                                            strtotime($proprietario->data_fim)) : 'Atual' }}
                                        </td>
                                        <td>
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('admin.lotes.proprietarios.show', ['proprietario' => $proprietario]) }}">
                                                <i class="fas fa-eye">
                                                </i>
                                            </a>
                                            <a class="btn btn-danger btn-sm"
                                                href="{{ route('admin.lotes.proprietarios.remove', ['proprietario' => $proprietario]) }}">
                                                <i class="fas fa-trash">
                                                </i>
                                            </a>
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
        
    <div class="row">
        <div class="col" id="lista_exibe">

            <div class="card">
                <div class="card-header">
                    <div class="row p-3">
                        <div class="col col-12">
                            <h4 class="card-title">
                                <a class="d-block" data-toggle="collapse" href="#coordenadas">
                                    <h4 class="">Coordenadas</h4>
                                </a>
                            </h4>
                        </div>
                    </div>
                    <div id="coordenadas" class="collapse w-100" data-parent="#lista_exibe" style="">
                        <div class="card-body">

                            <table class="table">
                                <thead>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                </thead>
                                <tbody>
                                    @foreach ($lote->coordenadas as $coord)
                                    <tr>
                                        <td>{{$coord->latitude}}</td>
                                        <td>{{$coord->longitude}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
</section>
<script>
    var adminToken = '{{ Auth::user()->token }}';
    var siteUrl = "{{ env('APP_URL') }}";
    var tokenCRSF = "{{ csrf_token() }}";
    
</script>
@endsection

@section('js')
<script src="{{ url('js/HTTPClient.js') }}"></script>
<script src="{{ url('js/lotes/view.js') }}"></script>
@endsection