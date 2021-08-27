@extends("templates.admin")

@section('content')
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h3 class="card-title">Loteamentos</h3>
                    </div>
                    <div class="col col-4 text-right">
                        <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal-add-loteamento">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        {{-- Modal Add Loteamento --}}
        <div class="modal fade" id="modal-add-loteamento" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('loteamento.store') }}">
                        @csrf
                        <div class="modal-header">
                            <h4 class="modal-title">Adicionar Loteamento</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label>Nome:</label>
                                <input type="text" name="nome">
                            </div>
                            <div class="form-group">
                                <label>Link:</label>
                                <input type="text" name="link">
                            </div>
                            <div class="form-group">
                                <label>Descrição:</label>
                                <input type="text" name="descricao">
                            </div>
                            <div class="form-group">
                                <label>Área:</label>
                                <input type="number" step="0.1" name="area">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary">Criar Loteamento</button>
                        </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <div class="card-body p-0">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th style="width: 1%">
                            #
                        </th>
                        <th style="width: 25%">
                            Nome
                        </th>
                        <th style="width: 20%">
                            Link
                        </th>
                        <th style="width: 5%" class="">
                            Nº de Lotes
                        </th>
                        <th style="width: 5%" class="text-center">
                            Lotes Disponíveis
                        </th>
                        <th style="width: 5%">
                            Interessados
                        </th>
                        <th style="width: 20%" class="text-center">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loteamentos as $loteamento)

                        <tr id="r-{{ $loteamento->id }}">
                            <td>
                                {{ $loteamento->id }}
                            </td>
                            <td>
                                <a>
                                    {{ $loteamento->nome }}
                                </a>
                                <br />
                                <small>
                                    Criado em: {{ date('d/m/Y', strtotime($loteamento->created_at)) }}
                                </small>
                            </td>
                            <td>
                                <a href="{{ env('APP_URL') }}/{{ $loteamento->link }}">
                                    {{ env('APP_URL') }}/{{ $loteamento->link }}
                                </a>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-primary">
                                    {{ $loteamento->lotes()->count() }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-success">
                                    {{ $loteamento->lotes()->where('status', 'L')->count() }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-warning">
                                    0
                                    {{-- {{ $loteamento->lotes()->where("status", "L")->count() }} --}}
                                </span>
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-primary btn-sm"
                                    href="{{ route('loteamento.show', ['loteamento' => $loteamento]) }}">
                                    <i class="fas fa-folder"></i> View
                                </a>
                                {{-- <a class="btn btn-info btn-sm" href="#">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a> --}}
                                {{-- <a class="btn btn-danger btn-sm" href="#">
                                    <i class="fas fa-trash"></i> Delete
                                </a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
@endsection
