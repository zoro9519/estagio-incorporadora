@extends("templates.admin")

@section('content')
<section class="content p-2">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data" action="{{route("admin.imobiliarias.update", ['imobiliaria' => $imobiliaria->id])}}">
                        @csrf
                        <div class="row">
                            @if(session('return'))
                            <div class="col-12">
                                <div class="alert alert-{{session('return')['success'] ? 'success' : 'warning'}}">
                                    {{ session('return')['message'] }}
                                </div>
                            </div>
                            @endif

                            <div class="col-12">
                                <h4 class="">Dados da Imobiliária</h4>
                                <div class="row">

                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="nome">Nome: *</label>
                                            <input type="text" class="form-control" id="nome" name="nome" value="{{$imobiliaria->nome}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="razao_social">Razão Social: *</label>
                                            <input type="text" class="form-control" id="razao_social" name="razao_social" value="{{$imobiliaria->razao_social}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="cnpj">CNPJ: *</label>
                                            <input type="text" class="cnpj form-control" id="cnpj" name="cnpj" value="{{$imobiliaria->cnpj}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="creci">CRECI: *</label>
                                            <input type="text" class="creci form-control" id="creci" name="creci" value="{{$imobiliaria->creci}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="phone">Celular: *</label>
                                            <input type="text" id="phone" name='phone' class="phone form-control" value="{{$imobiliaria->phone}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="email">Email: *</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{$imobiliaria->email}}" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Criada em:</label>
                                            <input type="text" class="form-control" disabled value='{{ $imobiliaria->created_at ? date("d/m/Y H:i:s", strtotime($imobiliaria->created_at)) : ""}}'>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>

                            <div class="col-12 mt-2">
                                <h4 class="">Dados de Endereço</h4>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="cep">CEP: *</label>
                                            <input type="text" class="form-control" id="cep" name="cep" value="{{$imobiliaria->cep ?? ""}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="logradouro">Logradouro: *</label>
                                            <input type="text" class="form-control" id="logradouro" name="logradouro" value="{{$imobiliaria->logradouro}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-sm-12">
                                        <div class="form-group">
                                            <label for="numero">Número:</label>
                                            <input type="number" class="form-control" id="numero" name="numero" value="{{$imobiliaria->numero}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-sm-12">
                                        <div class="form-group">
                                            <label for="bairro">Bairro: *</label>
                                            <input type="text" id="bairro" name='bairro' class="bairro form-control" value="{{$imobiliaria->bairro}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-sm-12">
                                        <div class="form-group">
                                            <label for="complemento">Complemento:</label>
                                            <input type="text" class="form-control" id="complemento" name="complemento" value="{{$imobiliaria->complemento ?? ""}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-8 col-sm-9">
                                        <div class="form-group">
                                            <label for="cidade">Cidade: *</label>
                                            <input type="text" class="form-control" id="cidade" name="cidade" value="{{$imobiliaria->cidade ?? ""}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-3">
                                        <div class="form-group">
                                            <label for="uf">UF: *</label>
                                            <input type="text" class="form-control" id="uf" name="uf" value="{{$imobiliaria->uf ?? ""}}" required>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="col-12">
                                <a class="btn btn-info" href="{{route('admin.imobiliarias.show', [ 'imobiliaria' => $imobiliaria->id])}}">Voltar</a>
                                <button type="submit" class="btn btn-success">Salvar</button>
                            </div>

                        </div>
                    </form>
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