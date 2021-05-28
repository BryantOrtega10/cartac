@extends('layouts.app')
@section('title', 'Configuración general')
@section('content')
<div class="contenedor">
    
    <div class="row">
        <div class="col-12">
            <div class="nav-indicador">
                <a href="{{route('configuracion.index')}}">Categorias</a>
                <span> &gt; </span>
                <a href="{{route('configuracion.modificar_gen')}}">Configuraci&oacute;n general</a>
            </div>
        </div>
    </div>
    <div>
        <form method="POST" action="{{ route('configuracion.modificar_gen') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label for="distancia" class="col-1  col-form-lable text-right">Distancia</label>
                <div class="col">
                    <input id="distancia" type="number" step="0.01" class="form-control @error('distancia') is-invalid @enderror" name="distancia" value="{{ old('distancia', $configuracion->cfg_distancia) }}" required autocomplete="distancia" autofocus>
                    @error('distancia')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="tiempo" class="col-1  col-form-lable text-right">Tiempo</label>
                <div class="col">
                    <input id="tiempo" type="number" step="0.01" class="form-control @error('tiempo') is-invalid @enderror" name="tiempo" value="{{ old('tiempo', $configuracion->cfg_tiempo) }}" required autocomplete="tiempo">
                    @error('tiempo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="peso" class="col-1  col-form-lable text-right">Peso</label>
                <div class="col">
                    <input id="peso" type="number" step="0.01" class="form-control @error('peso') is-invalid @enderror" name="peso" value="{{ old('peso', $configuracion->cfg_peso) }}" required autocomplete="peso">
                    @error('peso')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="porcentaje_seguro" class="col-1  col-form-lable text-right">Porcentaje Seguro</label>
                <div class="col">
                    <input id="porcentaje_seguro" type="number" step="0.01" class="form-control @error('porcentaje_seguro') is-invalid @enderror" name="porcentaje_seguro" value="{{ old('porcentaje_seguro', $configuracion->cfg_porcentaje_seguro) }}" required autocomplete="porcentaje_seguro">
                    @error('porcentaje_seguro')
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
