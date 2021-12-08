@extends("templates.admin")

@section('content')
    <section class="content p-2">

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        @if(session("error"))
                        <div class="alert alert-danger">{{session("error")}} - 9999</div>
                        @endif
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">

                                <h4 class="">Dados da Imobiliária </h4>

                                <div class="table">
                                    <table class="">
                                        <tr>
                                            <td>Nome:</td>
                                            <td>{{ $imobiliaria->nome }}</td>
                                        </tr>
                                        <tr>
                                            <td>Razão Social:</td>
                                            <td>{{ $imobiliaria->razao_social }}</td>
                                        </tr>
                                        <tr>
                                            <td>CNPJ:</td>
                                            <td>{{$imobiliaria->cnpj}}</td>
                                        </tr>
                                        <tr>
                                            <td>CRECI:</td>
                                            <td>{{$imobiliaria->creci}}</td>
                                        </tr>
                                        <tr>
                                            <td>Email:</td>
                                            <td>{{$imobiliaria->email}}</td>
                                        </tr>
                                        <tr>
                                            <td>Celular:</td>
                                            <td>{{$imobiliaria->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>Status:</td>
                                            <td>{{$imobiliaria->status ? 'Ativa' : 'Inativa'}}</td>
                                        </tr>
                                        <tr>
                                            <td>Criada Em:</td>
                                            <td>{{ date('H:i:s d/m/Y', strtotime($imobiliaria->created_at)) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <a href="{{route('admin.imobiliarias.edit', [ 'imobiliaria' => $imobiliaria->id])}}" class="btn btn-info btn-block">Editar</a>
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                                <div class="text-center mt-4">
                                    {{-- <a href="#" class="btn btn-sm btn-primary">Add files</a>
                                    <a href="#" class="btn btn-sm btn-warning">Report contact</a> --}}
                                </div>

                            </div>
                            <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">

                                <h4 class="">Dados de localização</h4>

                                <div class="table">
                                    <table class="">
                                        <tr>
                                            <td>Endereço:</td>
                                            <td>
                                                {{ $imobiliaria->logradouro 
                                                    . (!empty($imobiliaria->numero) ? ", $imobiliaria->numero" : "")
                                                    . (!empty($imobiliaria->complemento) ? " - $imobiliaria->complemento" : "")
                                                }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Bairro:</td>
                                            <td>{{ $imobiliaria->bairro }}</td>
                                        </tr>
                                        <tr>
                                            <td>Cidade/UF:</td>
                                            <td>{{ "$imobiliaria->cidade/$imobiliaria->uf"  }}</td>
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
                                    <a class="d-block " data-toggle="collapse" href="#corretor" aria-expanded="true">
                                        <h4 class=""> Corretores</h4>
                                    </a>
                                </h4>
                            </div>
                            <div class="col col-4 text-right">
                                <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal-add-corretor">
                                    <i class="fas fa-plus">
                                    </i>
                                </a>
                            </div>
                        </div>

                        {{-- Modal Add Corretor --}}
                        <div class="modal fade" id="modal-add-corretor" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                  <form method="POST" enctype="multipart/form-data" action="{{route("admin.corretores.store")}}">
                                    @csrf
                                    <input type="hidden" name="imobiliaria_id" value="{{ $imobiliaria->id }}">
                                    <div class="modal-header">
                                    <h4 class="modal-title">Adicionar Corretor</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                    
                                        <div class="form-group">
                                            <label>Nome:</label>
                                            <input type="text" name="nome" class="form-control" value="{{session("nome")}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Documento:</label>
                                            <input type="text" name="cpf" class="form-control cpf"  value="{{session("cpf")}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Celular:</label>
                                            <input type="text" name="celular" class="form-control phone" value="{{session("celular")}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Email:</label>
                                            <input type="text" name="email" class="form-control" value="{{session("email")}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Taxa em % para vendas:</label>
                                            <input type="number" class="form-control" name="taxa_venda_porcentagem" min=0 max=100 step=0.01 value="{{session("taxa_venda_porcentagem")}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Taxa em R$ para vendas:</label>
                                            <input type="text" name="taxa_venda_valor" id="taxa_venda_valor" class="form-control money" value="{{session("taxa_venda_valor")}}">
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
                        <div id="corretor" class="collapse show w-100" data-parent="#lista_exibe" style="">
                            <div class="card-body">

                                <table class="table">
                                    <thead>
                                        <th>#</th>
                                        <th>Nome</th>
                                        <th>Documento</th>
                                        <th>Celular</th>
                                        <th>Nº de Vendas</th>
                                        <th>Ações</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($imobiliaria->corretores()->get() as $corretor)
                                            <tr>
                                                <td>{{ $corretor->id }}</td>
                                                <td>{{ $corretor->nome }}</td>
                                                <td>{{ $corretor->cpf }}</td>
                                                <td>{{ $corretor->phone }}</td>
                                                <td>{{ $corretor->vendas()->count() }}</td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ route('admin.corretores.show', ['corretor' => $corretor]) }}">
                                                        <i class="fas fa-eye">
                                                        </i>
                                                    </a>
                                                    {{-- <a class="btn btn-info btn-sm" href="#">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                        Edit
                                                    </a> --}}
                                                    <a class="btn btn-danger btn-sm" href="{{ route("admin.corretores.delete", [ 'corretor' => $corretor]) }}">
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
@section('js')
<script>
    $('form').on('submit', function(e) {
        let v = $("#taxa_venda_valor");
        let val = $(v).maskMoney('unmasked')[0];
        $(v).val(val);
    })
</script>
@endsection
