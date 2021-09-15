@extends("templates.landing")

@section('page_title'){{ $loteamento->nome }} - Participe da Newsletter
@endsection

@section("cor_fundo") {{ $loteamento->landingPage->cor_fundo ?? "#e9ecef"}}
@endsection

@section('content')

    <script>
        var LatLanding = {{ $loteamento->coordenada->latitude ?? env('GCP_DEFAULT_LAT') }};
        var LongLanding = {{ $loteamento->coordenada->longitude ?? env('GCP_DEFAULT_LONG') }};
    </script>

    <div class="row">
        <div class="col col-6 w-25 h-25">
        </div>
        <div class="col col-6">
        </div>
    </div>
    <div class="box">
    </div>
    <div class="login-box">
        <div class="login-logo">
            <a href=""><b>{{ $loteamento->nome }} | {{ env('APP_NAME') }}</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Inscreva-se em nossa newsletter</p>

                <form action="{{ route('landing.save', ['loteamento' => $loteamento]) }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="name" name="nome" class="form-control" placeholder="Nome" required="required">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required="required">
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
                        <label>Declaro que li e concordo com os <a>Termos de Uso</a> {{ env('APP_NAME') }}</label>
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



    {{-- <div style="padding: 50px"> --}}
        <div id="map" style="width: 100%; heigth: 200px"></div>

    {{-- </div> --}}
    <!-- /.login-box -->




    {{-- </div>
    </div> --}}

    <script src="{{ url('js/landing.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GCP_MAPS_API', '') }}&callback=initMap">
    </script>
@endsection
