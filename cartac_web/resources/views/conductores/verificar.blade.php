@extends('layouts.app')
@section('title', 'Verificar Conductor')
@section('content')
<div class="contenedor">
    
    <div class="row">
        <div class="col-12">
            <div class="nav-indicador">
                <a href="{{route('conductores.index')}}">Conductores</a>
                <span> &gt; </span>
                <a href="{{route('conductores.verificar', ['id' => $conductor->con_id])}}">Verificar</a>
            </div>
        </div>
    </div>
    <div>
        @if(isset($vehiculo))
        
        <p>Seleccione los campos erroneos</p>
        <form method="POST" action="{{ route('conductores.responder', ['id' => $conductor->con_id]) }}" class="validar">
            
            @csrf
            <h3>Datos conductor</h3>
            <div class="form-group row align-items-center">
                <div class="col-2 text-right">
                    <input type="checkbox" class="form-check-input" name="validar_campos_conductor[]" id="con_documento" value="con_documento" />
                    <label for="con_documento" class="form-check-label font-weight-bold">Documento</label>
                </div>
                <div class="col-2">
                    <input type="text" value="{{$conductor->con_documento}}" data-name="con_documento" class="form-control" readonly/>
                </div>
                <div class="col-2 text-right">
                    <input type="checkbox" class="form-check-input" name="validar_campos_conductor[]" id="con_nombres" value="con_nombres" />
                    <label for="con_nombres" class="form-check-label font-weight-bold">Nombres</label>
                </div>
                <div class="col-2">
                    <input type="text" value="{{$conductor->con_nombres}}" data-name="con_nombres" class="form-control" readonly/>
                </div>
                <div class="col-2 text-right">
                    <input type="checkbox" class="form-check-input"  name="validar_campos_conductor[]" id="con_apellidos" value="con_apellidos" />
                    <label for="con_apellidos" class="form-check-label font-weight-bold">Apellidos</label>
                </div>
                <div class="col-2">
                    <input type="text" value="{{$conductor->con_apellidos}}" data-name="con_apellidos" class="form-control" readonly/>
                </div>
                
                
            </div>
            <div class="form-group row align-items-center">
                <div class="col-2 text-right">
                    <input type="checkbox" class="form-check-input"  name="validar_campos_conductor[]" id="con_email" value="con_email" />
                    <label for="con_email" class="form-check-label font-weight-bold">Email</label>
                </div>
                <div class="col-2">
                    <input type="text" value="{{$conductor->con_email}}" data-name="con_email" class="form-control" readonly/>
                </div>
                <div class="col-2 text-right">
                    <input type="checkbox" class="form-check-input"  name="validar_campos_conductor[]" id="con_celular" value="con_celular" />
                    <label for="con_celular" class="form-check-label font-weight-bold">Tel&eacute;fono</label>
                </div>
                <div class="col-2">
                    <input type="text" value="{{$conductor->con_celular}}" data-name="con_celular" class="form-control" readonly/>
                </div>
                <div class="col-2 text-right">
                    <input type="checkbox" class="form-check-input" name="validar_campos_conductor[]" id="con_direccion" value="con_direccion" />
                    <label for="con_direccion" class="form-check-label font-weight-bold">Direcci&oacute;n</label>
                </div>
                <div class="col-2">
                    <input type="text" value="{{$conductor->con_direccion}}" data-name="con_direccion" class="form-control" readonly/>
                </div>  
                
                
                 
            </div>
            <div class="form-group row">
                <div class="col-2 text-right">
                    <input type="checkbox" class="form-check-input"  name="validar_campos_conductor[]" id="con_billetera" value="con_billetera" />
                    <label for="con_billetera" class="form-check-label font-weight-bold">Billetera</label>
                </div>
                <div class="col-2">
                    <input type="text" @isset($conductor->con_billetera)
                    value="{{($conductor->con_billetera == 0 ? "NEQUI" : "DAVIPLATA" )}}" 
                    @endisset data-name="con_billetera" class="form-control" readonly/>
                </div>
                <div class="col-2 text-right">
                    <input type="checkbox" class="form-check-input"  name="validar_campos_conductor[]" id="con_numero_billetera" value="con_numero_billetera" />
                    <label for="con_numero_billetera" class="form-check-label font-weight-bold">&num; Billetera</label>
                </div>
                <div class="col-2">
                    <input type="text" value="{{$conductor->con_numero_billetera}}" data-name="con_numero_billetera" class="form-control" readonly/>
                </div>
                <div class="col-2 text-right">
                    <input type="checkbox" class="form-check-input"  name="validar_campos_conductor[]" id="con_hora_trabajo" value="con_hora_trabajo" />
                    <label for="con_hora_trabajo" class="form-check-label font-weight-bold">Valor hora trabajo</label>
                </div>
                <div class="col-2">
                    <input type="text" value="{{$conductor->con_hora_trabajo}}" data-name="con_hora_trabajo" class="form-control" readonly/>
                </div>         
            </div>
            <div class="form-group row">      
                <div class="col-2 text-right">
                    <input type="checkbox" class="form-check-input" name="validar_campos_conductor[]" id="con_foto" value="con_foto" />
                    <label for="con_foto" class="form-check-label font-weight-bold">Foto</label>
                </div>
                <div class="col-2">
                    <div class="cont-img">
                        <img src="{{ (isset($conductor->con_foto) && !empty($conductor->con_foto) ? Storage::url($conductor->con_foto) : '/imgs/theme/no-image.png' ) }}" />
                    </div>
                </div>
            </div>
            <div class="form-group row">
                @foreach ($documentacionConductor as $docCond)
                    <div class="col-2 text-right">
                        <input type="checkbox" class="form-check-input" name="validar_campos_conductor[]" id="doc_{{$docCond->doc_fk_tdo}}" value="{{$docCond->doc_id}}" />
                        <label for="doc_{{$docCond->doc_fk_tdo}}" class="form-check-label font-weight-bold">{{$docCond->tdo_name}}</label>
                    </div>
                    <div class="col-2">
                        <div class="cont-img">
                            <img src="{{ (isset($docCond->doc_ruta) && !empty($docCond->doc_ruta) ? Storage::url($docCond->doc_ruta) : '/imgs/theme/no-image.png' ) }}" />
                        </div>
                    </div>
                @endforeach
            </div>
            
            <h3>Datos propietario</h3>    
            @if ($propietario->pro_documento == $conductor->con_documento)
                <p>El conductor es el propietario</p>
            @else
                <div class="form-group row align-items-center">
                    <div class="col-2 text-right">
                        <input type="checkbox" class="form-check-input" name="validar_campos_conductor[]" id="pro_documento" value="pro_documento" />
                        <label for="pro_documento" class="form-check-label font-weight-bold">Documento</label>
                    </div>
                    <div class="col-2">
                        <input type="text" value="{{$propietario->pro_documento}}" data-name="pro_documento" class="form-control" readonly/>
                    </div>
                    <div class="col-2 text-right">
                        <input type="checkbox" class="form-check-input"  name="validar_campos_conductor[]" id="pro_nombres" value="pro_nombres" />
                        <label for="pro_nombres" class="form-check-label font-weight-bold">Nombres</label>
                    </div>
                    <div class="col-2">
                        <input type="text" value="{{$propietario->pro_nombres}}" data-name="pro_nombres" class="form-control" readonly/>
                    </div>
                    <div class="col-2 text-right">
                        <input type="checkbox" class="form-check-input"  name="validar_campos_conductor[]" id="pro_apellidos" value="pro_apellidos" />
                        <label for="pro_apellidos" class="form-check-label font-weight-bold">Apellidos</label>
                    </div>
                    <div class="col-2">
                        <input type="text" value="{{$propietario->pro_apellidos}}" data-name="pro_apellidos" class="form-control" readonly/>
                    </div>                    
                </div>
                <div class="form-group row align-items-center">
                    <div class="col-2 text-right">
                        <input type="checkbox" class="form-check-input"  name="validar_campos_conductor[]" id="pro_email" value="pro_email" />
                        <label for="pro_email" class="form-check-label font-weight-bold">Email</label>
                    </div>
                    <div class="col-2">
                        <input type="text" value="{{$propietario->pro_email}}" data-name="pro_email" class="form-control" readonly/>
                    </div>
                </div>
                <div class="form-group row">
                    @foreach ($documentacionPropietario as $docProp)
                        <div class="col-2 text-right">
                            <input type="checkbox" class="form-check-input" name="validar_campos_conductor[]" id="doc_{{$docProp->doc_fk_tdo}}" value="{{$docProp->doc_id}}" />
                            <label for="doc_{{$docProp->doc_fk_tdo}}" class="form-check-label font-weight-bold">{{$docProp->tdo_name}}</label>
                        </div>
                        <div class="col-2">
                            <div class="cont-img">
                                <img src="{{ (isset($docProp->doc_ruta) && !empty($docProp->doc_ruta) ? Storage::url($docProp->doc_ruta) : '/imgs/theme/no-image.png' ) }}" />
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <h3>Datos vehiculo</h3>
            <div class="form-group row align-items-center">
                <div class="col-2 text-right">
                    <input type="checkbox" class="form-check-input" name="validar_campos_conductor[]" id="veh_placa" value="veh_placa" />
                    <label for="veh_placa" class="form-check-label font-weight-bold">Placa</label>
                </div>
                <div class="col-2">
                    <input type="text" value="{{$vehiculo->veh_placa}}" data-name="veh_placa" class="form-control" readonly/>
                </div>
                <div class="col-2 text-right">
                    <input type="checkbox" class="form-check-input"  name="validar_campos_conductor[]" id="veh_fk_col" value="veh_fk_col" />
                    <label for="veh_fk_col" class="form-check-label font-weight-bold">Color</label>
                </div>
                <div class="col-2">
                    <input type="text" value="{{$vehiculo->col_name}}" data-name="veh_fk_col" class="form-control" readonly/>
                </div>
                <div class="col-2 text-right">
                    <input type="checkbox" class="form-check-input"  name="validar_campos_conductor[]" id="veh_fk_mar" value="veh_fk_mar" />
                    <label for="veh_fk_mar" class="form-check-label font-weight-bold">Marca</label>
                </div>
                <div class="col-2">
                    <input type="text" value="{{$vehiculo->mar_name}}" data-name="veh_fk_mar" class="form-control" readonly/>
                </div>                    
            </div>
            <div class="form-group row align-items-center">
                <div class="col-2 text-right">
                    <input type="checkbox" class="form-check-input"  name="validar_campos_conductor[]" id="veh_tip" value="veh_tip" />
                    <label for="veh_tip" class="form-check-label font-weight-bold">Tipo</label>
                </div>
                <div class="col-2">
                    <input type="text" value="{{$vehiculo->tip_name}}" data-name="veh_tip" class="form-control" readonly/>
                </div>
                <div class="col-2 text-right">
                    <input type="checkbox" class="form-check-input" name="validar_campos_conductor[]" id="veh_dim" value="veh_dim" />
                    <label for="veh_dim" class="form-check-label font-weight-bold">Dimensi&oacute;n</label>
                </div>
                <div class="col-2">
                    <input type="text" value="{{$vehiculo->dim_name}}" data-name="veh_dim" class="form-control" readonly/>
                </div>
                <div class="col-2 text-right">
                    <input type="checkbox" class="form-check-input" name="validar_campos_conductor[]" id="veh_rendimiento" value="veh_rendimiento" />
                    <label for="veh_rendimiento" class="form-check-label font-weight-bold">Rendimiento por gal&oacute;n</label>
                </div>
                <div class="col-2">
                    <input type="text" value="{{$vehiculo->veh_rendimiento}}" data-name="veh_rendimiento" class="form-control" readonly/>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <div class="col-2 text-right">
                    <input type="checkbox" class="form-check-input" name="validar_campos_conductor[]" id="veh_foto" value="veh_foto" />
                    <label for="veh_foto" class="form-check-label font-weight-bold">Foto</label>
                </div>
                <div class="col-2">
                    <div class="cont-img">
                        <img src="{{ (isset($vehiculo->veh_foto) && !empty($vehiculo->veh_foto) ? Storage::url($vehiculo->veh_foto) : '/imgs/theme/no-image.png' ) }}" />
                    </div>
                </div>
            </div>
            <div class="form-group row">
                @foreach ($documentacionVehiculo as $docVeh)
                    <div class="col-2 text-right">
                        <input type="checkbox" class="form-check-input" name="validar_campos_conductor[]" id="doc_{{$docVeh->doc_fk_tdo}}" value="{{$docVeh->doc_id}}" />
                        <label for="doc_{{$docVeh->doc_fk_tdo}}" class="form-check-label font-weight-bold">{{$docVeh->tdo_name}}</label>
                    </div>
                    <div class="col-2">
                        <div class="cont-img">
                            <img src="{{ (isset($docVeh->doc_ruta) && !empty($docVeh->doc_ruta) ? Storage::url($docVeh->doc_ruta) : '/imgs/theme/no-image.png' ) }}" />
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="form-group mensaje-adicional">
                <h3>Mensaje adicional</h3>
                <textarea class="form-control" rows="3" name="mensaje_adicional" id="mensaje_adicional"></textarea>  
            </div>
            <div class="form-group row mt-5 mb-3">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-success aprobar">Aprobar documentación</button>                
                    <button type="submit" class="btn btn-danger rechazar oculto">Rechazar documentación</button>
                </div>
            </div>
        </form>
        @else
            <h5>El conductor se encuentra registrando los datos</h5>
        @endisset
    </div>
</div>
<div class="modal fade modal-image" tabindex="-1" role="dialog" aria-labelledby="modal-image" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img id="modal-image" />
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ URL::asset('js/conductores/forms.js') }}"></script>
@endsection
