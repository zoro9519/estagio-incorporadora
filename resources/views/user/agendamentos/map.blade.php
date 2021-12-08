@extends("templates.user")

@section('page_title')Mapa
@endsection

@section('content')
<script>
    var LatLanding = {{ $loteamento->coordenada->latitude ?? env('GCP_DEFAULT_LAT') }};
        var LongLanding = {{ $loteamento->coordenada->longitude ?? env('GCP_DEFAULT_LONG') }};
        var ZoomLanding = {{ $loteamento->coordenada->zoom ?? env('GCP_DEFAULT_ZOOM') }};
        
        var lotes = [];
        
        let currentLote = false, loteCoord, loteCoords, q;

</script>
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
                    <div class="card-header p-3 m-2">
                        <div class="row">
                            <h3>
                                <b>
                                <a href="{{route('user.home')}}">Loteamentos</a> / 
                                <a href="{{route("landing.view", [ "loteamento"=>
                                        $loteamento->link])}}">{{$loteamento->nome}}</a></b>
                                @if(isset($lote))
                                / Lote {{ $lote->quadra->descricao . " - " . $lote->id }}
                                @endif</h3>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a class="btn btn-success" href="{{route("user.agendamentos.showAgenda",
                                    [ 'loteamento'=> $loteamento ])}}">Agendar no loteamento</a>
                            </div>
                        </div>
                    </div>
                    @if(session('error_message'))
                    <div class="form-group">
                        <div class="alert alert-warning">
                            {{session("error_message")}}

                        </div>
                    </div>
                    @endif
                    <div class="card-body py-2">
                        <div class="row">
                            {{-- Mapa do loteamento --}}
                            <div class="col-lg-8 col-sm-12 pb-3">
                                <h3>Mapa</h3>
                                <div class="row" style="height: 400px">
                                    <div class="col col-12">
                                        {{-- <div class="h-100 w-100"> --}}

                                            <div id="map" style="height:100%; width: 100%"></div>
                                            {{--
                                        </div> --}}
                                    </div>
                                </div>
                                {{-- Legendas --}}
                                <div class="row">
                                    <div class="col-12 pt-2">
                                    <h4>
                                        Legenda
                                    </h4>
                                    </div>
                                    <div class="col-6">
                                        <p style="color: {{Lote::colorsUser[Lote::STATUS_AVAILABLE]}} ">• Disponível</p>
                                    </div>
                                    <div class="col-6">
                                        <p style="color: {{Lote::colorsUser[Lote::STATUS_CANCELED]}}">• Indisponível</p>
                                    </div>
                                </div>
                            </div>


                            {{-- Lista de quadras / lotes do loteamento --}}
                            <div class="col-lg-4 col-sm-6 ">
                                <h3>Quadras / Lotes </h3>
                                <div class="table">
                                    <ul>
                                        @foreach ($loteamento->quadras as $quadra)
                                        {{-- @if(!empty($quadrasToShow->find($quadra))) --}}
                                        @if($quadra->lotes->count())
                                        <li>
                                            Quadra {{$quadra->descricao}}
                                            <ul>
                                                {{-- @endif --}}
                                                @foreach ($quadra->lotes as $lote)
                                                <script>
                                                    loteCoords = [];

                                                </script>
                                                    @foreach ($lote->coordenadas as $coord)
                                                    <script>
                                                        loteCoords.push({
                                                                lat: "{{$coord->latitude}}",
                                                                lng: "{{$coord->longitude}}"
                                                            });
                                                    </script>
                                                    @endforeach
                                                    <script>
                                                        currentLote = {
                                                                value: {{ $lote->valor ?? 0}},
                                                                status: '{{ $lote->status }}',
                                                                descricao: '{{ $lote->descricao }}',
                                                                url: '{{ route("user.agendamentos.showAgenda", [ 'loteamento' => $loteamento, 'lote' => $lote ])}}',
                                                                coords: loteCoords
                                                            }
                                                            lotes.push(currentLote);
                                                    </script>
                                                    
                                                <li>
                                                    <div class="row">
                                                        <div class="col-3">
                                                            @if($lote->disponivelParaUser())
                                                            <a
                                                            href="{{route('user.agendamentos.showAgenda', [ 'loteamento' => $loteamento, 'lote' => $lote ])}}">
                                                            {{"Lote $lote->descricao"}}</a>
                                                            @else
                                                            {{"Lote $lote->descricao"}}
                                                            @endif
                                                        </div>
                                                        <div class="col-9">
                                                            @switch($lote->status)
                                                            @case(Lote::STATUS_SOLD)
                                                                Vendido
                                                            @break
                                                            @default
                                                            {{numberToMoney($lote->valor)}}
                                                            @break
                                                            @endswitch
                                                        </div>
                                                    </div>

                                                </li>

                                                @endforeach
                                                {{-- @if(!empty($quadrasToShow->find($quadra))) --}}
                                            @if($quadra->lotes->count())
                                            </ul>
                                            @endif
                                        </li>
                                        @endif

                                            @endforeach
                                    </ul>
                                </div>
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
                            <input type="date" name="data_selecionada" id="data_selecionada" readonly required
                                class="date">
                        </div>
                        <div class="form-group">
                            <label>Horário</label>
                            <select name="horario">
                                @for ($i = 9; $i < 18; $i++) <option value="{{ sprintf(" %02d", $i) }}">{{
                                    sprintf("%02d", $i) }} </option>
                                    @endfor
                            </select>
                            <select name="minutos">
                                @for ($i = 0; $i < 60; $i +=15) <option value="{{ sprintf(" %02d", $i) }}">{{
                                    sprintf("%02d", $i) }} </option>
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
@endsection

@section('js')

<script src="{{ url('js/agendamentos/map.js') }}"></script>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GCP_MAPS_API', '') }}&callback=initMap&libraries=drawing">
</script>

@endsection