@extends("templates.admin")

@section('content')
    <section class="content">

        <div class="row">
            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">

                <h4 class="p-2 mt-5">Dados da Quadra</h4>

                <div class="table">
                    <table class="">
                        <tr>
                            <td>Descrição:</td>
                            <td>{{ $quadra->descricao }}</td>
                        </tr>
                        <tr>
                            <td>Criado Em:</td>
                            <td>{{ date('H:i:s d/m/Y', strtotime($quadra->created_at)) }}</td>
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
                                    <a class="d-block " data-toggle="collapse" href="#lotes" aria-expanded="true">
                                        <h4 class=""> Lotes</h4>
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
                                  <form method="POST" action="{{route("lote.store")}}">
                                    @csrf
                                    <input type="hidden" name="quadra_id" value="{{ $quadra->id }}">
                                    <div class="modal-header">
                                    <h4 class="modal-title">Adicionar Lote</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                    
                                        <div class="form-group">
                                            <label>Descrição:</label>
                                            <input type="text" name="descricao">
                                        </div>
                                        <div class="form-group">
                                            <label>Área:</label>
                                            <input type="text" name="area" class="">
                                        </div>
                                        <div class="form-group">
                                            <label>Valor:</label>
                                            <input type="text" name="valor" class="money">
                                        </div>

                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-primary">Criar Lote</button>
                                    </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        <div id="lotes" class="collapse show w-100" data-parent="#lista_exibe" style="">
                            <div class="card-body">

                                <table class="table">
                                    <thead>
                                        <th>#</th>
                                        <th>Descrição</th>
                                        <th>Valor</th>
                                        <th>Criado em</th>
                                        {{-- <th>Nº de Lotes</th> --}}
                                        <th>Ações</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($quadra->lotes()->get() as $lote)
                                            <tr>
                                                <td>{{ $lote->id }}</td>
                                                <td>{{ $lote->descricao }}</td>
                                                <td>{{ $lote->valor }}</td>
                                                <td>{{ date('H:i:s d/m/Y', strtotime($lote->created_at)) }}</td>
                                                {{-- <td>{{ $lote->count() }}</td> --}}
                                                <td>
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ route('lote.show', ['lote' => $lote]) }}">
                                                        <i class="fas fa-eye">
                                                        </i>
                                                    </a>
                                                    <a class="btn btn-danger btn-sm" href="#">
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
