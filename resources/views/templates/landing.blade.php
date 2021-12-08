<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield("page_title")</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('template/assets/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    {{-- <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css"> --}}
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('template/assets/adminlte.css') }}">

    @if(env("GCP_MAPS_ENABLED", 0))
    <style>
        #map {
            height: 100%;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

    </style>
    @endif
    @yield("styles")
</head>

<body class="hold-transition" style="background-color: @yield("cor_fundo")">

    <nav class="navbar navbar-expand navbar-white navbar-light">
        
        <ul class="navbar-nav">
            <li class="nav-item">
                <span class="mx-2 text-xl"><a href="{{env('APP_URL')}}">{{env('APP_NAME')}}</a>
                {{-- <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> --}}
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <div class="text-right">
                    <a class="btn btn-rounded btn-success" href="#frm_landing">Quero mais informações</a>
                </div>
            </li>
        </ul>
    </nav>
    {{-- <header>
    </header> --}}
    <section class="login-page h-auto">
        @yield("content")
    </section>
    <!-- jQuery -->
    <script src="{{ url('template/assets/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('template/assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('template/assets/js/adminlte.js') }}"></script>
    <script src="{{ url('template/assets/js/bootstrap-progressbar.min.js') }}"></script>
    @yield('js')

</body>

</html>
