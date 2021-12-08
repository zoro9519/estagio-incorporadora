@extends("templates.admin")

@section('content')
<section class="content">

    <!-- Default box -->
    <div class="row p-2">
        <div class="col-12">


            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h4>Corretores</h4>
                        </div>
                        <div class="col col-4 text-right">
                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal-add-corretor">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Modal Add Corretor --}}
                    <div class="modal fade" id="modal-add-corretor" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" enctype="multipart/form-data" action="{{route("admin.corretores.store")}}">
                                    @csrf

                                    <div class="modal-header">
                                        <h4 class="modal-title">Adicionar Corretor</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label>Nome:</label>
                                            <input type="text" name="nome" class="form-control" value="{{session("
                                                nome")}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>CPF:</label>
                                            <input type="text" name="cpf" class="form-control cpf" value="{{session("
                                                cpf")}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Celular:</label>
                                            <input type="text" name="celular" class="form-control phone"
                                                value="{{session(" celular")}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input type="email" name="email" class="form-control" value="{{session("
                                                email")}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Taxa em % para vendas:</label>
                                            <input type="number" class="form-control" name="taxa_venda_porcentagem"
                                                min=0 max=100 step=0.01 value="{{session(" taxa_venda_porcentagem")}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Taxa em R$ para vendas:</label>
                                            <input type="text" name="taxa_venda_valor" class="form-control money"
                                                value="{{session(" taxa_venda_valor")}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Foto de Perfil:</label>
                                            <input type="file" name="profile_picture" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer text-right">
                                        <button type="submit" class="btn btn-primary">Criar Corretor</button>
                                    </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                            <tr>
                                <th style="width: 25%">
                                    Nome
                                </th>
                                <th style="width: 20%">
                                    Documento
                                </th>
                                <th style="width: 20%">
                                    Celular
                                </th>
                                <th style="width: 20%">
                                    Nº de Vendas
                                </th>
                                <th style="width: 20%" class="text-center">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($corretores as $corretor)
                            <tr id="r-{{ $corretor->id }}">
                                <td>
                                    <a>{{ $corretor->nome }}</a>
                                    <br />
                                    <small>
                                        Criado em: {{ date('d/m/Y', strtotime($corretor->created_at)) }}
                                    </small>
                                </td>
                                <td>{{ $corretor->cpf }}</td>
                                <td>{{ $corretor->phone }}</td>
                                <td><span class="badge alert-info">
                                    {{ $corretor->vendas()->count() }}
                                </span>
                            </td>

                                <td class="project-actions text-right">
                                    <div class="btn-group">

                                        <a class="btn btn-primary btn-sm"
                                        href="{{ route('admin.corretores.show', ['corretor' => $corretor]) }}">
                                        <i class="fas fa-eye">
                                        </i>
                                        Ver
                                    </a>
                                    <a class="btn btn-info btn-sm" href="{{route("admin.corretores.edit",
                                        [ 'corretor'=> $corretor->id])}}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Editar
                                    </a>
                                    <a class="btn btn-danger btn-sm"
                                    href="{{ route('admin.corretores.delete', ['corretor' => $corretor]) }}">
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

@section('js')

@endsection