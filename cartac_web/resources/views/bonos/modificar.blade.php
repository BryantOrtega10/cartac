@extends('layouts.app')
@section('title', 'Modifiar Bono')
@section('content')
<div class="contenedor">
    
    <div class="row">
        <div class="col-12">
            <div class="nav-indicador">
                <a href="{{route('bonos.index')}}">Bonos</a>
                <span> &gt; </span>
                <a href="{{route('bonos.modificar', ['id' => $bono->bon_id])}}">Modificar</a>
            </div>
        </div>
    </div>
    <div>
        <form method="POST" action="{{ route('bonos.modificar', ['id' => $bono->bon_id]) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label for="codigo" class="col-1  col-form-lable text-right">C&oacute;digo</label>
                <div class="col">
                    <input id="codigo" type="text" class="text-uppercase form-control @error('codigo') is-invalid @enderror" name="codigo" value="{{ old('codigo', $bono->bon_codigo) }}" required autocomplete="codigo" autofocus>
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
                    <input id="fecha_inicio" type="datetime-local" class="form-control @error('fecha_inicio') is-invalid @enderror" name="fecha_inicio" value="{{ old('fecha_inicio', date("Y-m-d", strtotime($bono->bon_fecha_ini))."T". date("H:i:s", strtotime($bono->bon_fecha_ini))) }}" required autocomplete="fecha_inicio" autofocus>
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
                    <input id="fecha_fin" type="datetime-local" class="form-control @error('fecha_fin') is-invalid @enderror" name="fecha_fin" value="{{ old('fecha_fin', date("Y-m-d", strtotime($bono->bon_fecha_fin))."T". date("H:i:s", strtotime($bono->bon_fecha_fin))) }}" required autocomplete="fecha_fin" autofocus>
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
                        <option @if(old('tipo', $bono->tipo) == "1") selected @endif value="1">Valor</option>
                        <option @if(old('tipo', $bono->tipo) == "2") selected @endif value="2">Porcentaje</option>
                    </select>
                    @error('tipo')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group row opcion_valor @if(old('tipo',$bono->tipo) == "1") activo @endif">
                <label for="valor" class="col-1  col-form-lable text-right">Valor</label>
                <div class="col">
                    <input id="valor" type="text" class="form-control separadorMiles @error('valor') is-invalid @enderror" name="valor" value="{{ old('valor', $bono->bon_valor) }}" autocomplete="valor" autofocus>
                    @error('valor')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group row opcion_porcentaje @if(old('tipo', $bono->tipo) == "2") activo @endif">
                <label for="porcentaje" class="col-1  col-form-lable text-right">Porcentaje (%)</label>
                <div class="col">
                    <input id="porcentaje" type="text" class="form-control @error('porcentaje') is-invalid @enderror" name="porcentaje" value="{{ old('porcentaje', $bono->bon_porcentaje) }}" autocomplete="porcentaje" autofocus>
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
                    <input id="disponibles" type="text" class="form-control @error('disponibles') is-invalid @enderror" name="disponibles" value="{{ old('disponibles', $bono->bon_disponibles) }}" required autocomplete="disponibles" autofocus>
                    @error('disponibles')
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
<script type="text/javascript" src="{{ URL::asset('js/jquery.inputmask.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.inputmask.numeric.extensions.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/bonos/forms.js') }}"></script>
@endsection
