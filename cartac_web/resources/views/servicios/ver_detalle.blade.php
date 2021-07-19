@extends('layouts.app')
@section('title', 'Ver detalle servicio')
@section('content')
<div class="contenedor">
    <div class="row">
        <div class="col-12">
            <div class="nav-indicador">
                <a href="{{route('servicios.index')}}">Servicios</a>
                <span> &gt; </span>
                <a href="{{route('servicios.ver_detalle', ['id' => $servicio->ser_id])}}">Ver detalle</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <b>Cliente</b><br>
            <span>{{$servicio->cliente->cli_nombres." ".$servicio->cliente->cli_apellidos}}</span>
        </div>
        <div class="col-3">
            <b>Conductor</b><br>
            <span>
                @if (isset($servicio->conductor->con_nombres) && isset($servicio->conductor->con_apellidos))     
                {{$servicio->conductor->con_nombres." ".$servicio->conductor->con_apellidos}}
                @else
                SIN ASIGNAR
                @endif                
            </span>
        </div>
        <div class="col-3">
            <b>Placa vehiculo</b><br>
            <span>{{$servicio->vehiculo->veh_placa ?? "SIN ASIGNAR"}}</span>
        </div>
        <div class="col-3">
            <b>Tipo vehiculo</b><br>
            <span>{{$servicio->vehiculo->dimension_tipo_veh->tipo_vehiculo->tip_name ?? "SIN ASIGNAR"}}</span>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <b>Subtotal</b><br>
            <span>${{number_format($servicio->ser_subtotal,0,",",".")}}</span>
        </div>
        <div class="col-3">
            <b>Ganancia</b><br>
            <span>${{number_format($servicio->ser_ganancia,0,",",".")}}</span>
        </div>
        <div class="col-3">
            <b>Descuento</b><br>
            <span>- ${{number_format($servicio->ser_descuento,0,",",".")}}</span>
        </div>
        <div class="col-3">
            <b>Valor final</b><br>
            <span>${{number_format($servicio->ser_valor_final,0,",",".")}}</span>
        </div>  
    </div>
    <div class="row">
        <div class="col-12">
            <input type="hidden" id="ruta" value="{{$ruta}}" />
            <b>Ruta cotizada</b><br><br>
            <input type="hidden" id="lat_ini" name="lat_ini" value="{{ $servicio->lat_ini }}"/>
            <input type="hidden" id="lng_ini" name="lng_ini" value="{{ $servicio->lng_ini }}"/>

            <input type="hidden" id="lat_fin" name="lat_fin" value="{{ $servicio->lat_fin }}"/>
            <input type="hidden" id="lng_fin" name="lng_fin" value="{{ $servicio->lng_fin }}"/>
            @foreach ($servicio->peajes_servicio as $peaje_servicio)
                <input type="hidden" name="pea_nombre[]" value="{{$peaje_servicio->peaje->pea_nombre}}"/>
                <input type="hidden" name="pea_lat[]" value="{{$peaje_servicio->peaje->lat}}"/>
                <input type="hidden" name="pea_lng[]" value="{{$peaje_servicio->peaje->lng}}"/>
                <input type="hidden" name="pea_valor_cobrado[]" value="${{number_format($peaje_servicio->pjs_valor_cobrado,0, ",",".")}}"/>
                
            @endforeach
            <input type="hidden" id="zoom" name="zoom" value="14"/>
            <div id="map"></div>
            <br>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <b>Direcci&oacute;n inicio</b><br>
            <span>{{$servicio->ser_direccion_ini}}</span>
        </div>
        <div class="col-3">
            <b>Direcci&oacute;n fin</b><br>
            <span>{{$servicio->ser_direccion_fin}}</span>
        </div>
        <div class="col-3">
            <b>Creado a las</b><br>
            <span>{{date("Y-m-d H:i", strtotime($servicio->ser_created_at))}}</span>
        </div>
        <div class="col-3">
            <b>Aceptado a las</b><br>
            <span>
                @if (isset($servicio->ser_aceptado_at))
                    {{date("Y-m-d H:i", strtotime($servicio->ser_aceptado_at))}}
                @else
                    SIN ACEPTAR
                @endif
                
            </span>
        </div>
    </div>
    @if($servicio->estado->est_clase == "calificado")
        <div class="row">
            <div class="col-3">
                <b>Calificacion</b><br>
                <span>{{$servicio->ser_calificacion}}</span>
            </div>
            <div class="col-9">
                <b>Opini&oacute;n</b><br>
                <span>{{$servicio->ser_opinion}}</span>
            </div>
        </div>
    @elseif($servicio->estado->est_clase == "cancelado")
        <div class="row">
            <div class="col-12">
                <b>Motivo cancelación</b><br>
                <span>{{$servicio->ser_motivo_cancelacion}}</span>
            </div>        
        </div>
    @else
        <div class="row">
            <div class="col-md-12 text-center">
                <br>
                <button id="cancelar_servicio" class="btn btn-danger">Cancelar servicio</button>
            </div>
        </div>
        
    </div>
    @endif
    
</div>
<div class="modal fade modal-eliminar" tabindex="-1" role="dialog" aria-labelledby="modal-eliminar" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="my-0">En verdad desea cancelar este servicio?</h5>
            </div>
            <div class="modal-body">
                
                <form method="POST" action="{{route('servicios.cancelar', ['id' => $servicio->ser_id])}}" id="form-eliminar">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 text-center">
                            <input type="submit" class="btn btn-danger" value="Cancelar" />
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
<script type="text/javascript" src="{{ URL::asset('js/servicios/forms.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0gQEgTaB-CQOhEBv7rzhpBdmjnPWUhTo&callback=initMap&libraries=&v=weekly" async></script>

@endsection
