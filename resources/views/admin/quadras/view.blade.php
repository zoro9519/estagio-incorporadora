@extends("templates.admin")

@section('content')

<script>
    var LatLanding = {{ $quadra->coordenadas()->first()->latitude ?? env('GCP_DEFAULT_LAT') }};
    var LongLanding = {{ $quadra->coordenadas()->first()->longitude ?? env('GCP_DEFAULT_LONG') }};
    var ZoomLanding = {{ $quadra->loteamento->coordenada->zoom ?? env('GCP_DEFAULT_ZOOM') }};
    var quadraCoords = [];

    var quadraLotes = [];
    let loteCoord, loteCoords, q;

    @foreach ($quadra->coordenadas()->get() as $coord)
        quadraCoord = {
            lat: "{{$coord->latitude}}",
            lng: "{{$coord->longitude}}",
        };
        quadraCoords.push(quadraCoord);
    
    @endforeach
</script>
<section class="content p-2">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @if(session('return'))
                            <div class="col-12">
                                <div class="alert alert-{{session('return')['success'] ? 'success' : 'warning'}}">
                                    {{ session('return')['message'] }}
                                </div>
                            </div>
                        @endif
                        <div class="col-12 col-md-12 col-lg-6 order-2 order-md-1">

                            <h4 class="">Dados da Quadra</h4>

                            <div class="table">
                                <table class="">
                                    <tr>
                                        <td>Descrição:</td>
                                        <td>{{ $quadra->descricao }}</td>
                                    </tr>
                                    <tr>
                                        <td>Loteamento:</td>
                                        <td><a href="{{route("admin.loteamentos.show", [ 'loteamento' => $quadra->loteamento->id ])}}">{{ $quadra->loteamento->nome }}</a></td>
                                    </tr>
                                    <tr>
                                        <td>Criada Em:</td>
                                        <td>{{ date('d/m/Y H:i:s', strtotime($quadra->created_at)) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <a href="#" data-toggle="modal" data-target="#modal-edit-quadra" class="btn btn-info btn-block">Editar</a>

                                            {{-- Modal Editar Quadra --}}
                                            <div class="modal fade" id="modal-edit-quadra" style="display: none;" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{route('admin.quadras.update', ['quadra' => $quadra->id])}}" method="post">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Editar Quadra</h4>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label>Descrição:</label>
                                                                            <input type="text" name="descricao" class="form-control" value="{{$quadra->descricao}}" required>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer text-right">
                                                                <button type="submit" class="btn btn-primary">Salvar Quadra</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                                <!-- /.modal-dialog -->
                                            </div>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-6 order-1 order-md-2">

                            <h4 class="">Dados de localização</h4>

                            <div class="h-100 pb-5">
                                <div id="map" class=""></div>

                                <form action="{{ route('admin.quadras.show', ['quadra' => $quadra->id]) }}"
                                    method="post" id="frmUpdateLocation">
                                    @csrf
                                    <input id="txtLatitude" name="latitude" type="text" style="display: none">
                                    <input id="txtLongitude" name="longitude" type="text" style="display: none">
                                    <input id="txtZoom" name="zoom" type="text" style="display: none">
                                    <button class="btn btn-block btn-success" type="submit" id="btnSaveLocation"
                                    style="display: none">Atualizar Dados
                                    </button>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col" id="lista_exibe">

            <div class="card">
                <div class="card-header">
                    <div class="row p-3">
                        <div class="col col-8">
                            <h4 class="card-title ">
                                <a class="d-block " data-toggle="collapse" href="#lotes" aria-expanded="true">
                                    <h4 class=""> Lotes</h4>
                                </a>
                            </h4>
                        </div>
                        <div class="
                                            col col-4 text-right">
                            <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal-add-lote">
                                <i class="fas fa-plus">
                                </i>
                            </a>
                        </div>
                    </div>

                    {{-- Modal Add Lote --}}
                    <div class="modal fade" id="modal-add-lote" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('admin.lotes.store') }}">
                                    @csrf
                                    <input type="hidden" name="quadra_id" value="{{ $quadra->id }}">
                                    <input type="hidden" id="add_method" value="basic">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Adicionar Lote</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Descrição:</label>
                                                    <input type="text" name="descricao" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Área:</label>
                                                    <input type="number" id="txtArea" name="area" class="form-control" min=0 step=0.00001 required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Valor:</label>
                                                    <input type="text" name="valor" id="lote_value" required class="form-control money">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-8">
                                                <h4>Coordenadas</h4>
                                            </div>
                                            <div class="col col-4 text-right">
                                                <a class="btn btn-primary" id="btnAddCoordLote">
                                                    <i class="fas fa-plus">
                                                    </i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12" id="listLoteCoords">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer text-right">
                                        <button type="submit" class="btn btn-primary">Criar Lote</button>
                                    </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <div id="lotes" class="collapse show w-100" data-parent="#lista_exibe" style="">
                        <div class="card-body">

                            <table class="table">
                                <thead>
                                    <th>#</th>
                                    <th>Descrição</th>
                                    <th>Valor</th>
                                    <th>Status</th>
                                    <th>Criado em</th>
                                    {{-- <th>Nº de Lotes</th> --}}
                                    <th>Ações</th>
                                </thead>
                                <tbody>
                                    @foreach ($quadra->lotes()->get() as $lote)
                                    <script>
                                        loteCoords = [];
                                    </script>

                                    @foreach ($lote->coordenadas()->get() as $coord)
                                    <script>
                                        loteCoord = {
                                            lat: "{{$coord->latitude}}",
                                            lng: "{{$coord->longitude}}",
                                        };
                                        loteCoords.push(loteCoord);
                                    </script>
                                    @endforeach
                                    <script>
                                        q = {
                                            coords: loteCoords,
                                            id: "{{$quadra->id}}",
                                            url: "{{route("admin.lotes.show", ['lote' => $lote]) }}"
                                        }
                                        quadraLotes.push(q);
                                    </script>
                                    <tr>
                                        <td>{{ $lote->id }}</td>
                                        <td>{{ $lote->descricao }}</td>
                                        <td>{{ numberToMoney($lote->valor) }}</td>
                                        <td>{{ $lote_status[$lote->status] }}</td>
                                        <td>{{ date('d/m/Y H:i:s', strtotime($lote->created_at)) }}</td>
                                        {{-- <td>{{ $lote->count() }}</td> --}}
                                        <td>
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('admin.lotes.show', ['lote' => $lote]) }}">
                                                <i class="fas fa-eye">
                                                </i>
                                            </a>
                                            <a class="btn btn-danger btn-sm"
                                                href="{{ route('admin.lotes.delete', ['lote' => $lote]) }}">
                                                <i class="fas fa-trash">
                                                </i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

        <div class="row">
            <div class="col" id="lista_exibe">
    
                <div class="card">
                    <div class="card-header">
                        <div class="row p-3">
                            <div class="col col-12">
                                <h4 class="card-title">
                                    <a class="d-block" data-toggle="collapse" href="#coordenadas">
                                        <h4 class="">Coordenadas</h4>
                                    </a>
                                </h4>
                            </div>
                        </div>
                        <div id="coordenadas" class="collapse w-100" data-parent="#lista_exibe" style="">
                            <div class="card-body">
    
                                <table class="table">
                                    <thead>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($quadra->coordenadas as $coordenada)
                                        <tr>
                                            <td>{{$coord->latitude}}</td>
                                            <td>{{$coord->longitude}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
    
            </div>
</section>
@endsection
@section("js")
    <script src="{{ url("template/assets/js/wicket.js") }}"></script>
    <script src="{{ url("template/assets/js/wicket-gmap3.js") }}"></script>
    <script src="{{ url("template/assets/js/javascript.util.min.js") }}"></script>
    <script src="{{ url("template/assets/js/jsts.min.js") }}"></script>
    <script src="{{ url('js/map.js') }}"></script>
    <script src="{{ url('js/quadras/view.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GCP_MAPS_API', '') }}&callback=initMap&libraries=drawing"></script>

    <script>
        $('form').on('submit', function(e) {
        let v = $("#lote_value");
        let val = $(v).maskMoney('unmasked')[0];
        $(v).val(val);
    })
    </script>
@endsection