@extends('layouts.app')
@section('title', 'Categorias')
@section('content')
<div class="contenedor">    
    <div class="row">
        <div class="col-12">
            <div class="nav-indicador">
                <a href="{{route('categorias.index')}}">Categorias</a>
            </div>
        </div>
    </div>
   
    @if (session('mensaje'))
        <div class="alert alert-success">
            {{ session('mensaje') }}
        </div>
    @endif

    <div class="row">
        <div class="col-12 text-right">
            <a href="{{route('categorias.agregar')}}" class="btn btn-primary">Agregar categoria</a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <table class="table table-striped" id="tabla-categorias">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Sub Categorias</th>
                        <th>Icono</th>                        
                        <th class="text-center">Modificar</th>
                        <th class="text-center">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categorias as $categoria)
                        <tr>
                            <td>{{$categoria->cat_id}}</td>
                            <td>{{$categoria->cat_name}}</td>
                            <td><a href="{{route('categorias.subcategoria.index', ['categoria' => $categoria->cat_id])}}"> Sub-categorias ({{$categoria->sub_categorias}})</a></td>                            
                            <td><img class="categoria" src="{{ (isset($categoria->cat_icono) && !empty($categoria->cat_icono) ? Storage::url($categoria->cat_icono) : '/imgs/theme/no-image.png' ) }}"/></td>
                            <td class="text-center"><a href="{{route('categorias.modificar', ['id' => $categoria->cat_id])}}" class="modificar"><i class="fas fa-edit"></i></a></td>
                            <td class="text-center">
                                <a href="{{route('categorias.eliminar', ['id' => $categoria->cat_id])}}" class="eliminar"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade modal-eliminar" tabindex="-1" role="dialog" aria-labelledby="modal-eliminar" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="my-0">En verdad desea eliminar esta categoria?</h5>
                </div>
                <div class="modal-body">
                    
                    <form method="POST" action="" id="form-eliminar">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 text-center">
                                <input type="submit" class="btn btn-danger" value="Eliminar" />
                            </div>
                            <div class="col-sm-6 text-center">
                                <input type="button" class="btn btn-secondary" data-dismiss="modal" value="Cancelar" />
                            </div>
                        </div>                                                
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('js/categorias/lista.js') }}"></script>
@endsection
