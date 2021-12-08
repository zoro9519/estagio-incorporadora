@extends("templates.admin")

@section('content')
    <section class="content p-2">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col col-8">
                        <h4 class="">Relatório - Lotes</h4>
                    </div>
                </div>
            </div>
        <div class="card-body overflow-auto">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th style="width: 15%">
                            Loteamento
                        </th>
                        <th style="width: 25%">
                            Quadra
                        </th>
                        <th style="width: 25%">
                            Lote
                        </th>
                        <th style="width: 10%">
                            Status
                        </th>
                        <th style="width: 20%" class="">
                            Valor
                        </th>
                        <th style="width: 10%">
                            Área
                        </th>
                        <th style="width: 25%" class="text-center">
                            Criado em
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lotes as $lote)

                        <tr id="r-{{ $lote->id }}">
                            <td>
                                {{ $lote->quadra->loteamento->nome }}
                            </td>
                            <td>
                                {{ "Quadra {$lote->quadra->descricao}" }}
                            </td>
                            <td>
                                {{ "Lote {$lote->descricao}" }}
                            </td>
                            <td>
                                {{ $lote_status[$lote->status] }}
                            </td>
                            <td class="">
                                {{ numberToMoney($lote->valor) }}
                            </td>
                            <td class="">
                                {{ $lote->area }} m2
                            </td>
                            <td class="text-center">
                                {{ date("d/m/Y H:i:s", strtotime($lote->created_at)) }}                                
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
