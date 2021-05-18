@extends('layouts.app')
@section('title', 'Peaje')
@section('content')
<div class="contenedor">
    
    <div class="row">
        <div class="col-12">
            <div class="nav-indicador">
                <a href="{{route('peajes.index')}}">Peajes</a>
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
            <a href="{{route('peajes.agregar')}}" class="btn btn-primary">Agregar peaje</a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <table class="table table-striped" id="tabla-peajes">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th class="text-center">Modificar</th>
                        <th class="text-center">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peajes as $peaje)
                        <tr>
                            <td>{{$peaje->pea_id}}</td>
                            <td>{{$peaje->pea_nombre}}</td>
                            <td class="text-center"><a href="{{route('peajes.modificar', ['id' => $peaje->pea_id])}}" class="modificar"><i class="fas fa-edit"></i></a></td>
                            <td class="text-center">
                                <a href="{{route('peajes.eliminar', ['id' => $peaje->pea_id])}}" class="eliminar"><i class="fas fa-trash"></i></a>
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
                    <h5 class="my-0">En verdad desea eliminar este peaje?</h5>
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
<script type="text/javascript" src="{{ URL::asset('js/peaje/lista.js') }}"></script>
@endsection
