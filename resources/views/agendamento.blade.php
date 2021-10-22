@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Alterar reserva') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('update') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{$data['agendamento']->id}}">
                        <input type="hidden" name="solicitante" value="{{$data['agendamento']->solicitante}}">

                        <div class="form-group row">
                            <label for="espaco" class="col-md-4 col-form-label text-md-right">{{ __('Espaço:') }}</label>
                            <div class="col-md-6">
                                <select name="espaco" id="espaco" class="form-control">
                                    @for($i = 0; $i < sizeof($data['espacos']); $i++)
                                        <option value="{{$i+1}}" @if($data['espacos'][$i] == $data['agendamento']->espaco) selected @endif>{{$data['espacos'][$i]}}</option>
                                    @endfor
                                </select>  
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="periodo" class="col-md-4 col-form-label text-md-right">{{ __('Período:') }}</label>
                            <div class="col-md-6">
                                <select name="periodo" id="periodo" class="form-control">
                                    @for($i = 0; $i < sizeof($data['periodos']); $i++)
                                        <option value="{{$i+1}}" @if($data['periodos'][$i] == $data['agendamento']->periodo) selected @endif>{{$data['periodos'][$i]}}</option>
                                    @endfor
                                </select>  
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="data" class="col-md-4 col-form-label text-md-right">{{ __('Data:') }}</label>

                            <div class="col-md-6">
                                <input id="data" min="{{ $data['date'] }}" type="date" class="form-control @error('nome') is-invalid @enderror" name="data" value="{{ $data['agendamento']->data }}" required autocomplete="data" autofocus>

                                @error('data')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Alterar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection