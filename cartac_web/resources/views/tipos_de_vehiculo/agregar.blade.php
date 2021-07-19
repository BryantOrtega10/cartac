@extends('layouts.app')
@section('title', 'Agregar tipos de vehiculos')
@section('content')
<div class="contenedor">
    
    <div class="row">
        <div class="col-12">
            <div class="nav-indicador">
                <a href="{{route('tipos_de_vehiculo.index')}}">Tipos de vehiculos</a>
                <span> &gt; </span>
                <a href="{{route('tipos_de_vehiculo.agregar')}}">Agregar</a>
            </div>
        </div>
    </div>
    <div>
        <form method="POST" action="{{ route('tipos_de_vehiculo.agregar') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label for="nombre" class="col-1  col-form-lable text-right">Nombre</label>
                <div class="col">
                    <input id="nombre" type="text" class="text-uppercase form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre" autofocus>
                    @error('nombre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="imagen" class="col-1  col-form-lable text-right">Imagen</label>
                <div class="col">
                    <input id="imagen" type="file" accept="image/jpeg, image/png, image/gif" class="form-control-file @error('imagen') is-invalid @enderror" name="imagen" autocomplete="imagen">
                    @error('imagen')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror                    
                </div>
            </div>
            <div class="form-group row">
                
                <label for="preview" class="col-1  col-form-lable text-right">Previsualización</label>
                <div class="col">
                    <img src="/imgs/theme/no-image.png" id="preview" class="img-tipo-vehiculo" />
                </div>
            </div>
            <div class="form-group row">
                <label for="alquiler" class="col-1  col-form-lable text-right">Alquiler</label>
                <div class="col">
                    <input id="alquiler" type="text" class="separadorMiles form-control @error('alquiler') is-invalid @enderror" name="alquiler" value="{{ old('alquiler') }}" required autocomplete="alquiler" autofocus>
                    @error('alquiler')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="tipo_combustible" class="col-1  col-form-lable text-right">Tipo Combustible</label>
                <div class="col">
                    <select id="tipo_combustible" class="form-control @error('tipo_combustible') is-invalid @enderror" name="tipo_combustible"  required>
                        <option value="">Seleccione una</option>
                        <option @if(old('tipo_combustible') == "GASOLINA") selected @endif value="GASOLINA">GASOLINA</option>
                        <option @if(old('tipo_combustible') == "ACPM") selected @endif value="ACPM">ACPM</option>
                        <option @if(old('tipo_combustible') == "GAS") selected @endif value="GAS">GAS</option>
                    </select>
                    @error('tipo_combustible')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="rendimiento" class="col-1  col-form-lable text-right">Rendimiento</label>
                <div class="col">
                    <input id="rendimiento" type="text" class="form-control @error('rendimiento') is-invalid @enderror" name="rendimiento" value="{{ old('rendimiento') }}" required autocomplete="rendimiento" autofocus>
                    @error('rendimiento')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="tiempo_cargue" class="col-1  col-form-lable text-right">Tiempo de cargue</label>
                <div class="col">
                    <input id="tiempo_cargue" type="text" class="form-control @error('tiempo_cargue') is-invalid @enderror" name="tiempo_cargue" value="{{ old('tiempo_cargue') }}" required autocomplete="tiempo_cargue" autofocus>
                    @error('tiempo_cargue')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="categoria_peaje" class="col-1  col-form-lable text-right">Categoria peaje</label>
                <div class="col">
                    <select id="categoria_peaje" class="form-control @error('categoria_peaje') is-invalid @enderror" name="categoria_peaje"  required>
                        <option value="">Seleccione una</option>
                        @foreach ($categoriasPeaje as $categoriaPeaje)
                            <option @if(old('categoria_peaje') == $categoriaPeaje->ctp_id) selected @endif value="{{ $categoriaPeaje->ctp_id }}">{{ $categoriaPeaje->ctp_name}}</option>
                        @endforeach
                    </select>
                    @error('categoria_peaje')
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
<script type="text/javascript" src="{{ URL::asset('js/jquery.inputmask.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.inputmask.numeric.extensions.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/tipos_de_vehiculo/forms.js') }}"></script>
@endsection
