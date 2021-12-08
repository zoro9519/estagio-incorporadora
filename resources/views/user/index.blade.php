@extends("templates.user")

@section("page_title")Home
@endsection
@section("content")


<section class="content">

{{-- Disparar modal fixo para preencher dados pessoais se for primeiro acesso --}}
@if(Auth::user()->status == 'A')

@endif

{{-- Box para carrosel de loteamentos disponíveis pela incorporadora --}}

<div class="row text-center">
    <div class="col">
        <h2 class="alert alert-primary m-2">Loteamentos Disponíveis</h2>
    </div>
</div>
<div class="row">
    @foreach ($loteamentos as $loteamento)
    <div class="col col-4">
        <div class="card m-2 h-75">
            <div class="card-header">
                <h4>
                    <a href="{{route("user.agendamentos.showMap", [
                    "loteamento" => $loteamento ])}}">{{$loteamento->nome }}</a>
                </h4>

            </div>
            <div class="card-body text-center">
                @if($loteamento->assets()->count())
                
                <img class="text-center max-to-parent" style="max-height: 100%; max-width: 100%" src="{{Storage::disk("s3")->url($loteamento->assets()->first()->filepath) }}" />
                @endif
            </div>

        </div>
    </div>
    @endforeach
</div>
<br>
<br>

</section>
@endsection