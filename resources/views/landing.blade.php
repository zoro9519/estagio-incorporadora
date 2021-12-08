@extends("templates.landing")

@section('page_title'){{ $loteamento->nome }} - Participe da Newsletter
@endsection

@section("cor_fundo") {{ $loteamento->landingPage->cor_fundo ?? "#e9ecef"}}
@endsection

@section('content')

<script>
    var LatLanding = {{ $loteamento->coordenada->latitude ?? env('GCP_DEFAULT_LAT') }};
    var LongLanding = {{ $loteamento->coordenada->longitude ?? env('GCP_DEFAULT_LONG') }};
    var ZoomCoord = {{ $loteamento->coordenada->zoom ?? env('GCP_DEFAULT_ZOOM') }};
    var loteamentoName = "{{ $loteamento->nome}}";
</script>

{{-- <section class="content"> --}}
    <div class="p-4" style="{{ !empty($loteamento->cor_fundo) ? "background-color:  .$loteamento->cor_fundo" : ""}}">
        <div class="row">
            <div class="col">

                <div class="card">
                    <div class="card-header text-center">

                        <h4>{{ $loteamento->nome }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <p>{{$loteamento->landingPage->descricao}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Acompanhe a Obra </h4>
                    </div>
                    <div class="card-body">
                        <p>{{$loteamento->landingPage->texto_acompanhe_a_obra}}</p>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar"
                                data-transitiongoal="{{intval($loteamento->landingPage->percentual_acompanhe_a_obra ?? 80)}}"
                                ></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        {{-- Galeria de imagens --}}
        @if(count($loteamento->assets()->images()->get()))
        <div class="row mt-2">
            <div class="col-12 mb-2">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Galeria de Imagens</h4>
                    </div>
                    <div class="card-body">
                        <div class="row mt-2">
                            @foreach ($loteamento->assets()->images()->get() as $asset)
                            <div class="col-4 ">
                                <button class="card h-75 w-100 align-items-center" class="open-details">

                                    <div class="card-body">
                                        <img src="{{ env('AWS_BASE') . $asset->filepath }}"
                                            class="img-list text-center max-to-parent"
                                            style="max-width: 100%; max-height:100%" />
                                    </div>
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if(count($loteamento->assets()->videos()->get()))
        <div class="row mt-2">
            <div class="col-12 mb-2">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Vídeos</h4>
                    </div>
                    <div class="card-body">
                        @foreach ($loteamento->assets()->videos()->get() as $asset)
                        <div class="col-4">
                            <div class="card">

                                <div class="card-body">

                                    <video src="{{ env('AWS_BASE') . $asset->filepath }}" class="img-list"
                                        style="max-width:300px"></video>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Mapa --}}
        <div class="row">
            <div class="col-8" style="max-height: 600px">

                <div class="card h-100">
                    <div class="card-header text-center">
                        <h4>Localização</h4>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-12">
                                <h6>{{$loteamento->landingPage->endereco_completo}}</h6>
                                <h6>Rodovia José Silva, KM 31 - Presidente Prudente / SP</h6>
                            </div>
                        </div>
                        <div class="row" style="height: 400px">
                            <div class="col col-12">
                                <div id="map" style="width: 100%; heigth: 200px"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4" style="max-height: 600px">
                <div class="card h-100">
                    <div class="card-header text-center">
                        <h4><p class="login-box-msg">Inscreva-se em nossa newsletter</p></h4>
                    </div>
                    <div class="card-body">
                        @if(session('return'))
                            <div class="col-12">
                                <div class="alert alert-{{session('return')['success'] ? 'success' : 'warning'}}">
                                    {{ session('return')['message'] }}
                                </div>
                            </div>
                        @endif
                        <form action="{{ route('landing.save', ['loteamento' => $loteamento]) }}" id="frm_landing"
                            method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="name" name="nome" class="form-control" placeholder="Nome"
                                    required="required">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email"
                                    required="required">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <label class="form-control-range">Desejo saber de todos os loteamentos {{ env('APP_NAME') }}</label>
                                <input type="checkbox" class="form-control" name="interests">
                            </div>
                            <div class="input-group mb-3">
                                <label class="form-control-range">Declaro que li e concordo com os <a>Termos de Uso</a> {{ env('APP_NAME')
                                    }}</label>
                                <input type="checkbox" class="form-control" name="termos_uso" required>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block">Quero me inscrever</button>
                                </div>
                            </div>
                            @if(session('success'))
                            <div class="row mt-2">
                                <div class="col-12 card alert alert-success">
                                    <p>{{session('success')}}</p>
                                </div>
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    
    {{-- <div class="login-box mb-3">
        <div class="row">

            <div class="col">
                <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">Inscreva-se em nossa newsletter</p>

                        <form action="{{ route('landing.save', ['loteamento' => $loteamento]) }}" id="frm_landing"
                            method="post">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="name" name="nome" class="form-control" placeholder="Nome"
                                    required="required">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email"
                                    required="required">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <label>Desejo saber de todos os lotementos {{ env('APP_NAME') }}</label>
                                <input type="checkbox" class="form-control" name="interests">
                            </div>
                            <div class="input-group mb-3">
                                <label>Declaro que li e concordo com os <a>Termos de Uso</a> {{ env('APP_NAME')
                                    }}</label>
                                <input type="checkbox" class="form-control" name="termos_uso">
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-block">Quero me inscrever</button>
                                </div>
                            </div>
                            @if(session('success'))
                            <div class="row mt-2">
                                <div class="col-12 card alert alert-success">
                                    <p>{{session('success')}}</p>
                                </div>
                            </div>
                            @endif
                        </form>

                    </div>
                    <!-- /.login-card-body -->
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <footer class="main-footer">
        <strong>Copyright © 2021 - SmartIncorp</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 0.0
        </div>
    </footer> --}}
    <!-- /.login-box -->

    {{--
</section> --}}
<script src="{{ url('js/landing.js') }}"></script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GCP_MAPS_API', '') }}&callback=initMap">
</script>
@endsection
@section('js')
<script>
    $(document).ready(function() {
    $('.progress .progress-bar').progressbar({
        display_text: 'fill',
        use_percentage: false,
    //     amount_format: function(p, t) {
    //         return (p / t * 100).toFixed(2) + ' %';
    //     }
    });
});
</script>
@endsection