@extends("templates.admin")

@section('content')

    <script>
        var LatLanding = {{ $loteamento->coordenada->latitude ?? env('GCP_DEFAULT_LAT') }};
        var LongLanding = {{ $loteamento->coordenada->longitude ?? env('GCP_DEFAULT_LONG') }};
        var ZoomLanding = {{ $loteamento->coordenada->zoom ?? env('GCP_DEFAULT_ZOOM') }};
        var MustAddMarker =
            {{ isset($loteamento->coordenada->latitude) && isset($loteamento->coordenada->longitude) ? '1' : '0' }};
    </script>
    <section class="content card-body">

        <div class="row">
            <div class="col-12">
                <div class="card h-100 ">
                    <div class="card-header h-100 ">
                        <div class="row">
                            <div class="col col-12 col-lg-6">
                                <h4 class="d-block"> Dados do Loteamento</h4>
                                <div class="table mt-3">
                                    <table class="">
                                        <tr>
                                            <td>Nome:</td>
                                            <td>{{ $loteamento->nome }}</td>
                                        </tr>
                                        <tr>
                                            <td>Link:</td>
                                            <td><a
                                                    href="{{ env('APP_URL') . '/' . $loteamento->link }}">{{ env('APP_URL') . '/' . $loteamento->link }}</a>
                                            </td>
                                        </tr>
                                        <tr>

                                        </tr>
                                        <tr>
                                            <td>Criado Em:</td>
                                            <td>{{ date('H:i:s d/m/Y', strtotime($loteamento->created_at)) }}</td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                            <div class="col col-12 col-lg-6">
                                <h4 class="d-block"> Dados de Localização</h4>

                                <div class="h-100 pb-5">
                                    <div id="map" class=""></div>

                                    <form
                                        action="{{ route('admin.loteamentos.updateLocation', ['loteamento' => $loteamento->id]) }}"
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

        {{-- Quadras --}}
        <div class="row mt-4">
            <div class="col" id="lista_exibe">

                <div class="card">
                    <div class="card-header">
                        <div class="row p-3">
                            <div class="col col-8">
                                <h4 class="card-title ">
                                    <a class="d-block " data-toggle="collapse" href="#quadras" aria-expanded="true">
                                        <h4 class="___class_+?17___"> Quadras</h4>
                                    </a>
                                </h4>
                            </div>
                            <div class="col col-4 text-right">
                                <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal-add-quadra">
                                    <i class="fas fa-plus">
                                    </i>
                                </a>
                            </div>
                        </div>

                        {{-- Modal Add Quadra --}}
                        <div class="modal fade" id="modal-add-quadra" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('admin.quadras.store') }}">
                                        @csrf
                                        <input type="hidden" name="loteamento_id" value="{{ $loteamento->id }}">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Adicionar Quadra</h4>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <div class="form-group">
                                                <label>Descrição:</label>
                                                <input type="text" name="descricao">
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="submit" class="btn btn-primary">Criar
                                                Quadra</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <div id="quadras" class="collapse show w-100" data-parent="#lista_exibe" style="">
                            <div class="card-body">
                                @if(session("error_message_quadra"))
                                    <div class="alert alert-danger">
                                        {{session("error_message_quadra")}}
                                    </div>
                                @endif
                                <table class="table">
                                    <thead>
                                        <th>#</th>
                                        <th>Descrição</th>
                                        <th>Criado em</th>
                                        <th>Nº de Lotes</th>
                                        <th>Ações</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($loteamento->quadras()->get() as $quadra)
                                            <tr>
                                                <td>{{ $quadra->id }}</td>
                                                <td>{{ $quadra->descricao }}</td>
                                                <td>{{ date('H:i:s d/m/Y', strtotime($quadra->created_at)) }}
                                                </td>
                                                <td>{{ $quadra->lotes()->count() }}</td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm"
                                                        href="{{ route('admin.quadras.show', ['quadra' => $quadra]) }}">
                                                        <i class="fas fa-eye">
                                                        </i>
                                                    </a>
                                                    {{-- <a class="btn btn-info btn-sm" href="#">
                                                        <i class="fas fa-pencil-alt">
                                                        </i>
                                                        Edit
                                                    </a> --}}
                                                    <a class="btn btn-danger btn-sm"
                                                        href="{{ route('admin.quadras.delete', ['quadra' => $quadra]) }}">
                                                        <i class="fas fa-trash">
                                                        </i>
                                                    </a>
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

        {{-- Landing Page --}}
        <div class="row">
            <div class="col" id="lista_images">

                <div class="card">
                    <div class="card-header">
                        <div class="row p-3">
                            <div class="col col-8">
                                <h4 class="card-title ">
                                    <a class="d-block " data-toggle="collapse" href="#landing" aria-expanded="true">
                                        <h4 class="___class_+?17___">Landing Page </h4>
                                    </a>
                                </h4>
                            </div>
                            <div class="col col-4 text-right">
                                {{-- <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#modal-add-quadra">
                                    <i class="fas fa-plus">
                                    </i>
                                </a> --}}
                            </div>
                        </div>

                        <div id="landing" class="collapse show w-100" data-parent="#lista_exibe" style="">
                            <div class="card-body">
                                <form id="updateLandingPage" method='POST'
                                    action="{{ route('admin.loteamentos.editLandingLayout', ['loteamento' => $loteamento]) }}">
                                    @csrf
                                    <h2>Textos</h2>

                                    {{-- Exibir erros --}}


                                    <div class="form-group">
                                        <label for="descricao">Descrição</label>
                                        <textarea class="w-100"
                                            name="descricao">{{ $loteamento->landingPage->descricao ?? '' }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Cor de Fundo</label>
                                        <input type="color" name="cor_fundo"
                                            value="{{ $loteamento->landingPage->cor_fundo ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="">Cor do Texto</label>
                                        <input type="color" name="cor_texto"
                                            value="{{ $loteamento->landingPage->cor_texto ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" id="updateLandingPage" class="btn btn-success">Enviar</button>
                                    </div>
                                </form>


                                <hr>

                                <div class="row">
                                    <div class="col-3">
                                        <h2>Arquivos</h2>
                                    </div>
                                    <div class="col-2 offset-7 text-right">
                                        <a class="btn btn-primary" href="#" data-toggle="modal"
                                            data-target="#modal-add-file">
                                            <i class="fas fa-plus">
                                            </i>
                                        </a>
                                        {{-- Modal Add Imagem --}}
                                        <div class="modal fade" id="modal-add-file" style="display: none;"
                                            aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="POST" enctype="multipart/form-data"
                                                        action="{{ route('admin.loteamentos.uploadFile', ['loteamento' => $loteamento]) }}"
                                                        id="formAddImage">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Enviar Arquivo</h4>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="form-group">
                                                                <label>Arquivo:</label>
                                                                <input type="file" id="file" name="file" required />
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Tipo:</label>
                                                                <select name="type" required>
                                                                    <option value="">Selecione</option>
                                                                    <option value="image">Imagem</option>
                                                                    <option value="video">Vídeo</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <button type="submit" id="sendFile"
                                                                class="btn btn-primary">Enviar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                    </div>
                                </div>
                                <table class="table">
                                    <thead>
                                        <th>#</th>
                                        <th>Criado em</th>
                                        <th>Ações</th>
                                    </thead>
                                    <tbody id="files_list">
                                        @foreach ($loteamento->assets()->get() as $asset)

                                            <tr id="r-{{ $asset->id }}">
                                                <td>
                                                    @if ($asset->type == 'I')
                                                        <img src="{{ env('AWS_BASE') . $asset->filepath }}"
                                                            class="img-list" style="max-width:300px" />
                                                    @else
                                                        <video src="{{ $asset->filepath }}"
                                                            class="img-list"></video>
                                                    @endif
                                                </td>
                                                <td>{{ date('H:i:s d/m/Y', strtotime($asset->created_at)) }}
                                                </td>
                                                <td>
                                                    <a class="btn btn-danger btn-sm" data-delete="{{ $asset->id }}"
                                                        href="{{ route('asset.delete', ['asset' => $asset]) }}">
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
    </section>

@endsection

@section("js")
    <script src="{{ url('js/loteamentos/view.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GCP_MAPS_API', '') }}&callback=initMap">
    </script>
@endsection