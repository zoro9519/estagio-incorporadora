<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env("APP_NAME")}} - @yield("page_title")</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url("template/assets/fontawesome-free/css/all.min.css") }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url("template/assets/adminlte-user.css") }}">
    <!-- overlayScrollbars -->
    {{-- <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css"> --}}

    @yield("css")
</head>

<body class="hold-transition sidebar-mini layout-fixed" data-panel-auto-height-mode="height">
    <div class="wrapper">

        <!-- Navbar -->
        {{-- <nav class="main-header navbar navbar-expand navbar-white navbar-light"> --}}
        <nav class="navbar-expand navbar-white navbar-light display-flex">
            <!-- Left navbar links -->
            <ul class="navbar-nav align-items-center">

                <li class="nav-item">
                    <a href="{{route("user.home")}}" class="brand-link">
                        <img src="{{ url("template/assets/img/AdminLTELogo.png") }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                            style="opacity: .8">
                        <span class="brand-text">{{ env("APP_NAME")}}</span>
                    </a>
                    {{-- <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a> --}}
                </li>
                
                {{-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="" class="nav-link">Contact</a>
                </li> --}}
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                <!-- Messages Dropdown Menu -->
                {{-- <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    
                </li> --}}
                <li class="nav-item">
                    <a href="{{route("user.home")}}" class="nav-link">Home</a>
                </li>
                @if(Auth::user()->status == User::STATUS_APROVADO)
                <li class="nav-item">
                    <a href="{{route("user.agendamentos")}}" class="nav-link">Meus Agendamentos</a>
                </li>
                @endif
                <li class="nav-item ">
                    <a class="nav-link" href="{{route("user.profile")}}">{{Auth::user()->nome}}</a>
                    
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="{{route("user.auth.logout")}}" role="button">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" data-loading-screen="750">
        
            <div class="tab-content">
                {{-- @if(Auth::user()->status == User::STATUS_APROVADO) --}}
                    @yield("content")
                {{-- @else --}}
                {{-- <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger">
                            Sua conta nõ
                        </div>
                    </div>
                </div> --}}
                {{-- @endif --}}
            </div>
        </div>

        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; {{date('Y')}} {{env("APP_NAME")}}.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.1.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
<!-- jQuery -->
<script src="{{ url("template/assets/jquery/jquery.min.js") }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{url("template/assets/jquery-ui/jquery-ui.min.js")}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    // $.widget.bridge('uibutton', $.ui.button)
    const coresLotes = JSON.parse('<?= json_encode(Lote::colorsUser); ?>');
    const coresAgendamentos = JSON.parse('<?= json_encode(Agendamento::colorsUser); ?>');
</script>
<!-- Bootstrap 4 -->
<script src="{{ url("template/assets/bootstrap/js/bootstrap.bundle.min.js") }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.min.js"></script>
<script src="{{ url("template/assets/js/jquerymask.js") }}"></script>
<script src="{{ url("template/assets/js/maskMoney.js") }}"></script>

<script>
    $(document).ready(function(){
        $(".money").maskMoney({
            prefix: "R$ ",
            decimal: ",",
            thousands: "."
        });

        $('.cpf').mask('000.000.000-00', {reverse: true});
        $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
        $('.phone').mask('(00) 00000-0000');
        $('.cep').mask('00000-000');
        $('.coordenate').mask('000.000000000000000', {
            reverse: true
        });
    });
</script>
<!-- overlayScrollbars -->
{{-- <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script> --}}
<!-- AdminLTE App -->
{{-- <script src="{{ url("template/assets/js/adminlte.js") }}"></script> --}}
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{ url("template/assets/js/demo.js") }}"></script> --}}
@yield("js")
</body>

</html>
