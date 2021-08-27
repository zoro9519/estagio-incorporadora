@extends("templates.auth")

@section("page_title")Login
@endsection

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href=""><b>{{env("APP_NAME")}}</b></a>
            {{-- {{ $pass }} --}}
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Faça login para acessar como Admin</p>

                <form action="{{route("admin.auth.login")}}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Senha" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                        </div>
                    </div>
                    @if(session('error'))
                    <div class="row mt-1">
                        <div class="col-12">
                            <p class="alert alert-danger">{{session('error')}}</p>
                        </div>
                    </div>
                    @endif
                </form>

                <p class="mb-1">
                    <a href="{{ route("admin.auth.remember") }}">Esqueci minha Senha</a>
                </p>
                <p class="mb-1">
                    <a href="{{ route("user.auth") }}">Acesso via cliente</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->


@endsection
