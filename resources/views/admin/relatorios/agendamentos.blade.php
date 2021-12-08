@extends("templates.admin")

@section('content')
    <section class="content p-2">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col col-8">
                        <h4 class="">Relatório - Agendamentos</h4>
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
                        <th style="width: 15%">
                            Lote
                        </th>
                        <th style="width: 20%">
                            Status
                        </th>
                        <th style="width: 20%" class="">
                            Corretor
                        </th>
                        <th style="width: 20%">
                            Solicitante
                        </th>
                        <th style="width: 15%" class="text-center">
                            Data
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($agendamentos as $agendamento)

                        <tr id="r-{{ $agendamento->id }}">
                            <td>
                                {{ $agendamento->loteamento->nome }}
                            </td>
                            <td>
                                @if($agendamento->lote)
                                {{ 
                                // "{$agendamento->lote->quadra->descricao} / " . 
                                $agendamento->lote->descricao }}
                                @else
                                -
                                @endif
                            </td>
                            <td>
                                {{ $agendamento_status[$agendamento->status] }}
                            </td>
                            <td class="">
                                @if($agendamento->corretor)
                                {{ 
                                // (!empty($agendamento->corretor->imobiliaria) ? $agendamento->corretor->imobiliaria->nome . " / " : "") . 
                                $agendamento->corretor->nome }}
                                @else
                                -
                                @endif
                            </td>
                            <td class="">
                                {{ $agendamento->cliente->nome }}
                            </td>
                            <td class="text-center">
                                {{ date("d/m/Y H:i:s", strtotime($agendamento->data_inicio)) }}                                
                            </td>
                            <td class="project-actions text-center">
                                
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
