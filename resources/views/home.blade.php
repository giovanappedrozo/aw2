@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-dark text-white">{{ __('Suas reservas') }}</div>

                @foreach($data['agenda'] as $agendamento)
                    @if(Auth::user()->id == $agendamento->solicitante)
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
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection