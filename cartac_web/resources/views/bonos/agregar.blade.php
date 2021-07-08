@extends('layouts.app')
@section('title', 'Agregar Bono')
@section('content')
<div class="contenedor">
    
    <div class="row">
        <div class="col-12">
            <div class="nav-indicador">
                <a href="{{route('bonos.index')}}">Categorias</a>
                <span> &gt; </span>
                <a href="{{route('bonos.agregar')}}">Agregar</a>
            </div>
        </div>
    </div>
    <div>
        <form method="POST" action="{{ route('bonos.agregar') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label for="codigo" class="col-1  col-form-lable text-right">C&oacute;digo</label>
                <div class="col">
                    <input id="codigo" type="text" class="form-control @error('codigo') is-invalid @enderror" name="codigo" value="{{ old('codigo') }}" required autocomplete="codigo" autofocus>
                    @error('codigo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="fecha_inicio" class="col-1  col-form-lable text-right">Fecha inicio</label>
                <div class="col">
                    <input id="fecha_inicio" type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required autocomplete="fecha_inicio" autofocus>
                    @error('fecha_inicio')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="fecha_fin" class="col-1  col-form-lable text-right">Fecha fin</label>
                <div class="col">
                    <input id="fecha_fin" type="date" class="form-control @error('fecha_fin') is-invalid @enderror" name="fecha_fin" value="{{ old('fecha_fin') }}" required autocomplete="fecha_fin" autofocus>
                    @error('fecha_fin')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="tipo" class="col-1  col-form-lable text-right">Tipo</label>
                <div class="col">
                    <select class="form-control @error('tipo') is-invalid @enderror"  id="tipo" name="tipo">
                        <option @if(old('tipo') == "1") selected @endif value="1">Valor</option>
                        <option @if(old('tipo') == "2") selected @endif value="2">Porcentaje</option>
                    </select>
                    @error('tipo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row opcion_valor activo">
                <label for="valor" class="col-1  col-form-lable text-right">Valor</label>
                <div class="col">
                    <input id="valor" type="text" class="form-control separadorMiles @error('valor') is-invalid @enderror" name="valor" value="{{ old('valor') }}" required autocomplete="valor" autofocus>
                    @error('valor')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row opcion_porcentaje">
                <label for="porcentaje" class="col-1  col-form-lable text-right">Porcentaje (%)</label>
                <div class="col">
                    <input id="porcentaje" type="text" class="form-control @error('porcentaje') is-invalid @enderror" name="porcentaje" value="{{ old('porcentaje') }}" required autocomplete="porcentaje" autofocus>
                    @error('porcentaje')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="disponibles" class="col-1  col-form-lable text-right">Disponibles</label>
                <div class="col">
                    <input id="disponibles" type="text" class="form-control @error('disponibles') is-invalid @enderror" name="disponibles" value="{{ old('disponibles') }}" required autocomplete="disponibles" autofocus>
                    @error('disponibles')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </div>
        
        </form>
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('js/bonos/forms.js') }}"></script>
@endsection
