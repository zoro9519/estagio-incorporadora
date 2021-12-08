@extends("templates.admin")

@section('content')
<section class="content p-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-8">
                                <h4>Imobiliárias</h4>
                            </div>
                            <div class="col-4 text-right">
                                <a class="btn btn-primary" href="#" data-toggle="modal"
                                    data-target="#modal-add-imobiliaria">
                                    <i class="fas fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Add Imobiliaria --}}
                    <div class="modal fade" id="modal-add-imobiliaria" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <form method="POST" action="{{route("admin.imobiliarias.store")}}">
                                    @csrf
                                    <div class="modal-header">
                                        <h4 class="modal-title">Adicionar Imobiliária</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">

                                            <div class="col-12">
                                                <h3>Informações de identificação</h3>
                                            </div>
                                            <div class="col col-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>Nome:</label>
                                                    <input type="text" required name="nome"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col col-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>Razão Social:</label>
                                                    <input type="text" required name="razao_social"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col col-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>CRECI:</label>
                                                    <input type="text" required name="creci"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col col-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>CNPJ:</label>
                                                    <input type="text" required name="cnpj"
                                                        class="form-control cnpj">
                                                </div>
                                            </div>
                                            <div class="col col-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>Email:</label>
                                                    <input type="email" required name="email"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col col-6 col-xs-12">
                                                <div class="form-group">
                                                    <label>Celular:</label>
                                                    <input type="text" required name="phone"
                                                        class="form-control phone">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col col-12">
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
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="submit" class="btn btn-primary">Criar Imobiliária</button>
                                    </div>
                                </form>
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
                                    <th style="width: 10%">
                                        CRECI
                                    </th>
                                    <th style="width: 20%">
                                        CNPJ
                                    </th>
                                    <th style="width: 5%" class="">
                                        Corretores Vinculados
                                    </th>

                                    <th style="width: 40%" class="text-center">
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
                                        <div class="btn-group">

                                            <a class="btn btn-{{$imobiliaria->status ? 'warning' : 'success'}} btn-sm"
                                                href="{{ route("admin.imobiliarias.toggle-status", ['imobiliaria' => $imobiliaria]) }}">
                                                <i class="fas fa-{{$imobiliaria->status ? "times" : 'check'}}"></i>
                                                {{$imobiliaria->status ? "Desativar" : "Ativar"}}
                                            </a>
                                            <a class="btn btn-primary btn-sm"
                                            href="{{ route("admin.imobiliarias.show", ['imobiliaria' => $imobiliaria]) }}">
                                                <i class="fas fa-eye">
                                                </i>
                                                Ver
                                            </a>
                                            <a class="btn btn-info btn-sm" href="{{route('admin.imobiliarias.edit', [ 'imobiliaria' => $imobiliaria->id])}}">
                                                <i class="fas fa-pencil-alt">
                                                </i>
                                                Editar
                                            </a>
                                            <a class="btn btn-danger btn-sm"
                                                href="{{ route("admin.imobiliarias.delete", ['imobiliaria' => $imobiliaria]) }}">
                                                <i class="fas fa-trash">
                                                </i>
                                                Remover
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

</section>
@endsection