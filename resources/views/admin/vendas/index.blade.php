@extends("templates.admin")

@section('content')

<section class="content p-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Filtros</h4>
                    </div>
                    <div class="card-body">
            
                        <form action="">
                            <div class="row">
                                {{-- <div class="col-4">
                                    <div class="form-group">
                                        <label>Status da Venda</label>
                                        <select name="filterStatus" class="form-control">
                                            <option>Todos</option>
                                            <option value="A">Aguardando Aprovação</option>
                                            <option value="C">Confirmado</option>
                                            <option value="R">Recusado</option>
                                            <option value="F">Finalizado</option>

                                        </select>
                                    </div>
                                </div> --}}
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Data inicial</label>
                                        <input type="date" name="filterDataInicio" class="form-control" value="{{Request::get('filterDataInicio') ??''}}">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Data final</label>
                                        <input type="date" name="filterDataFim" class="form-control" value="{{Request::get('filterDataFim') ??''}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group text-right">
                                        <button type="button" class="btn btn-primary">Filtrar</button>
                                        <a href="{{ route('admin.vendas.all') }}" class="btn btn-warning">Limpar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                        <div class="col">
                            <table class="table table-striped projects">
                                <thead>
                                    <th>#</th>
                                    <th>Comprador</th>
                                    <th>Lote</th>
                                    <th>Data</th>
                                    {{-- <th>Situação</th> --}}
                                    <th>Valor negociado</th>
                                    <th>Ações</th>
                                </thead>
                                <tbody>
                                    @foreach ($vendas as $venda)
                                    <tr>
                                        <td>{{ $venda->id }}</td>
                                        <td>
                                            <a href="{{route("admin.users.show", [ 'user' => $venda->comprador ])}}">
                                                {{ $venda->comprador()->first()->nome }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{route("admin.lotes.show", [ 'lote' => $venda->lote ])}}">
                                                {{ $venda->lote->descricao }}
                                            </a>
                                        </td>
                                        <td>{{ date("d/m/Y H:i:s", strtotime($venda->created_at)) }}</td>
                                        {{-- <td>{{ $venda->loteamento()->nome ?? "Não definido" }}</td> --}}
                                        {{-- <td>{{ $venda->lote()->nome ?? "Não definido" }}</td> --}}
                                        {{-- <td>-{{ $venda->status }}</td> --}}
                                        <td>{{numberToMoney($venda->valor) }}</td>
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{ route('admin.vendas.show', ['venda' => $venda]) }}">
                                                <i class="fas fa-eye">
                                                </i>
                                            </a>
                                            {{-- <a class="btn btn-danger btn-sm" href="{{ route('admin.venda.delete', ['venda' => $venda]) }}"> --}}
                                                {{-- <i class="fas fa-trash">
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