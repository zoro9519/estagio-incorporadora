@extends("templates.admin")

@section('css')
    <link rel="stylesheet" href="{{ url('template/assets/fullcalendar/main.css') }}">
@endsection

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row p-2">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Filtros</h4>
                        </div>
                        <div class="card-body">

                            <form>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Status do Agendamento</label>
                                            <select name="filterStatus" class="form-control">
                                                <option value="">Todos</option>
                                                <option value="E"
                                                    {{ Request::get('filterStatus') == 'E' ? 'selected' : '' }}>Aguardando
                                                    Aprovação</option>
                                                <option value="A"
                                                    {{ Request::get('filterStatus') == 'A' ? 'selected' : '' }}>Confirmado
                                                </option>
                                                <option value="N"
                                                    {{ Request::get('filterStatus') == 'N' ? 'selected' : '' }}>Recusado
                                                </option>
                                                <option value="R"
                                                    {{ Request::get('filterStatus') == 'R' ? 'selected' : '' }}>Finalizado
                                                </option>
                                                <option value="C"
                                                    {{ Request::get('filterStatus') == 'C' ? 'selected' : '' }}>
                                                    Desistência</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Tipo do Agendamento</label>
                                            <select name="filterType" class="form-control">
                                                <option value="">Todos</option>
                                                <option value="V"
                                                    {{ Request::get('filterType') == 'V' ? 'selected' : '' }}>Visita
                                                </option>
                                                <option value="R"
                                                    {{ Request::get('filterType') == 'R' ? 'selected' : '' }}>Reserva
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Loteamento</label>
                                            <select name="filterLoteamento" class="form-control">
                                                <option value=""> Todos </option>
                                                @foreach ($loteamentos as $loteamento)
                                                    <option value="{{ $loteamento->id }}"
                                                        {{ Request::get('filterLoteamento') == $loteamento->id ? 'selected' : '' }}>
                                                        {{ $loteamento->nome }}</option>

                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group text-right">
                                            <button type="submit" class="btn btn-primary">Filtrar</button>
                                            <a href="{{ route('admin.agendamentos.all') }}" type=""
                                                class="btn btn-warning">Limpar</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row p-2">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-body p-5">
                            <!-- THE CALENDAR -->
                            <div id="calendar"></div>
                            <div class="col">

                                <h2>Legenda</h2>
                                <table>
                                    <tbody id="legenda_grid">
                                    </tbody>
                                </table>
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

        
        <div class="modal fade " id="modal-editar-agendamento" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="POST" enctype="multipart/form-data" action="" id="formEditAgendamento">
                        @csrf
                        <div class="modal-header">
                            <h4 id="id" class="modal-title">Agendamento</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Status:</label>
                                <select id="status" name="status" required class="form-control">
                                    <option value="">Selecione</option>
                                    <option value="A">Confirmar Agendamento</option>
                                    <option value="C">Cancelar</option>
                                    <option value="N">Recusar</option>
                                    <option value="R">Realizado</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Corretor:</label>
                                <select id="corretor" name="corretor" required class="form-control">
                                    <option value="">Selecione</option>
                                    @foreach ($corretores as $corretor)
                                        <option value="{{ $corretor->id }}">{{ $corretor->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-4 card">
                                    <h4 id="link-to-lote"><a href=""></a></h4>
                                </div>
                                <div class="col-4 card">
                                    <h4 id="link-to-loteamento"><a href=""></a></h4>
                                </div>
                                <div class="col-4 card">
                                    <h4 id="link-to-user"><a href=""></a></h4>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" id="sendFile" class="btn btn-primary">Enviar</button>
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
            "A": "#65b473",
            "E": "#f39c12",
            "N": "#a54242",
            "C": "#a54242",
            "R": "#3c7ed0",
            "Z": "#000"
        };

        const label_colors = {
            "A": "Aprovado",
            "E": "Aguardando Aprovação",
            "N": "Recusado",
            "C": "Desistência",
            "R": "Finalizado",
            "Z": "Outros"
        };


        let legendaGrid = $("#legenda_grid");
        Object.entries(colors).forEach((item) => {
            console.log(item);
            let row = $("<tr/>");
            $(row).html(`<td><h6>${label_colors[item[0]]}</h6></td>
            <td>
                <div class="alert" style="background-color: ${item[1]} !important">
                </div>
            </td>`);
            $(legendaGrid).append(row);
        })

        var eventos = [];

        var eventosGrid = [];
        let ev = [];

        @foreach ($agendamentos as $agendamento)
            ev = {
            id: '{{ $agendamento->id }}',
            title : '{{ $agendamento->loteamento->nome }}',
            start : Date.parse("{{ $agendamento->data_inicio }}"),
            end : Date.parse("{{ $agendamento->data_fim }}"),
            backgroundColor: colors['{{ $agendamento->status ?? 'Z' }}'],
            borderColor : colors['{{ $agendamento->status ?? 'Z' }}'],
            allDay: {{ $agendamento->type == 'R' ? 'true' : 'false' }},
        
            // Valores distintos do evento
            extendedProps: {
            status: '{{ $agendamento->status }}',
            lote_id: '{{ $agendamento->lote ? $agendamento->lote->id : 0 }}',
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
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            themeSystem: 'bootstrap',
            events: eventosGrid,

            eventClick: function(event) {
                let ev = event.event;
                console.log(ev);
                // let modal_agendamento = $("#modal-editar-agendamento");
                $('#modal-editar-agendamento #id').html(`Agendamento ${ev.id}`);
                $('#modal-editar-agendamento #start').val(ev.start.toISOString("DD-MM-YYYY HH:MM:SS"));
                $('#modal-editar-agendamento #end').val(ev.end.toISOString("DD-MM-YYYY HH:MM:SS"));
                $('#modal-editar-agendamento #status').val(ev.extendedProps.status);


                $('#modal-editar-agendamento #link-to-lote').html(
                    `<a href="./lotes/${ev.extendedProps.lote_id}">Ir para Lote</a>`);
                $('#modal-editar-agendamento #link-to-loteamento').html(
                    `<a href="./loteamentos/${ev.extendedProps.loteamento_id}">Ir para Loteamento</a>`);
                $("#formEditAgendamento").attr("action", "agendamentos/update/" + ev.id);

                // $('#modal-editar-agendamento #descricao').val(ev.descricao);
                $('#modal-editar-agendamento').modal('show');

                return false;
            },

            editable: false,
            droppable: false,

        });

        calendar.render();
    </script>

    {{-- <script src="{{ url('template/assets/fullcalendar/main.js') }}"></script> --}}
@endsection
