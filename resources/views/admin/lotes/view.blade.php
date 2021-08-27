@extends("templates.admin")

@section('content')

    <section class="content">

        <div class="row">
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">

                <h4 class="p-2 mt-5">Dados do Lote</h4>

                <div class="table">
                    <table class="">
                        <tr>
                            <td>Descrição:</td>
                            <td>{{ $lote->descricao }}</td>
                        </tr>
                        <tr>
                            <td>Último Dono:</td>
                            <td>{{ $lote->atual() }}</td>
                        </tr>
                        <tr>
                            <td>Criado Em:</td>
                            <td>{{ date('H:i:s d/m/Y', strtotime($lote->created_at)) }}</td>
                        </tr>

                    </table>
                </div>
                <div class="text-center mt-4">
                    {{-- <a href="#" class="btn btn-sm btn-primary">Add files</a>
                    <a href="#" class="btn btn-sm btn-warning">Report contact</a> --}}
                </div>

            </div>
            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">

                <h4 class="mt-5">Dados de localização</h4>

            </div>
        </div>
        <hr>
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
                            <div class="col col-4 text-right">
                                <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal-add-lote">
                                    <i class="fas fa-plus">
                                    </i>
                                </a>
                            </div>
                        </div>

                        {{-- Modal Add Lote --}}
                        <div class="modal fade" id="modal-add-lote" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                  <form method="POST" action="{{route("lote.adicionar_proprietario", [ 'lote' => $lote])}}">
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
                                            <input type="text" name="nome">
                                        </div>
                                        <div class="form-group">
                                            <label>Documento:</label>
                                            <input type="text" name="documento" class="">
                                        </div>
                                        <div class="form-group">
                                            <label>Data Início:</label>
                                            <input type="date" name="data_inicio" class="">
                                        </div>
                                        <div class="form-group">
                                            <label>Data Fim:</label>
                                            <input type="date" name="data_fim" class="">
                                        </div>

                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-primary">Cadastrar Proprietário</button>
                                    </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        <div id="proprietarios" class="collapse show w-100" data-parent="#lista_exibe" style="">
                            <div class="card-body">

                                <table class="table">
                                    <thead>
                                        <th>#</th>
                                        <th>Nome</th>
                                        <th>Data Início</th>
                                        <th>Data Fim</th>
                                        <th>Ações</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($lote->proprietarios()->get() as $proprietario)
                                            <tr>
                                                <td>{{ $proprietario->id }}</td>
                                                <td>{{ $proprietario->nome }}</td>
                                                <td>{{ date('H:i:s d/m/Y', strtotime($proprietario->data_inicio)) }}</td>
                                                <td>{{ date('H:i:s d/m/Y', strtotime($proprietario->data_fim)) }}</td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ route('proprietario.show', ['proprietario' => $proprietario]) }}">
                                                        <i class="fas fa-eye">
                                                        </i>
                                                    </a>
                                                    <a class="btn btn-danger btn-sm" href="{{ route('proprietario.remove', ['proprietario' => $proprietario]) }}">
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
@endsection
