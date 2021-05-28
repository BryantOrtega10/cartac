@extends('layouts.app')
@section('title', 'Configuración')
@section('content')
<div class="contenedor">
    
    <div class="row">
        <div class="col-12">
            <div class="nav-indicador">
                <a href="{{route('configuracion.index')}}">Configuración</a>
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
            <a href="{{route('configuracion.modificar_gen')}}" class="btn btn-primary">Modificar configuraci&oacute;n</a>
            <a href="{{route('configuracion.agregar')}}" class="btn btn-primary">Agregar multiplicador</a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <table class="table table-striped" id="tabla-configuracion">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Hora inicio</th>
                        <th>Hora fin</th>
                        <th>Multiplicador</th>
                        <th class="text-center">Modificar</th>
                        <th class="text-center">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($multiplicadores as $multiplicador)
                        <tr>
                            <td>{{$multiplicador->cfm_id}}</td>
                            <td>{{$multiplicador->cfm_hora_inicio}}</td>
                            <td>{{$multiplicador->cfm_hora_fin}}</td>
                            <td>{{$multiplicador->cfm_multiplicador}}</td>
                            <td class="text-center"><a href="{{route('configuracion.modificar', ['id' => $multiplicador->cfm_id])}}" class="modificar"><i class="fas fa-edit"></i></a></td>
                            <td class="text-center">
                                <a href="{{route('configuracion.eliminar', ['id' => $multiplicador->cfm_id])}}" class="eliminar"><i class="fas fa-trash"></i></a>
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
                    <h5 class="my-0">En verdad desea eliminar este multiplicador?</h5>
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
<script type="text/javascript" src="{{ URL::asset('js/configuracion/lista.js') }}"></script>
@endsection
