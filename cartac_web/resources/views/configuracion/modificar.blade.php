@extends('layouts.app')
@section('title', 'Agregar Configuración')
@section('content')
<div class="contenedor">
    
    <div class="row">
        <div class="col-12">
            <div class="nav-indicador">
                <a href="{{route('configuracion.index')}}">Categorias</a>
                <span> &gt; </span>
                <a href="{{route('configuracion.modificar', ['id' => $multiplicador->cfm_id])}}">Multiplicador</a>
            </div>
        </div>
    </div>
    <div>
        <form method="POST" action="{{ route('configuracion.modificar', ['id' => $multiplicador->cfm_id]) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label for="hora_inicio" class="col-1  col-form-lable text-right">Hora Inicio</label>
                <div class="col">
                    <input id="hora_inicio" type="time" class="form-control @error('hora_inicio') is-invalid @enderror" name="hora_inicio" value="{{ old('hora_inicio', substr($multiplicador->cfm_hora_inicio,0,5)) }}" required autocomplete="hora_inicio" autofocus>
                    @error('hora_inicio')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="hora_fin" class="col-1  col-form-lable text-right">Hora Fin</label>
                <div class="col">
                    <input id="hora_fin" type="time" class="form-control @error('hora_fin') is-invalid @enderror" name="hora_fin" value="{{ old('hora_fin', substr($multiplicador->cfm_hora_fin,0,5)) }}" required autocomplete="hora_fin">
                    @error('hora_fin')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="multiplicador" class="col-1  col-form-lable text-right">Multiplicador</label>
                <div class="col">
                    <input id="multiplicador" type="number" step="0.01" class="form-control @error('multiplicador') is-invalid @enderror" name="multiplicador" value="{{ old('multiplicador', $multiplicador->cfm_multiplicador) }}" required autocomplete="multiplicador">
                    @error('multiplicador')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group row mb-0">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Modificar</button>
                </div>
            </div>
        
        </form>
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('js/configuracion/forms.js') }}"></script>
@endsection
