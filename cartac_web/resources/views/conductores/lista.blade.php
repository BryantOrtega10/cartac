@extends('layouts.app')
@section('title', 'Conductores')
@section('content')
<div class="contenedor">    
    <div class="row">
        <div class="col-12">
            <div class="nav-indicador">
                <a href="{{route('conductores.index')}}">Conductores</a>
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
            <table class="table table-striped" id="tabla-conductores">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Documento</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Email</th>
                        <th>Estado</th>
                        <th class="text-center">Verificar</th>
                        </tr>
                </thead>
                <tbody>
                    @foreach ($conductores as $conductor)
                        <tr>
                            <td>{{$conductor->con_id}}</td>
                            <td>{{$conductor->con_documento}}</td>
                            <td>{{$conductor->con_nombres}}</td>
                            <td>{{$conductor->con_apellidos}}</td>
                            <td>{{$conductor->con_email}}</td>
                            <td>{{$conductor->est_name}}</td>
                            <td class="text-center"><a href="{{route('conductores.verificar', ['id' => $conductor->con_id])}}" class="verificar"><i class="fas fa-user-check"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('js/conductores/lista.js') }}"></script>
@endsection
