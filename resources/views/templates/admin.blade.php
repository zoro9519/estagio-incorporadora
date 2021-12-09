<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | {{ env("APP_NAME")}}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url("template/assets/fontawesome-free/css/all.min.css") }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url("template/assets/adminlte.css") }}">
    <!-- overlayScrollbars -->
    {{-- <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css"> --}}

    @yield("css")

    @if(env("GCP_MAPS_ENABLED", 0))
    <style>
        #map {
            height: 100%;
            min-height: 25em;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

    </style>
    @endif

</head>

<body class="hold-transition sidebar-mini layout-fixed" data-panel-auto-height-mode="height">
    <div class="wrapper" style="max-width: 100%">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                {{-- <li class="nav-item">
                    @yield('breadcrumb')
                    <a class="nav-link" role="button" href="">
                        @yield('page_title')
                    </a>
                </li> --}}
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                {{-- <li class="nav-item"> --}}
                    {{-- <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a> --}}
                    {{-- <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div> --}}
                {{-- </li> --}}

                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="{{route("admin.users.all", ['filterStatus' => User::STATUS_EMESPERA])}}" title="Contas Pendentes">
                        <i class="fas fa-user-circle"></i>
                        <span class="badge badge-warning navbar-badge">{{$contas_pendentes}}</span>
                    </a>
                </li>
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="{{route('admin.agendamentos.all', [ "filterStatus"=> Agendamento::STATUS_EMESPERA, "filterType" => Agendamento::TYPE_VISITA])}}" title="Agendamentos Pendentes">
                        <i class="far fa-calendar"></i>
                        <span class="badge badge-warning navbar-badge">{{$agendamentos_pendentes}}</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{route("admin.auth.logout")}}" role="button" title="Sair">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{route("admin.home")}}" class="brand-link">
                <img src="{{ url("template/assets/img/AdminLTELogo.png") }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">{{env("APP_NAME")}}</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ url("template/assets/img/user2-160x160.jpg") }}" class="img-circle elevation-2" alt="{{ Auth::user()->nome }} Profile">
                        {{-- Add path to admin profile picture --}}
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->nome }}</a>
                    </div>
                </div>

                {{-- <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div> --}}

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item {{ Request::is('admin') ? 'show' : ''}}">
                            <a href="{{route("admin.home")}}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/users') || Request::is('admin/users/*') ? 'show' : ''}}">
                            <a href="{{ route("admin.users.all") }}" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Clientes
                                </p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/agendamentos') || Request::is('admin/agendamentos/*') ? 'show' : ''}}">
                            <a href="{{ route("admin.agendamentos.all") }}" class="nav-link">
                                <i class="nav-icon far fa-calendar-alt"></i>
                                <p>
                                    Agendamentos
                                </p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/vendas') || Request::is('admin/vendas/*') ? 'show' : ''}}">
                            <a href="{{ route("admin.vendas.all") }}" class="nav-link">
                                <i class="nav-icon fas fa-dollar-sign"></i>
                                <p>
                                    Vendas
                                </p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/loteamentos') || Request::is('admin/loteamentos/*') ? 'show' : ''}}">
                            <a href="{{ route("admin.loteamentos.all") }}" class="nav-link">
                                <i class="nav-icon fas fa-map-marker-alt"></i>
                                <p>
                                    Loteamentos
                                </p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/imobiliarias') || Request::is('admin/imobiliarias/*') ? 'show' : ''}}">
                            <a href="{{ route("admin.imobiliarias.all") }}" class="nav-link">
                                <i class="nav-icon far fa-building"></i>
                                <p>
                                    Imobiliárias
                                </p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/corretores') || Request::is('admin/corretores/*') ? 'show' : ''}}">
                            <a href="{{ route("admin.corretores.all") }}" class="nav-link">
                                <i class="nav-icon fas fa-user-tie"></i>
                                <p>
                                    Corretores
                                </p>
                            </a>
                        </li>
                        

                        <li class="nav-header">RELATÓRIOS</li>
                        <li class="nav-item {{ Request::is('admin/relatorios/agendamentos') ? 'show' : ''}}">
                            <a href="{{route('admin.relatorios.agendamentos')}}" class="nav-link">
                                <i class="nav-icon far fa-calendar-alt"></i>
                                <p>
                                    Agendamentos
                                    {{-- <span class="badge badge-info right">2</span> --}}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item {{ Request::is('admin/relatorios/lotes') ? 'show' : ''}}">
                            <a href="{{route('admin.relatorios.lotes')}}" class="nav-link">
                                <i class="nav-icon fas fa-map-marker-alt"></i>
                                <p>
                                    Lotes
                                    {{-- <span class="badge badge-info right">2</span> --}}
                                </p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="" class="nav-link">
                                <i class="nav-icon far fa-image"></i>
                                <p>
                                    -------------
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon far fa-envelope"></i>
                                <p>
                                    ---------
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>----</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>---------</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>------------------</p>
                                    </a>
                                </li>
                            </ul>
                        </li> --}}
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
        
            <div class="tab-content">
                @yield("content")
            </div>
            <!-- /.content-wrapper -->
        </div>
        <footer class="main-footer">
            <strong>Copyright &copy; {{ date("Y") }} - {{ env("APP_NAME") }}</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> {{ env( "APP_VERSION", '0.0') }}
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
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ url("template/assets/bootstrap/js/bootstrap.bundle.min.js") }}"></script>
    <!-- overlayScrollbars -->
    {{-- <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script> --}}
    <!-- AdminLTE App -->
    <script src="{{ url("template/assets/js/adminlte.js") }}"></script>
    <!-- AdminLTE for demo purposes -->
    {{-- <script src="{{ url("template/assets/js/demo.js") }}"></script> --}}
    <script src="{{ url("template/assets/js/jquerymask.js") }}"></script>
    <script src="{{ url("template/assets/js/maskMoney.js") }}"></script>
    
    <script src="{{ url("js/main.js") }}"></script>
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
    @yield("js")
</body>

</html>
