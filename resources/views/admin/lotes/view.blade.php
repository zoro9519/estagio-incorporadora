@extends("templates.admin")

@section('content')

<section class="content p-2">

    @if (true)
    <div class="row">
        <div class="col-12">
            <p class="alert alert-warning">Atenção! Este lote está reservado até XX/XX/XXXX</p>
        </div>
    </div>
    @endif

    <div class="row ">
        <div class="col">
            <div class="card">

                <div class="card-body">
                    <div class="row overflow-auto">

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
                                            <td>Último(s) Dono(s):</td>
                                            <td>
                                                @foreach ($lote->atual() as $atual_prop)
                                                - {{ $atual_prop->nome }}<br>

                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Criado Em:</td>
                                            <td>{{ date('H:i:s d/m/Y', strtotime($lote->created_at)) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="row p-2">
                                                    @if (true)
                                                    <div class="col col-lg-6 col-sm-12 mb-2">
                                                        <button class="btn btn-block btn-primary">Liberar
                                                            Lote</button>
                                                    </div>

                                                    @else
                                                    <div class="col col-lg-6 col-sm-12 mb-2">
                                                        <button class="btn btn-block btn-primary">Reservar
                                                            Lote</button>
                                                    </div>
                                                    @endif
                                                    @if ($lote->status == 'L')
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
                                    <div class="
                            text-center mt-4">
                                        {{-- <a href="#" class="btn btn-sm btn-primary">Add files</a>
                            <a href="#" class="btn btn-sm btn-warning">Report contact</a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-vender-lote" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('admin.lotes.vender', ['lote' => $lote]) }}">
                                        @csrf
                                        <input type="hidden" name="admin" value="{{ Auth::user()->id }}">
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
                                                <input class="form-control" type="text" name="valor" required value="{{ $lote->valor }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Forma de Pagamento:</label>
                                                <select name="forma_pagamento" required class="form-control">
                                                    <option value="">Selecione</option>
                                                    <option value=" cheque">Cheque</option>
                                                    <option value="fatura_cartao">Fatura Cartão</option>
                                                    <option value="carne">Carnê</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Número de Parcelas:</label>
                                                <input class="form-control" type="number" min=1 max=360 name="numero_parcelas" required>

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
                                                                <input type="text" id="cpf_busca" class="">
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
                                                                        <option value="{{$imobiliaria->id}}">{{$imobiliaria->nome}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-12 mt-2">
                                                                <label>Corretor:</label>
                                                                <select id="corretores_available" name="corretor" class="form-control">
                                                                    <option value="">Selecione</option>
                                                                    @foreach ($corretores as $corretor)
                                                                    <option value="{{$corretor->id}}">{{$corretor->nome . ($corretor->creci ? " - " . $corretor->creci : "")}}</option>
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
                                            @foreach ($lote->agendamentos()->where('data_inicio', '>', date('Y-m-d
                                            00:00:00'))->get()
                                            as $agendamento)
                                            <tr>
                                                <td>{{ date('d/m/Y H:i:s', strtotime($agendamento->data_inicio)) }}
                                                </td>
                                                <td>{{ $agendamento_status[$agendamento->status] }}</td>
                                                <td>
                                                    <a
                                                        href="{{ route('admin.users.show', ['user' => $agendamento->cliente()->first()]) }}">{{ $agendamento->cliente()->first()->nome }}</a>
                                                </td>
                                                <td>{{ $agendamento->cliente()->first()->phone }}</td>
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
                                    Venda #{{ $lote->venda()->first()->id }}

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
                        <div class="col col-8">
                            <h4 class="card-title ">
                                <a class="d-block " data-toggle="collapse" href="#proprietarios" aria-expanded="true">
                                    <h4 class=""> Proprietários</h4>
                                </a>
                            </h4>
                        </div>
                        <div class="
                                            col col-4 text-right">
                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal-add-proprietario">
                                <i class="fas fa-plus">
                                </i>
                            </a>
                        </div>
                    </div>

                    {{-- Modal Add Proprietario --}}
                    <div class="modal fade" id="modal-add-proprietario" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST"
                                    action="{{ route('admin.lotes.adicionar_proprietario', ['lote' => $lote]) }}">
                                    @csrf
                                    <div class="modal-header">
                                        <h4 class="modal-title">Adicionar Proprietário</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label>Nome:</label>
                                            <input type="text" name="nome" required class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Documento:</label>
                                            <input type="text" name="documento" required class="form-control">
                                        </div>
                                        <div class="
                                                    form-group">
                                            <label>Data Início:</label>
                                            <input type="date" name="data_inicio" required class="form-control">
                                        </div>
                                        <div class="
                                                    form-group">
                                            <label>Data Fim:</label>
                                            <input type="date" name="data_fim" class="form-control">
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
                    <div id="proprietarios" class="collapse show w-100" data-parent="#lista_exibe" style="">
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
                                        <td>{{ $proprietario->data_fim ? date('d/m/Y', strtotime($proprietario->data_fim)) : 'Atual' }}
                                        </td>
                                        <td>
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('admin.proprietarios.show', ['proprietario' => $proprietario]) }}">
                                                <i class="fas fa-eye">
                                                </i>
                                            </a>
                                            <a class="btn btn-danger btn-sm"
                                                href="{{ route('admin.proprietarios.remove', ['proprietario' => $proprietario]) }}">
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