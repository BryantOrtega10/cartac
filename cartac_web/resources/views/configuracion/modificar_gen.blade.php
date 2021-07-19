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
                <label for="hora_hombre" class="col-1  col-form-lable text-right">Hora Hombre</label>
                <div class="col">
                    <input id="hora_hombre" type="text" class="separadorMiles form-control @error('hora_hombre') is-invalid @enderror" name="hora_hombre" value="{{ old('hora_hombre', $configuracion->cfg_hora_hombre) }}" required autocomplete="hora_hombre" autofocus>
                    @error('hora_hombre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="gasolina" class="col-1  col-form-lable text-right">Precio gasolina</label>
                <div class="col">
                    <input id="gasolina" type="text" class="separadorMiles form-control @error('gasolina') is-invalid @enderror" name="gasolina" value="{{ old('gasolina', $configuracion->cfg_gasolina) }}" required autocomplete="gasolina">
                    @error('gasolina')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="gas" class="col-1  col-form-lable text-right">Precio gas</label>
                <div class="col">
                    <input id="gas" type="text" class="separadorMiles form-control @error('gas') is-invalid @enderror" name="gas" value="{{ old('gas', $configuracion->cfg_gas) }}" required autocomplete="gas">
                    @error('gas')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="acpm" class="col-1  col-form-lable text-right">Precio acpm</label>
                <div class="col">
                    <input id="acpm" type="text" class="separadorMiles form-control @error('acpm') is-invalid @enderror" name="acpm" value="{{ old('acpm', $configuracion->cfg_acpm) }}" required autocomplete="acpm">
                    @error('acpm')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="porcentaje_seguro" class="col-1  col-form-lable text-right">Porcentaje Seguro (%)</label>
                <div class="col">
                    <input id="porcentaje_seguro" type="number" step="0.01" class="form-control @error('porcentaje_seguro') is-invalid @enderror" name="porcentaje_seguro" value="{{ old('porcentaje_seguro', $configuracion->cfg_porcentaje_seguro) }}" required autocomplete="porcentaje_seguro">
                    @error('porcentaje_seguro')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="porcentaje_ganancia" class="col-1  col-form-lable text-right">Porcentaje CARTAC (%)</label>
                <div class="col">
                    <input id="porcentaje_ganancia" type="number" step="0.01" class="form-control @error('porcentaje_ganancia') is-invalid @enderror" name="porcentaje_ganancia" value="{{ old('porcentaje_ganancia', $configuracion->cfg_porcentaje_ganancia) }}" required autocomplete="porcentaje_ganancia">
                    @error('porcentaje_ganancia')
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
<script type="text/javascript" src="{{ URL::asset('js/configuracion/forms.js') }}"></script>
@endsection
