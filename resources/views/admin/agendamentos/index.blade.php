@extends("templates.admin")

@section('css')
    <link rel="stylesheet" href="{{ url('template/assets/fullcalendar/main.css') }}">
@endsection

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    Filtros
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Status do Agendamento</label>
                                <select name="filterStatus">
                                    <option>Todos</option>
                                    <option value="A">Aguardando Aprovação</option>
                                    <option value="C">Confirmado</option>
                                    <option value="R">Recusado</option>
                                    <option value="F">Finalizado</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-primary">Filtrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-body p-3">
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
    </section>
    <script src="{{ url('template/assets/fullcalendar/main.js') }}"></script>
    <script>
        // alert();
        const colors = {
            "A": "#f39c12",
            "F": "#65b473",
            "R": "#a54242",
            "Z": "#000"
        };

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
            events: [

                // @foreach ($agendamentos as $evento)
                
                    {
                    title : '{{ $evento->title }}',
                    start : Date.parse("{{ $evento->data }}"),
                    backgroundColor: colors['{{ $evento->status ?? 'Z' }}'],
                    borderColor : colors['{{ $evento->status ?? 'Z' }}'],
                    },
                // @endforeach
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
            ],

            eventClick: function(calEvent, jsEvent, view) {},

            editable: false,
            droppable: false,

        });

        calendar.render();
    </script>

    {{-- @endsection --}}
@endsection

@section('js')
    {{-- <script src="{{ url('template/assets/fullcalendar/main.js') }}"></script> --}}
    {{-- <script src="{{ url('js/agendamentos/index.js') }}"></script> --}}
@endsection
