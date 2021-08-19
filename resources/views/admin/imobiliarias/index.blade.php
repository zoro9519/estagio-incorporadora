@extends("templates.admin")

@section('content')
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h3 class="card-title">Imobiliárias</h3>
                    </div>
                    <div class="col col-4 text-right">
                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal-add-imobiliaria">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Modal Add Imobiliaria --}}
                    <div class="modal fade" id="modal-add-imobiliaria" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                              <form method="POST" action="{{route("imobiliaria.store")}}">
                                @csrf
                                <div class="modal-header">
                                <h4 class="modal-title">Adicionar Imobiliária</h4>
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
                                        <label>Razão Social:</label>
                                        <input type="text" name="razao_social">
                                    </div>
                                    <div class="form-group">
                                        <label>CRECI:</label>
                                        <input type="text" name="creci">
                                    </div>
                                    <div class="form-group">
                                        <label>CNPJ:</label>
                                        <input type="text" name="cnpj">
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="submit" class="btn btn-primary">Criar Imobiliária</button>
                                </div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                    </div>
                </div>

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
                                CRECI
                            </th>
                            <th style="width: 20%">
                                CNPJ
                            </th>
                            <th style="width: 5%" class="">
                                Corretores Vinculados
                            </th>

                            <th style="width: 20%" class="text-center">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($imobiliarias as $imobiliaria)

                            <tr id="r-{{ $imobiliaria->id }}">
                                <td>
                                    {{ $imobiliaria->id }}
                                </td>
                                <td>
                                    <a>
                                        {{$imobiliaria->nome}}
                                    </a>
                                    <br />
                                    <small>
                                        Criado em: {{date("d/m/Y", strtotime($imobiliaria->created_at))}}
                                    </small>
                                </td>
                                <td>
                                    {{ $imobiliaria->creci }}
                                </td>
                                <td>
                                    {{ $imobiliaria->cnpj }}
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-primary">
                                        {{ $imobiliaria->corretores()->count()}}
                                    </span>
                                </td>
                                <td class="project-actions text-right">
                                    <a class="btn btn-primary btn-sm" href="{{ route("imobiliaria.show", ['imobiliaria' => $imobiliaria]) }}">
                                        <i class="fas fa-folder">
                                        </i>
                                        View
                                    </a>
                                    {{-- <a class="btn btn-info btn-sm" href="#">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a> --}}
                                    <a class="btn btn-danger btn-sm" href="#">
                                        <i class="fas fa-trash">
                                        </i>
                                        Delete
                                    </a>
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
