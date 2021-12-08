@extends("templates.user")

@section('page_title')Agendamentos
@endsection

@section('content')
<?php $limit_date = date("Y-m-d H:i:s", strtotime("today + 2 day")); ?>

<div class="content p-2">
    <div class="row">
        <div class="col" id="">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col col-8">
                            <h4 class="card-title">
                                @if( session("error_message"))
                                <div class="alert alert-warning">{{session("error_message")}}</div>
                                @endif
                                <h4 class=""> Agendamentos</h4>
                            </h4>
                        </div>
                        <div class="col col-4 text-right">
                            {{-- <a class="btn btn-default btn-toggle-vision" href="{{route("user.agendamentos.showAgenda")}}" data-vision="agenda" >
                                <i class="fas fa-calendar-day"></i>
                            </a> --}}
                            {{-- <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal-add-agendamento">
                                <i class="fas fa-plus">
                                </i>
                            </a> --}}
                        </div>
                    </div>

                    <div id="lotes" class="collapse show w-100" data-parent="#lista_exibe" style="">
                        <div class="card-body">

                            <table class="table">
                                <thead>
                                    {{-- <th>#</th> --}}
                                    {{-- <th>Data de solicitação</th> --}}
                                    <th>Loteamento</th>
                                    <th>Lote</th>
                                    <th>Situação</th>
                                    <th>Data marcada</th>
                                    <th>Ações</th>
                                </thead>
                                <tbody>
                                    @foreach ($agendamentos as $agendamento)
                                    <tr>
                                        {{-- <td>{{ $agendamento->id }}</td> --}}
                                        {{-- <td>{{ date('d/m/Y H:i:s', strtotime($agendamento->created_at)) }}</td> --}}
                                        <td>
                                            @if($agendamento->loteamento)
                                            <a href="{{route("user.agendamentos.showAgenda", [ 'loteamento' => $agendamento->loteamento->id])}}"> 
                                                {{  $agendamento->loteamento->nome }}
                                            </a>
                                            @else 
                                            Não definido
                                            @endif
                                        </td>
                                        <td>
                                            @if($agendamento->lote)
                                            <a href="{{route("user.loteamentos.show", [ 'loteamento' => $agendamento->lote->id ])}}">{{$agendamento->lote->descricao }}
                                            </a>
                                            @else
                                            Não definido 
                                            @endif
                                        </td>
                                        <td>{{ $agendamento_status[$agendamento->status] }}</td>
                                        <td>{{ date("d/m/Y H:i", strtotime($agendamento->data_inicio)) }}</td>
                                        
                                        <td class="text-center">
                                            {{-- <a class="btn btn-primary btn-sm" href="{{ route('user.agendamento.show', ['agendamento' => $agendamento]) }}">
                                                <i class="fas fa-eye">
                                                </i>
                                            </a> --}}
                                            <a class="btn btn-primary btn-sm" href="#" data-toggle="modal"  data-target="#modal-info-{{$agendamento->id}}">
                                                <i class="fas fa-eye">
                                                </i>
                                            </a>
                                            @if(in_array($agendamento->status, ['A', 'E']) && $limit_date < $agendamento->data_inicio) 
                                            <a class="btn btn-warning btn-sm" href="{{ route('user.agendamentos.cancel', ['agendamento' => $agendamento]) }}">
                                                <i class="fas fa-times">
                                                </i>
                                            </a>
                                            @endif
                                            <div class="modal fade" id="modal-info-{{$agendamento->id}}" style="display: none;" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Visualizar Agendamento</h4>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            -- Dados do Agendamento --

                                                            <br>
                                                            <br>
                                                            <br>

                                                            Agendamento {{$agendamento->id}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- Modal Add Agendamento --}}
    <div class="modal fade" id="modal-add-agendamento" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('user.agendamentos.store') }}">
                    @csrf
                    <input type="hidden" name="loteamento_id" value="0">
                    <input type="hidden" name="lote_id" value="0">
                    <input type="hidden" name="data_selecionada" value="{{ date('Y-m-d') }}">
                    <div class="modal-header">
                        <h4 class="modal-title">Solicitar agendamento</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label>Loteamento:</label>
                            <select name="loteamento" class="">
                                @foreach ($loteamentos as $loteamento)
                                <option value="{{$loteamento->id}}">{{ $loteamento->nome }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Option para selecionar a quadra ou lote --}}
                        {{-- <div class="form-group">
                            <label>Quadra/Lote:</label>
                            <select name="loteamento" class="">
                                @foreach ($loteamentos as $loteamento)
                                <option value="{{$loteamento->id}}">{{ $loteamento->nome }}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="form-group">
                            <label>Data</label>
                            <input type="date" name="data_selecionada" class="date">
                        </div>
                        <div class="form-group">
                            <label>Horário</label>
                            <select name="horário">
                                @for ($i = 9; $i < 18; $i++)
                                    <option value="{{$i}}"> {{$i}} </option>
                                @endfor
                            </select>
                            <select name="minutos">
                                @for ($i = 0; $i < 60; $i += 15)
                                    <option value="{{$i}}"> {{$i}} </option>
                                @endfor
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">Criar Lote</button>
                    </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
    @endsection
