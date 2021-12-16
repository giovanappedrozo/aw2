@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8">
        <div class="card reservas">
            <div class="card-header bg-dark text-white">{{ __('Reservas') }}</div>

            @foreach($data['agenda'] as $agendamento)
                <a href="/agendamento/{{$agendamento->id}}">
                    <div class="card-body">
                        <div>
                            {{ __('Espaço:') }}
                            {{$agendamento->espaco}}
                        </div>
                        <div>
                            {{ __('Periodo:') }}
                            {{$agendamento->periodo}}
                        </div>
                        <div>
                            {{ __('Data:') }}
                            {{$agendamento->data}}
                        </div>
                        <div>
                            {{ __('Solicitante:') }}
                            @foreach($data['usuarios'] as $usuario)
                                @if($usuario->id == $agendamento->solicitante)
                                    {{$usuario->nome}}
                                @endif
                            @endforeach
                        </div>
                    </div>
                </a>
                <hr>
            @endforeach
        </div>
    </div>
    <div class="col-md-4">
        <div class="graph">
            <canvas id="espacos"></canvas><br><br>
            <canvas id="periodos"></canvas>
        </div>
    </div>
  </div>
</div>
@endsection