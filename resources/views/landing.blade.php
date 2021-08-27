@extends("templates.landing")

@section('page_title'){{ $loteamento->nome }} - Participe da Newsletter
@endsection

@section('content')

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
                    <input type="hidden" name="loteamento_id" value="{{ $loteamento->id }}">
                    <div class="input-group mb-3">
                        <input type="name" class="form-control" placeholder="Nome" required="required">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" required="required">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <label>Desejo saber de todos os lotementos {{ env('APP_NAME') }}</label>
                        <input type="checkbox" class="form-control" name="all_loteamentos">
                    </div>
                    <div class="input-group mb-3">
                        <label>Declaro que li e concordo com os <a>Termos de Uso</a> {{ env('APP_NAME') }}</label>
                        <input type="checkbox" class="form-control" name="all_loteamentos">
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Quero me inscrever</button>
                        </div>
                    </div>
                </form>

            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->


@endsection
