@extends('layouts.app')
@section('title', 'Tipos de vehiculos')
@section('content')
<div class="contenedor">
    
    <div class="row">
        <div class="col-12">
            <div class="nav-indicador">
                <a href="{{route('tipos_de_vehiculo.index')}}">Tipos de vehiculos</a>
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
            <a href="{{route('tipos_de_vehiculo.agregar')}}" class="btn btn-primary">Agregar tipo de vehiculo</a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <table class="table table-striped" id="tabla-tipos-vehiculos">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Foto</th>
                        <th>Alquiler</th>
                        <th>Combustible</th>
                        <th>Rendimiento</th>
                        <th>Tiempo de cargue</th>
                        <th>Categoria peaje</th>
                        <th class="text-center">Modificar</th>
                        <th class="text-center">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tipos as $tipo)
                        <tr>
                            <td>{{$tipo->tip_id}}</td>
                            <td>{{$tipo->tip_name}}</td>
                            <td><img class="img-tipo-vehiculo" src="{{ (isset($tipo->tip_foto) && !empty($tipo->tip_foto) ? Storage::url($tipo->tip_foto) : '/imgs/theme/no-image.png' ) }}"/></td>
                            <td>{{"$".number_format($tipo->tip_alquiler,0,".",",")}}</td>
                            <td>{{$tipo->tip_combustible}}</td>
                            <td>{{$tipo->tip_rendimiento}}</td>
                            <td>{{$tipo->tip_tiempo_cargue}}</td>
                            <td>{{$tipo->categoria_peaje->ctp_name}}</td>
                            <td class="text-center"><a href="{{route('tipos_de_vehiculo.modificar', ['id' => $tipo->tip_id])}}" class="modificar"><i class="fas fa-edit"></i></a></td>
                            <td class="text-center">
                                <a href="{{route('tipos_de_vehiculo.eliminar', ['id' => $tipo->tip_id])}}" class="eliminar"><i class="fas fa-trash"></i></a>
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
                    <h5 class="my-0">En verdad desea eliminar este tipo de vehiculo?</h5>
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
<script type="text/javascript" src="{{ URL::asset('js/tipos_de_vehiculo/lista.js') }}"></script>
@endsection
