@extends("templates.admin")

@section('content')
<section class="content p-2">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data" action="{{route("admin.corretores.update", ['corretor' => $corretor->id])}}">
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
                                <h4 class="">Dados do Corretor</h4>
                                <div class="row">

                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="nome">Nome: *</label>
                                            <input type="text" class="form-control" id="nome" name="nome" value="{{$corretor->nome}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="cpf">CPF: *</label>
                                            <input type="text" class="cpf form-control" id="cpf" name="cpf" value="{{$corretor->cpf}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="phone">Celular: *</label>
                                            <input type="text" id="phone" name='phone' class="phone form-control" value="{{$corretor->phone}}" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="email">Email: *</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{$corretor->email}}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="profile">Foto de perfil: </label>
                                            <input type="file" class="form-control" id="profile" name="profile">
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="">Criado em:</label>
                                            <input type="text" class="form-control" disabled value='{{ $corretor->created_at ? date("d/m/Y H:i:s", strtotime($corretor->created_at)) : ""}}'>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="col-12 mt-2">
                                <h4 class="">Taxas de Venda</h4>
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="taxa_percent">Taxa em porcentagem (%): *</label>
                                            <input type="number" class="form-control" id="taxa_percent" name="taxa_percent" value="{{$corretor->taxa_venda_porcentagem ?? ""}}" min=0 max=100 step=0.01>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="taxa_venda_valor">Taxa Valor (R$): *</label>
                                            <input type="text" class="form-control money" id="taxa_venda_valor" name="taxa_valor" value="{{ numberToMoney($corretor->taxa_venda_valor)}}">
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        
                            <div class="col-12">
                                <a class="btn btn-info" href="{{route('admin.corretores.show', [ 'corretor' => $corretor->id])}}">Voltar</a>
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