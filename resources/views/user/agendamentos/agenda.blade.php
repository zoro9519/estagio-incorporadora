@extends("templates.user")

@section('page_title')Agenda
@endsection

@section('css')
    <link rel="stylesheet" href="{{ url('template/assets/fullcalendar/main.css') }}">
@endsection

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card m-2">
                        <div class="card-header p-3 m-2">
                            <div class="row">
                                <h3>Agendar visita em <b><a href="{{route("user.agendamentos.showMap", [ "loteamento" => $loteamento->id])}}">{{$loteamento->nome}}</a></b>
                                @if(isset($lote))
                                / {{ "Quadra {$lote->quadra->descricao} - Lote {$lote->descricao}" }}
                                @endif</h3>
                            </div>
                        </div>
                            @if(session('error_message'))
                            <div class="px-3">
                                <div class="alert alert-warning">
                                    {{session("error_message")}}
                                    
                                </div>
                            </div>
                            @endif
                        <div class="card-body p-3 m-2">
                            <div class="row">

                                <div class="col-lg-9 col-sm-12">
                                    <!-- THE CALENDAR -->
                                    <div id="calendar"></div>
                                </div>
                                <div class="col-lg-3 col-sm-12 p-3">
                                    <h2>Legenda</h2>
                                    <table>
                                        <p style="color: {{Agendamento::colorsUser[Agendamento::STATUS_REALIZADO]}}"><b>•</b> Realizado</p>
                                        <p style="color: {{Agendamento::colorsUser[Agendamento::STATUS_AGENDADO]}}">• Agendado</p>
                                        <p style="color: {{Agendamento::colorsUser[Agendamento::STATUS_EMESPERA]}}">• Solicitado</p>
                                        <p style="color: {{Agendamento::colorsUser[Agendamento::STATUS_NEGADO]}}">• Negado</p>
                                        <p style="color: {{Agendamento::colorsUser[Agendamento::STATUS_CANCELADO]}}">• Cancelado</p>
                                        <p style="color: {{Agendamento::colorsUser['_']}}">• Outros</p>
                                    </table>
                                    
                                </div>
                            </div>
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
                                <input type="date" name="data_selecionada" id="data_selecionada" readonly required class="date form-control">
                            </div>
                            <div class="form-group">
                                <label>Horário</label>
                                <div class="row">
                                    <div class="col-6">
                                        <select name="horario" class="form-control">
                                            @for ($i = 9; $i < 18; $i++)
                                            <option value="{{ sprintf("%02d", $i) }}">{{ sprintf("%02d", $i) }} </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <select name="minutos" class="form-control">
                                            @for ($i = 0; $i < 60; $i += 15)
                                            <option value="{{ sprintf("%02d", $i) }}">{{ sprintf("%02d", $i) }} </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
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

        var eventos = [];

        var eventosGrid = [];
        let ev = [];

        @foreach ($agendamentos as $agendamento)
        // console.log(JSON.parse('{{$agendamento}}'));
            ev = {
            title : ' {{ $agendamento->cliente->id == Auth::id() ? "Visita  - " . $agendamento->loteamento->nome . (isset($agendamento->lote) ? " - Lote {$agendamento->lote->id}" : "") : "Data reservada" }}',
            start : Date.parse("{{ $agendamento->data_inicio }}"),
            end : Date.parse("{{ $agendamento->data_fim }}"),
            backgroundColor:  coresAgendamentos["{{ $agendamento->type == 'R' || $agendamento->cliente->id != Auth::id() ? '_' : $agendamento->status }}"],
            borderColor : coresAgendamentos["{{ $agendamento->type == 'R' || $agendamento->cliente->id != Auth::id() ? '_' : $agendamento->status }}"],
            allDay: {{ $agendamento->type == 'R' ? "true" : "false" }},
        
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
            events: eventosGrid

                //   {
                //     title          : 'Visita Lote #4132',
                //     start          : new Date(y, m, d - 4, 12, 15),
                //     backgroundColor: aprovado, //yellow
                //     borderColor    : aprovado //yellow
                //   },
                //   {
                //     title          : 'Visita Lote #2432',
                //     start          : new Date(y, m, d, 10, 30),
                //     allDay         : false,
                //     backgroundColor: recusado, //Blue
                //     borderColor    : recusado //Blue
                //   },

                //   {
                //     title          : 'Visita Lote #412',
                //     start          : new Date(y, m, 28),
                //     backgroundColor: aprovado, //Primary (light-blue)
                //     borderColor    : aprovado //Primary (light-blue)
                //   }
                ,

            eventClick: function(event) {
                let ev = event.event;
                console.log(ev);
                // let modal_agendamento = $("#modal-add-agendamento");
                $('#modal-add-agendamento #id').html();
                
                // $('#modal-add-agendamento #start').val(ev.start.toISOString("DD-MM-YYYY HH:MM:SS"));
                // $('#modal-add-agendamento #end').val(ev.end.toISOString("DD-MM-YYYY HH:MM:SS"));


                $('#modal-add-agendamento #link-to-lote').html(
                    `<a href="./lotes/${ev.extendedProps.lote_id}">Ir para Lote</a>`);
                $('#modal-add-agendamento #link-to-loteamento').html(
                    `<a href="./loteamentos/${ev.extendedProps.loteamento_id}">Ir para Loteamento</a>`);
                $("#formEditAgendamento").attr("action", "agendamentos/update/" + ev.id);

                // $('#modal-add-agendamento #descricao').val(ev.descricao);
                $('#modal-add-agendamento').modal('show');

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
                    $(document).toast({
                        title: 'Erro',
                        body: 'Não é possível agendar nesse data'
                    })
                    alert('Não é possível agendar nesse data');
            } else if(moment.contains('fc-day-today') || moment.contains('fc-day-future')){

                // Valida e abre modal
                console.log(ev);
                // let modal_agendamento = $("#modal-add-agendamento");
                $('#modal-add-agendamento #id').html();
                // $('#modal-add-agendamento #start').val(ev.start.toISOString("DD-MM-YYYY HH:MM:SS"));
                // $('#modal-add-agendamento #end').val(ev.end.toISOString("DD-MM-YYYY HH:MM:SS"));

                $('#modal-add-agendamento #data_selecionada').val(date_selected);

                if(ev.extendedProps){
                    $('#modal-add-agendamento #link-to-lote').html(
                        `<a href="./lotes/${ev.extendedProps.lote_id}">Ir para Lote</a>`);
                    $('#modal-add-agendamento #link-to-loteamento').html(
                    `<a href="./loteamentos/${ev.extendedProps.loteamento_id}">Ir para Loteamento</a>`);
                }
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
