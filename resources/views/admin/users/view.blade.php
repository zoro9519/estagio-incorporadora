@extends("templates.admin")

@section('content')
<section class="content p-2">

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-6 order-2 order-md-1">

                            <h4 class="">Dados do Cliente</h4>

                            <div class=" table">
                                <table class="">
                                    <tr>
                                        <td>Nome:</td>
                                        <td>{{ $user->nome }}</td>
                                    </tr>
                                    <tr>
                                        <td>CPF:</td>
                                        <td>{{ $user->cpf }}</td>
                                    </tr>
                                    <tr>
                                        <td>Celular:</td>
                                        <td>{{ $user->phone }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email:</td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status:</td>
                                        <td>
                                            <p class="badge badge-info">{{ $user->status }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Criado Em:</td>
                                        <td>{{ date('H:i:s d/m/Y', strtotime($user->created_at)) }}</td>
                                    </tr>

                                </table>
                            </div>
                        </div>

                        <div class="col-12 col-md-12 col-lg-6 order-1 order-md-2">
                            <h4 class="">Dados de endereço</h4>
                            <div class="table">
                                <table class="">
                                    <tr>
                                        <td>Logradouro:</td>
                                        <td>{{ $user->logradouro }}</td>
                                    </tr>
                                    <tr>
                                        <td>Número:</td>
                                        <td>{{ $user->numero }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bairro:</td>
                                        <td>{{ $user->bairro }}</td>
                                    </tr>
                                    <tr>
                                        <td>Complemento:</td>
                                        <td>{{ $user->complemento }}</td>
                                    </tr>
                                    <tr>
                                        <td>Cidade</td>
                                        <td>{{ $user->cidade }}</td>
                                    </tr>
                                    <tr>
                                        <td>UF</td>
                                        <td>{{ $user->uf }}</td>
                                    </tr>
                                    <tr>
                                        <td>CEP</td>
                                        <td>{{ $user->cep }}</td>
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
                </div>
            </div>

        </div>
</section>
@endsection
