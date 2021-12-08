@extends("templates.admin")

@section('css')
    <link rel="stylesheet" href="{{ url('template/assets/fullcalendar/main.css') }}">
@endsection

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row p-2">

                @if(session('return'))
                <div class="col-12">
                    <div class="alert alert-{{session('return')['success'] ? 'success' : 'warning'}}">
                        {{ session('return')['message'] }}
                    </div>
                </div>
                @endif
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
                                                <option value="{{Agendamento::STATUS_EMESPERA}}"
                                                    {{ Request::get('filterStatus') == Agendamento::STATUS_EMESPERA ? 'selected' : '' }}>Aguardando
                                                    Aprovação</option>
                                                <option value="{{Agendamento::STATUS_AGENDADO}}"
                                                    {{ Request::get('filterStatus') == Agendamento::STATUS_AGENDADO ? 'selected' : '' }}>Agendado
                                                </option>
                                                <option value="{{Agendamento::STATUS_NEGADO}}"
                                                    {{ Request::get('filterStatus') == Agendamento::STATUS_NEGADO ? 'selected' : '' }}>Recusado
                                                </option>
                                                <option value="{{Agendamento::STATUS_REALIZADO}}"
                                                    {{ Request::get('filterStatus') == Agendamento::STATUS_REALIZADO ? 'selected' : '' }}>Finalizado
                                                </option>
                                                <option value="{{Agendamento::STATUS_CANCELADO}}"
                                                    {{ Request::get('filterStatus') == Agendamento::STATUS_CANCELADO ? 'selected' : '' }}>
                                                    Cancelado</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Tipo do Agendamento</label>
                                            <select name="filterType" class="form-control">
                                                <option value="">Todos</option>
                                                <option value="{{Agendamento::TYPE_VISITA}}"
                                                    {{ Request::get('filterType') == Agendamento::TYPE_VISITA ? 'selected' : '' }}>Visita
                                                </option>
                                                <option value="{{Agendamento::TYPE_RESERVA}}"
                                                    {{ Request::get('filterType') == Agendamento::TYPE_RESERVA ? 'selected' : '' }}>Reserva
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

        
        <div class="modal fade" id="modal-editar-agendamento" style="display: none;" aria-hidden="true">
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
                                <label>Solicitante:</label>
                                <a href="" id="requester" class=""></a>
                            </div>

                            <div class="form-group">
                                <label>Loteamento:</label>
                                <a href="" id="loteamento" class=""></a>
                            </div>

                            <div class="form-group" id="item-lote">
                                <label>Lote:</label>
                                <a href="" id="lote" class=""></a>
                            </div>
                            
                            <div class="form-group" id="item-status">
                                <label>Status:</label>
                                <select id="status" name="status" required class="form-control">
                                    <option value="">Selecione</option>
                                    <option value="{{Agendamento::STATUS_EMESPERA}}">Em Espera</option>
                                    <option value="{{Agendamento::STATUS_AGENDADO}}">Agendado</option>
                                    <option value="{{Agendamento::STATUS_NEGADO}}">Recusar</option>
                                    <option value="{{Agendamento::STATUS_REALIZADO}}">Realizado</option>
                                </select>
                            </div>

                            <div class="form-group" id="item-corretor">
                                <label>Corretor:</label>
                                <select id="corretor" name="corretor" required class="form-control">
                                    <option value="">Selecione</option>
                                    @foreach ($corretores as $corretor)
                                    <option value="{{ $corretor->id }}">{{ ($corretor->imobiliaria ? "{$corretor->imobiliaria->nome} - " : "") . "$corretor->nome - $corretor->phone" }}</option>
                                    @endforeach
                                </select>
                                <a id="corretor-static"></a>
                            </div>
                            
                            <div id="item-dates">
                                <div class="form-group">
                                    <label>Data inicial:</label>
                                    <span id="start" class=""></span>
                                </div>
                                <div class="form-group">
                                    <label>Data final:</label>
                                    <span id="end" class=""></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-right">
                            <button type="submit" id="salvarAgendamento" class="btn btn-primary">Enviar</button>
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
        const colors = JSON.parse('<?= json_encode(Agendamento::colorsAdmin); ?>');
        colors.Z = "#000";

        const label_colors = {
            "A": "Agendado",
            "E": "Aguardando Aprovação",
            "N": "Recusado",
            "C": "Cancelado",
            "R": "Finalizado",
            "Z": "Outros"
        };

        const TYPE_RESERVATION = '{{ Agendamento::TYPE_RESERVA}}';
        const TYPE_VISIT = '{{ Agendamento::TYPE_VISITA}}';

        const STATUS_AGENDADO = '{{Agendamento::STATUS_AGENDADO}}';
        const STATUS_CANCELADO = '{{Agendamento::STATUS_CANCELADO}}';
        const STATUS_EMESPERA = '{{Agendamento::STATUS_EMESPERA}}';
        const STATUS_NEGADO = '{{Agendamento::STATUS_NEGADO}}';
        const STATUS_REALIZADO = '{{Agendamento::STATUS_REALIZADO}}';

        let legendaGrid = $("#legenda_grid");
        Object.entries(colors).forEach((item) => {
            // console.log(item);
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
                title : '{{ $agendamento->loteamento->nome . (isset($agendamento->lote) ? " - Lote {$agendamento->lote->id}" :  "")}}',
                start : Date.parse("{{ $agendamento->data_inicio }}"),
                end : Date.parse("{{ $agendamento->data_fim }}"),
                backgroundColor: colors['{{ $agendamento->status }}'],
                borderColor : colors['{{ $agendamento->status }}'],
                allDay: {{ $agendamento->type == 'R' ? 'true' : 'false' }},
            
                // Valores distintos do evento
                extendedProps: {
                    status: '{{ $agendamento->status }}',
                    lote_id: '{{ $agendamento->lote ? $agendamento->lote->id : 0 }}',

                    loteamento_id: '{{ $agendamento->loteamento ? $agendamento->loteamento->id : 0 }}',
                    loteamento_name: '{{ $agendamento->loteamento ? $agendamento->loteamento->nome : "" }}',
                    
                    corretor_id: '{{ $agendamento->corretor ? $agendamento->corretor->id : 0 }}',
                    corretor_name: '{{ $agendamento->corretor ? $agendamento->corretor->nome : "" }}',
                    
                    user_id: '{{ $agendamento->user_id ?? 0}}',
                    user_name: '{{ $agendamento->cliente ? $agendamento->cliente->nome : "" }}',
                    type: '{{ $agendamento->type }}' // Tipo: reserva ou visita
                    
                }
            }
            console.log(ev);
            eventosGrid.push(ev);
        
        @endforeach

        var calendarEl = document.getElementById('calendar');

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
                
                switch(ev.extendedProps.type)
                {
                    case TYPE_RESERVATION:
                        $("#modal-editar-agendamento #item-dates").show();
                        $('#modal-editar-agendamento #start').show();
                        $('#modal-editar-agendamento #end').show();

                        if(ev.extendedProps.corretor_id > 0){
                            $('#modal-editar-agendamento #corretor').hide();
                            $('#modal-editar-agendamento #corretor-static').show();

                            $('#modal-editar-agendamento #corretor-static').html(ev.extendedProps.corretor_name);
                            $('#modal-editar-agendamento #corretor-static').attr('href', './corretores/' + ev.extendedProps.corretor_id);
                        }
                        
                        $('#modal-editar-agendamento #start').html(dbDateToBRL(ev.startStr));
                        $('#modal-editar-agendamento #end').html(dbDateToBRL(ev.endStr));

                        
                        $("#modal-editar-agendamento #item-status").hide();
                        $('#modal-editar-agendamento .modal-footer').hide();
                        
                        break;
                        
                        case TYPE_VISIT:
                        $('#modal-editar-agendamento #corretor-static').hide();
                        $('#modal-editar-agendamento #corretor').show();
                        $('#modal-editar-agendamento #corretor').val(ev.extendedProps.corretor_id);

                        $("#modal-editar-agendamento #item-dates").hide();
                        $('#modal-editar-agendamento #start').html('');
                        $('#modal-editar-agendamento #end').html('');

                        $("#modal-editar-agendamento #item-status").show();
                        $('#modal-editar-agendamento #start').hide();
                        $('#modal-editar-agendamento #end').hide();

                        $('#modal-editar-agendamento .modal-footer').show();
                        break;

                }

                switch(ev.extendedProps.status)
                {
                    case STATUS_AGENDADO:
                        $('#modal-editar-agendamento #corretor').attr('disabled', 'disabled');
                        
                        break;
                    case STATUS_EMESPERA:
                        $('#modal-editar-agendamento #corretor').attr('disabled', '');
                    break;

                }

                // let modal_agendamento = $("#modal-editar-agendamento");
                $('#modal-editar-agendamento #id').html(`Agendamento ${ev.id}`);
                $('#modal-editar-agendamento #status').val(ev.extendedProps.status);


                $('#modal-editar-agendamento #link-to-lote').html(
                    `<a href="./lotes/${ev.extendedProps.lote_id}">Ir para Lote</a>`);

                if(ev.extendedProps.user_id > 0){
                $('#modal-editar-agendamento #requester').html(ev.extendedProps.user_name);
                $('#modal-editar-agendamento #requester').attr('href', `./users/${ev.extendedProps.user_id}`);
                }
                $('#modal-editar-agendamento #loteamento').html(ev.extendedProps.loteamento_name);
                $('#modal-editar-agendamento #loteamento').attr('href', `./loteamentos/${ev.extendedProps.loteamento_id}`);

                if(ev.extendedProps.lote_id > 0)
                {
                    let loteText = "Lote " + ev.extendedProps.lote_id;
                    $('#modal-editar-agendamento #lote').html(loteText);
                    $('#modal-editar-agendamento #lote').attr('href', `./lotes/${ev.extendedProps.lote_id}`);
                    $('#modal-editar-agendamento #item-lote').show();
                } else {
                    $('#modal-editar-agendamento #lote').attr('href', '');
                    $('#modal-editar-agendamento #lote').html('');
                    $('#modal-editar-agendamento #item-lote').hide();
                }

                

                if(ev.extendedProps.corretor_id)
                    

                $("#formEditAgendamento").attr("action", "agendamentos/update/" + ev.id);

                // $('#modal-editar-agendamento #descricao').val(ev.descricao);
                $('#modal-editar-agendamento').modal('show');

                // return false;
            },

            editable: false,
            droppable: false,

        });

        calendar.render();
    </script>

    {{-- <script src="{{ url('template/assets/fullcalendar/main.js') }}"></script> --}}
@endsection
