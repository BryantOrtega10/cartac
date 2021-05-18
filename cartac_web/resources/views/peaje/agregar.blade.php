@extends('layouts.app')
@section('title', 'Agregar Peaje')
@section('content')
<div class="contenedor">
    
    <div class="row">
        <div class="col-12">
            <div class="nav-indicador">
                <a href="{{route('peajes.index')}}">Peajes</a>
                <span> &gt; </span>
                <a href="{{route('peajes.agregar')}}">Agregar</a>
            </div>
        </div>
    </div>
    <div>
        <form method="POST" action="{{ route('peajes.agregar') }}">
            @csrf
            <div class="form-group row">
                <label for="nombre" class="col-1  col-form-lable text-right">Nombre</label>
                <div class="col">
                    <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre" autofocus>
                    @error('nombre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="radio" class="col-1  col-form-lable text-right">Radio</label>
                <div class="col">
                    <select id="radio" class="form-control @error('radio') is-invalid @enderror" name="radio" required>
                        <option value="10" @if(old('radio')=="10") selected @endif>10mts</option>
                        <option value="20" @if(old('radio')=="20") selected @endif>20mts</option>
                        <option value="30" @if(old('radio')=="30") selected @endif>30mts</option>
                        <option value="50" @if(old('radio')=="50") selected @endif>50mts</option>
                        <option value="100" @if(old('radio')=="100") selected @endif>100mts</option>
                    </select>
                    @error('radio')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <input type="hidden" id="lat" name="lat" value="{{ old('lat','4.7001307') }}"/>
            <input type="hidden" id="lng" name="lng" value="{{ old('lng','-74.0612254') }}"/>
            <input type="hidden" id="zoom" name="zoom" value="{{ old('zoom','7') }}"/>
            
            
            <div class="form-group row">
                <label for="" class="col-1  col-form-lable text-right">Ubicaci&oacute;n</label>
                <div class="col">
                    <div id="map"></div>
                    <input type="hidden" id="map_select" class="@error('map_select') is-invalid @enderror" name="map_select" value="{{ old('map_select','0') }}"/>
                    @error('map_select')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            
            <h2 class="text-center">Tarifas</h2>
            @foreach ($categorias as $categoria)
                <div class="form-group row">
                    <label for="cat_{{$categoria->ctp_id}}" class="col-1 col-form-lable text-right">{{$categoria->ctp_name}}</label>
                    <div class="col">
                        <input id="cat_{{$categoria->ctp_id}}" type="text" class="form-control separadorMiles @error('cat_'.$categoria->ctp_id) is-invalid @enderror" name="cat_{{$categoria->ctp_id}}" value="{{ old('cat_'.$categoria->ctp_id) }}" required autocomplete="cat_{{$categoria->ctp_id}}">
                        @error('cat_{{$categoria->ctp_id}}')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>                            
                </div>    
            @endforeach                    
            <div class="form-group row mb-0">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                </div>
            </div>
        
        </form>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0gQEgTaB-CQOhEBv7rzhpBdmjnPWUhTo&callback=initMap&libraries=&v=weekly" async></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.inputmask.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/jquery.inputmask.numeric.extensions.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/peaje/forms.js') }}"></script>
@endsection
