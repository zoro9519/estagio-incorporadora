@extends("templates.admin")

@section('content')
    <section class="content">
        {{-- Cards da dashboard --}}
        <div class="row">
            <div class="col col-6">
                <a class="card m-5 alert-warning" href="{{route("admin.users.all", ['filterStatus' => User::STATUS_EMESPERA])}}">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                Contas Aguardando Aprovação: <h2 class="badge badge-warning">{{ $contas_pendentes }}</h2>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col col-6">
                <a class="card m-5 alert-warning" href="{{route("admin.agendamentos.all", [ "filterStatus"=> Agendamento::STATUS_EMESPERA, "filterType" => Agendamento::TYPE_VISITA])}}">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                Agendamentos pendentes: <h2 class="badge badge-warning">{{ $agendamentos_pendentes }}</h2>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            {{-- <div class="col col-4">
                <div class="card m-5">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('admin.agendamentos.all') }}">Meus Agendamentos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-4">
                <div class="card m-5">
                    <div class="card-header">
                        <div class="row">
                            <div class="col">
                                <a href="
                                "></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

    </section>
@endsection
