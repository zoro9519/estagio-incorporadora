@extends("templates.auth")

@section("page_title")Login
@endsection

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href=""><b>{{env("APP_NAME")}}</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Faça login para acessar o sistema</p>

                <form action="{{route("user.auth.login")}}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>

                <p class="mb-1">
                    <a href="{{ route("user.auth.remember") }}">Esqueci minha Senha</a>
                </p>
                <p class="mb-0">
                    <a href="register.html" class="text-center">Cadastrar</a>
                </p>
                <p class="mb-1">
                    <a href="{{ route("admin.auth") }}">Acesso Admin</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->


@endsection
