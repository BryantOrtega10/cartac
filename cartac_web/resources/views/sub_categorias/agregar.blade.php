@extends('layouts.app')
@section('title', 'Agregar Categoria')
@section('content')
<div class="contenedor">
    
    <div class="row">
        <div class="col-12">
            <div class="nav-indicador">
                <a href="{{route('categorias.index')}}">Categorias</a> 
                <span> &gt; </span>
                <a href="{{route('categorias.subcategoria.index',['categoria' => $categoria_sup->cat_id])}}">Sub-categorias de {{$categoria_sup->cat_name}}</a>
                <span> &gt; </span>
                <a href="{{route('categorias.subcategoria.agregar',['categoria' => $categoria_sup->cat_id])}}">Agregar</a>
            </div>
        </div>
    </div>
    <div>
        <form method="POST" action="{{ route('categorias.subcategoria.agregar',['categoria' => $categoria_sup->cat_id]) }}" enctype="multipart/form-data">
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
                <label for="foto" class="col-1  col-form-lable text-right">Icono</label>
                <div class="col">
                    <input id="foto" type="file" accept="image/jpeg, image/png, image/gif" class="form-control-file @error('foto') is-invalid @enderror" name="foto" autocomplete="foto">
                    @error('foto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    
                </div>
            </div>
            <div class="form-group row">
                
                <label for="preview" class="col-1  col-form-lable text-right">Previsualización</label>
                <div class="col">
                    <img src="/imgs/theme/no-image.png" id="preview" class="categoria" />
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
<script type="text/javascript" src="{{ URL::asset('js/categorias/forms.js') }}"></script>
@endsection
