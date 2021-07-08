@extends('layouts.app')
@section('title', 'Bonos')
@section('content')
<div class="contenedor">
    
    <div class="row">
        <div class="col-12">
            <div class="nav-indicador">
                <a href="{{route('bonos.index')}}">Bonos</a>
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
            <a href="{{route('bonos.agregar')}}" class="btn btn-primary">Agregar bono</a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <table class="table table-striped" id="tabla-peajes">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>C&oacute;digo</th>
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
                        <th>Descuento</th>
                        <th>Disponibles</th>
                        <th class="text-center">Modificar</th>
                        <th class="text-center">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bonos as $bono)
                        <tr>
                            <td>{{$bono->bon_id}}</td>
                            <td>{{$bono->bon_codigo}}</td>
                            <td>{{date("Y-m-d", strtotime($bono->bon_fecha_ini))}}</td>
                            <td>{{date("Y-m-d", strtotime($bono->bon_fecha_fin))}}</td>
                            <td>@if (isset($bono->bon_valor))
                                {{number_format($bono->bon_valor, 0, ".", ",")}}
                            @else
                                {{$bono->bon_porcentaje."%"}}
                            @endif</td>
                            <td>{{$bono->bon_disponibles}}</td>
                            <td class="text-center"><a href="{{route('bonos.modificar', ['id' => $peaje->pea_id])}}" class="modificar"><i class="fas fa-edit"></i></a></td>
                            <td class="text-center">
                                <a href="{{route('bonos.eliminar', ['id' => $peaje->pea_id])}}" class="eliminar"><i class="fas fa-trash"></i></a>
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
                    <h5 class="my-0">En verdad desea eliminar este bono?</h5>
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
