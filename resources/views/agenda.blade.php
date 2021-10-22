@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reservas') }}</div>

                @foreach($data['agenda'] as $agendamento)
                    @if(Auth::user()->is_admin == 1) <a href="agendamento/{{$agendamento->id}}"> @endif
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
    </div>
</div>
@endsection