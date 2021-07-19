@extends('layouts.app')
@section('title', 'Servicios')
@section('content')
<div class="contenedor">    
    <div class="row">
        <div class="col-12">
            <div class="nav-indicador">
                <a href="{{route('servicios.index')}}">Servicios</a>
            </div>
        </div>
    </div>
    @if (session('mensaje'))
        <div class="alert alert-success">
            {{ session('mensaje') }}
        </div>
    @endif

    <br>
    <div class="row">
        <div class="col-12">
            <table class="table table-striped" id="tabla-servicios">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Placa</th>
                        <th>Tipo vehiculo</th>
                        <th>Conductor</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th class="text-center">Ver detalles</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($servicios as $servicio)
                        <tr>
                            <td>{{$servicio->ser_id}}</td>
                            <td>{{$servicio->vehiculo->veh_placa ?? "SIN ASIGNAR"}}</td>
                            <td>{{$servicio->vehiculo->dimension_tipo_veh->tipo_vehiculo->tip_name ?? "SIN ASIGNAR"}}</td>
                            <td>@if (isset($servicio->conductor->con_nombres) && isset($servicio->conductor->con_apellidos)) 
                                {{$servicio->conductor->con_nombres." ".$servicio->conductor->con_apellidos}}
                                @else
                                SIN ASIGNAR
                                @endif
                            </td>
                            <td>{{$servicio->cliente->cli_nombres." ".$servicio->cliente->cli_apellidos}}</td>
                            <td>{{"$".number_format($servicio->ser_valor_final,0,",",".")}}</td>
                            <td>{{$servicio->estado->est_name}}</td>
                            <td class="text-center"><a href="{{route('servicios.ver_detalle', ['id' => $servicio->ser_id])}}" class="ver_detalle"><i class="fas fa-eye"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('js/servicios/lista.js') }}"></script>
@endsection
