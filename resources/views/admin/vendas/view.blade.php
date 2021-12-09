@extends("templates.admin")

@section('content')
<section class="content p-2">

    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">

                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-6 order-2 order-md-1">

                            <h4 class="">Dados da Venda</h4>

                            <div class=" table">
                                <table class="">
                                    <tr>
                                        <td>Data:</td>
                                        <td>{{ date('d/m/Y H:i:s', strtotime($venda->created_at)) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Lote:</td>
                                        <td>
                                            <a href="{{route('admin.lotes.show', ['lote' => $venda->lote])}}">{{ "Loteamento {$venda->lote->quadra->loteamento->nome} / Quadra {$venda->lote->quadra->descricao} / Lote {$venda->lote->descricao}" }}
                                            </a>
                                            </td>
                                    </tr>
                                    <tr>
                                        <td>Comprador:</td>
                                        <td>
                                            <a href="{{route('admin.users.show', ['user' => $venda->comprador])}}">{{ "{$venda->comprador->nome} - {$venda->comprador->cpf}" }}
                                            </a>
                                            </td>
                                    </tr>
                                    <tr>
                                        <td>Vendedor:</td>
                                        <td>
                                            <a href="{{route('admin.corretores.show', ['corretor' => $venda->corretor])}}">{{ "{$venda->corretor->nome} - {$venda->corretor->cpf}" }}
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="col-12 col-md-12 col-lg-6 order-1 order-md-2">
                            <h4 class="">Dados Financeiros</h4>
                            <div class="table">
                                <table class="">
                                    <tr>
                                        <td>Valor:</td>
                                        <td>{{ numberToMoney($venda->valor) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Forma de Pagamento:</td>
                                        <td>{{ $formas_pagamento[$venda->forma_pagamento] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nº de Parcelas</td>
                                        <td>{{ $venda->nro_parcelas }}x</td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
