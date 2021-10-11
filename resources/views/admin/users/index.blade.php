@extends("templates.admin")

@section('page_title')Clientes
@endsection
@section('content')
    <section class="content p-2">
        <div class="container-fluid">
        <!-- Default box -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Filtros</h4>
                    </div>
                    <div class="card-body">

                        @if (session('success'))
                            <div class="row">
                                <div class="col alert alert-success">
                                    <h3 class="card-title ">{{ session('success') }}</h3>
                                </div>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="row">
                                <div class="col alert alert-danger">
                                    <h3 class="card-title ">{{ session('error') }}</h3>
                                </div>
                            </div>
                        @endif
                        <form>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" name="filterEmail" class="form-control">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Situação</label>
                                        <select name="filterStatus" class="form-control">
                                            <option>Selecione</option>
                                            <option value="A">Aguardando Aprovação</option>
                                            <option value="V">Aprovado</option>
                                            <option value="E">Recusado</option>
                                            {{-- <option>Recusado</option> --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-primary">Filtrar</button>
                                        <a href="{{ route('admin.users.all') }}"
                                        class="btn btn-warning">Limpar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                
                    <div class="col">
                        <table class="table table-striped projects">
                            <thead>
                                <tr>
                                    <th style="width: 1%">
                                        #
                                    </th>
                                    <th style="width: 25%">
                                        Nome
                                    </th>
                                    <th style="width: 20%">
                                        Email
                                    </th>
                                    <th style="width: 5%"
                                        class="">
                                        Status
                                    </th>
                                    <th style="width: 15%">
                                        Loteamento de interesse
                                    </th>
                                    <th style="width: 20%" class="text-center">
                                        Ações
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)

                                    <tr id="r-{{ $user->id }}">
                                        <td>
                                            {{ $user->id }}
                                        </td>
                                        <td>
                                            <a>
                                                {{ $user->nome }}
                                            </a>
                                            <br />
                                            <small>
                                                Criado em: {{ date('d/m/Y', strtotime($user->created_at)) }}
                                            </small>
                                        </td>
                                        <td>
                                            {{ $user->email }}
                                        </td>
                                        <td class="text-center">
                                            {{ $user_status[$user->status] }}
                                        </td>
                                        <td class="text-center">

                                            {{ $user->loteamentosDeInteresse()->first()->nome ?? '' }}
                                        </td>
                                        <td class="project-actions text-center">
                                            <a class="btn btn-primary btn-sm"
                                                href="{{ route('admin.users.show', ['user' => $user]) }}">
                                                <i class="fas fa-folder"></i> View
                                            </a>
                                            <a class="btn btn-warning btn-sm" href="#">
                                                <i class="fas fa-wrench"></i> Editar
                                            </a>
                                            {{-- Status de aguardando aprovação (precisa ser aprovado) --}}
                                            @if ($user->status == 'A')
                                                <a class="btn btn-success btn-sm"
                                                    href="{{ route('admin.users.aprovar', [
                                                        'user' => $user,
                                                    ]) }}">
                                                    <i class="fas fa-check"></i> Aprovar conta
                                                </a>

                                            @endif
                                            {{-- <a class="btn btn-info btn-sm" href="#">
                                    <i class="fas fa-pencil-alt">
                                    </i>
                                    Edit
                                </a> --}}
                                            {{-- <a class="btn btn-danger btn-sm" href="#">
                                <i class="fas fa-trash"></i> Delete
                            </a> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        </div>
    </section>
@endsection
