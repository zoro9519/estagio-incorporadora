@extends("templates.user")

@section('css')
    <link rel="stylesheet" href="{{ url('template/assets/fullcalendar/main.css') }}">
@endsection

@section('content')

    <section class="content">
        <div class="container-fluid">
            {{-- <div class="row">
                <div class="col-12">
                    Filtros
                </div>
                <div class="col-12">
                    <form>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Status do Agendamento</label>
                                    <select name="filterStatus">
                                        <option value="">Todos</option>
                                        <option value="A" {{ Request::get("filterStatus") == 'A' ? "selected" : "" }}>Aguardando Aprovação</option>
                                        <option value="C" {{ Request::get("filterStatus") == 'C' ? "selected" : "" }}>Confirmado</option>
                                        <option value="R" {{ Request::get("filterStatus") == 'R' ? "selected" : "" }}>Recusado</option>
                                        <option value="F" {{ Request::get("filterStatus") == 'F' ? "selected" : "" }}>Finalizado</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tipo do Agendamento</label>
                                    <select name="filterType">
                                        <option value="V" {{ Request::get("filterType") == 'V' ? "selected" : "" }}>Visita</option>
                                        <option value="R" {{ Request::get("filterType") == 'R' ? "selected" : "" }}>Reserva</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div> --}}
            <div class="row">
                <div class="col-12">
                    <div class="card m-2">
                        <div class="card-header p-3 m-2">
                            <div class="row">
                                <h3>Agendar visita em <b><a href="{{route("user.loteamentos.show", [ "loteamento" => $loteamento->id])}}">{{$loteamento->nome}}</a></b>
                                @if(isset($lote))
                                - Lote {{ $lote->quadra()->descricao . " - " . $lote->id }}
                                @endif</h3>
                            </div>
                        </div>
                            @if(session('error_message'))
                            <div class="form-group">
                                <div class="alert alert-warning">
                                    {{session("error_message")}}
                                    
                                </div>
                            </div>
                            @endif
                        <div class="card-body p-3 m-2">
                            <!-- THE CALENDAR -->
                            <div id="calendar"></div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->

        {{-- Modal Add Agendamento --}}
        <div class="modal fade" id="modal-add-agendamento" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('user.agendamentos.store') }}">
                        @csrf
                        <input type="hidden" name="loteamento_id" value="{{ $loteamento->id }}">
                        <input type="hidden" name="lote_id" value="{{$lote->id ?? 0 }}">
                        <div class="modal-header">
                            <h4 class="modal-title">Solicitar agendamento</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            
                            <div class="form-group">
                                <label>Data</label>
                                <input type="date" name="data_selecionada" id="data_selecionada" readonly required class="date">
                            </div>
                            <div class="form-group">
                                <label>Horário</label>
                                <select name="horario">
                                    @for ($i = 9; $i < 18; $i++)
                                        <option value="{{ sprintf("%02d", $i) }}">{{ sprintf("%02d", $i) }} </option>
                                    @endfor
                                </select>
                                <select name="minutos">
                                    @for ($i = 0; $i < 60; $i += 15)
                                        <option value="{{ sprintf("%02d", $i) }}">{{ sprintf("%02d", $i) }} </option>
                                    @endfor
                                </select>
                            </div>

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary">Agendar horário</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </section>


    {{-- @endsection --}}
@endsection

@section('js')
    <script src="{{ url('template/assets/fullcalendar/main.js') }}"></script>
    <script>
        const colors = {
            "A": "#f39c12",
            "N": "#65b473",
            "R": "#a54242",
            "E": "#a54242",
            "Z": "#000"
        };

        var eventos = [];

        var eventosGrid = [];
        let ev = [];

        @foreach ($agendamentos as $agendamento)
            ev = {
            title : 'Data reservada',
            start : Date.parse("{{ $agendamento->data_inicio }}"),
            end : Date.parse("{{ $agendamento->data_fim }}"),
            backgroundColor: colors['Z'],
            borderColor : colors['Z'],
        
            // Valores distintos do evento
            extendedProps: {
            // status: '{{ $agendamento->status }}',
            // lote_id: '{{ $agendamento->lote ? $agendamento->lote->id : 0 }}',
            loteamento_id: '{{ $agendamento->loteamento ? $agendamento->loteamento->id : 0 }}',
            type: "" // Tipo: reserva ou visita
            }
            }
            eventosGrid.push(ev);
        
        @endforeach

        var calendarEl = document.getElementById('calendar');

        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear();

        var Calendar = FullCalendar.Calendar;

        var calendar = new Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            themeSystem: 'bootstrap',
            events: eventosGrid,

            eventClick: function(event) {
                return false;
            },
            eventsSet: function() {
                // $(".fc-day-past, .fc-day-future, .fc-day-today").click(dayClicked);
            },

            editable: false,
            droppable: false,

        });

        calendar.render();

        function dayClicked(event) {
            console.log(event);
            let target = event.currentTarget;
            let moment = target.classList;
            let date_selected = $(target).data("date");
            if(moment.contains('fc-day-past')){
                    console.log("A");
                    $(document).toast({
                        title: 'Erro',
                        body: 'Não é possível agendar nesse data'
                    })
            } else if(moment.contains('fc-day-today') || moment.contains('fc-day-future')){

                // Valida e abre modal
                // let modal_agendamento = $("#modal-add-agendamento");
                $('#modal-add-agendamento #id').html();
                // $('#modal-add-agendamento #start').val(ev.start.toISOString("DD-MM-YYYY HH:MM:SS"));
                // $('#modal-add-agendamento #end').val(ev.end.toISOString("DD-MM-YYYY HH:MM:SS"));

                $('#modal-add-agendamento #data_selecionada').val(date_selected);

                $('#modal-add-agendamento #link-to-lote').html(
                    `<a href="./lotes/${ev.extendedProps.lote_id}">Ir para Lote</a>`);
                $('#modal-add-agendamento #link-to-loteamento').html(
                    `<a href="./loteamentos/${ev.extendedProps.loteamento_id}">Ir para Loteamento</a>`);
                $("#formEditAgendamento").attr("action", "agendamentos/update/" + ev.id);

                // $('#modal-add-agendamento #descricao').val(ev.descricao);
                $('#modal-add-agendamento').modal('show');
            }
        }

        $(document).ready(function() {
            $(".fc-day-past, .fc-day-future, .fc-day-today").click(dayClicked);
        })
    </script>
    {{-- <script src="{{ url('template/assets/fullcalendar/main.js') }}"></script> --}}
    {{-- <script src="{{ url('js/agendamentos/index.js') }}"></script> --}}
@endsection
