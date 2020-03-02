@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Ficha de Documentos Internos
@endsection

@section('contentheader_title')
    Ficha Documentación Interna
@endsection

@section('contentheader_description')
    - Detalle
@endsection

@section('main-content')

    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="box box-info">
                <div class="box-body box-profile">
                    <h4 class="profile-username text-center"><i
                            class="fa fa-clipboard"></i> {{ $bitacora[0]->tipodocint }}</h4>

                    <p class="text-muted text-center"><?php echo wordwrap($bitacora[0]->matdocint, 45, '<br>', true) ?></p>


                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Número # / Año</b>
                            <p class="pull-right"><strong>{{ $bitacora[0]->foliocompdocint }}</strong></p>
                        </li>
                        @if($bitacora[0]->iddocsint==1)
                            <li class="list-group-item">
                                <b>Funcionario</b>
                                <p class="pull-right">
                                    <small>{{ $bitacora[0]->paternofunc }} {{ $bitacora[0]->maternofunc }}
                                        ,{{ $bitacora[0]->nombresfunc }} </small></p>
                            </li>
                        @endif
                        <li class="list-group-item">
                            <b>Privacidad del Documento</b>
                            @if($bitacora[0]->segdocint == 1)
                                <span class='badge bg-red'><i class='fa fa-close'></i> No, Sólo Distribución</span>
                            @elseif($bitacora[0]->segdocint == 2)
                                <span class='badge bg-primary'><i class='fa fa-lock'></i> No, Uso Restringido</span>
                            @elseif($bitacora[0]->segdocint == 3)
                                <span class='badge bg-yellow'><i
                                        class='fa fa-building'></i> No, Uso Interno Partes</span>
                            @elseif($bitacora[0]->segdocint == 4)
                                <span class='badge bg-green'><i class='fa fa-check-circle'></i> Si, Público en Buscador</span>
                            @endif
                        </li>
                        <li class="list-group-item">
                            <b>Cargado Por</b>
                            <small><p class="pull-right">{{$bitacora[0]->name}}</p></small>
                        </li>
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h4 class="box-title"><i class="fa fa-random"></i> Distribución</h4>
                </div>
                <!-- /.box-header -->
                <div class="box-body">

                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">
                            <b>Interna:</b>
                            @foreach($dis_int as $listado)
                                <small>
                                    <ul>
                                        <li>
                                            <strong>{{ $listado->nomgrpdisint }}</strong>
                                        </li>
                                    </ul>
                                </small>
                            @endforeach
                        </li>
                        @if($bitacora[0]->iddocsint==1)
                            <li class="list-group-item">
                                <b>Externa:</b>
                                @foreach($dis_ext as $listado)
                                    <small>
                                        <ul>
                                            <li>
                                                <strong>{{ $listado->tiposervdisext }} {{ $listado->nomgrpdisext }}</strong>
                                            </li>
                                        </ul>
                                    </small>
                                @endforeach
                            </li>
                        @elseif($bitacora[0]->iddocsint==3)
                            <li class="list-group-item">
                                <b>Externa:</b>
                                @foreach($dis_ext as $listado)
                                    <small>
                                        <ul>
                                            <li>
                                                <strong>{{ $listado->tiposervdisext }} {{ $listado->nomgrpdisext }}</strong>
                                            </li>
                                        </ul>
                                    </small>
                                @endforeach
                            </li>
                        @elseif($bitacora[0]->iddocsint==2)
                            <li class="list-group-item">
                                <b>Externa:</b>

                                <small>
                                    <ul>
                                        <li>
                                            <strong>CONTRALORÍA REGIONAL</strong>
                                        </li>
                                    </ul>
                                </small>

                            </li>
                        @endif
                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- About Me Box -->
            @if($bitacora[0]->iddocsint==2)
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h4 class="box-title"><i class="fa fa-info-circle"></i> Seguimiento Contraloría Regional</h4>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                @if($bitacora[0]->feccgrdocint<>null)
                                    <button class="btn btn-xs btn-success" data-toggle="modal"
                                            data-target="#modal-ec" disabled><i class="fa fa-edit"></i></button>
                                @else
                                    <button class="btn btn-xs btn-success" data-toggle="modal"
                                            data-target="#modal-ec"><i class="fa fa-edit"></i></button>
                                @endif
                                <b>Envío Contraloría</b>
                                @if($bitacora[0] -> feccgrdocint==null)
                                    <p class="pull-right">
                                        <strong> NO TRAMITADO</strong></p>
                                @else
                                    <p class="pull-right">
                                        <strong> {{ date('d-m-Y',strtotime($bitacora[0] -> feccgrdocint)) }}
                                            a las {{ date('H:i:s',strtotime($bitacora[0] -> horacgrdocint)) }}</strong>
                                    </p>
                                @endif

                            </li>
                            <li class="list-group-item">
                                @if($bitacora[0]->respcgrdocint<>null)
                                    <button class="btn btn-xs btn-success" data-toggle="modal"
                                            data-target="#modal-rc" disabled><i class="fa fa-edit"></i></button>
                                    <b>Estado Recepción</b>
                                @else
                                    <button class="btn btn-xs btn-success" data-toggle="modal"
                                            data-target="#modal-rc"><i class="fa fa-edit"></i></button>
                                    <b>Estado Recepción</b>

                                    <p class="pull-right">
                                        <strong> NO TRAMITADO</strong></p>
                                @endif

                                @if($bitacora[0]->respcgrdocint==1)
                                    <span class='badge bg-green'><i
                                            class='fa fa-check-circle'></i> CON TOMA DE RAZÓN</span>
                                @elseif($bitacora[0]->respcgrdocint==2)
                                    <span class='badge bg-yellow'><i class='fa fa-info'></i> CURSA CON ALCANCE</span>
                                @elseif($bitacora[0]->respcgrdocint==3)
                                    <span class='badge bg-red'><i class='fa fa-warning'></i> REPRESENTADA</span>
                                @elseif($bitacora[0]->respcgrdocint==4)
                                    <span class='badge bg-yellow'><i class='fa fa-info-circle'></i> SE ABTIENE</span>
                                @endif
                            </li>
                            <li class="list-group-item">
                                <b>Fecha Recepción</b>
                                @if($bitacora[0] -> fecreccgrdocint==null)
                                    <p class="pull-right">
                                        <strong> NO TRAMITADO</strong></p>
                                @else
                                    <p class="pull-right">
                                        <strong> {{ date('d-m-Y',strtotime($bitacora[0] -> fecreccgrdocint)) }}
                                            a
                                            las {{ date('H:i:s',strtotime($bitacora[0] -> horareccgrdocint)) }}</strong>
                                    </p>
                                @endif
                            </li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
        @endif
        <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div id="resp">

            </div>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#doc" data-toggle="tab"><i class="fa fa-file-pdf-o"></i> Documento</a>
                    </li>
                    <li><a href="#envio_electronico" data-toggle="tab"><i class="fa fa-send-o"></i> Envío
                            Electrónico</a></li>
                    <li><a href="#anotaciones" data-toggle="tab"><i class="fa fa-pencil"></i> Anotar Observaciones</a>
                    </li>
                    <li><a href="#lecturas" data-toggle="tab"><i class="fa fa-server"></i> Revisar Entregas</a>
                    </li>
                    <li><a href="#bitacora" data-toggle="tab"><i class="fa fa-history"></i> Bitácora Documento</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="doc">

                        <iframe name="iframe"
                                src="http://localhost:8000/StoragePartes/{{ $pdf->urldocint }}#toolbar=0&navpanes=0&scrollbar=0&zoom=75"
                                width="100%" height="600px" type="application/pdf">
                        </iframe>

                    </div>
                    <div class="tab-pane" id="envio_electronico">
                        <form class="form-horizontal" id="formulario">
                            <div class="box-body">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="iddocint" value="{{ $bitacora[0]->iddocint }}">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Funcionario
                                        Solicitante</label>
                                    <div class="col-sm-10">
                                        <select name="nomfuncpdocint" class="form-control">
                                            @foreach($funcionarios as $listado)
                                                <option
                                                    value="{{ $listado->idfunc }}|{{ $listado->paternofunc }} {{ $listado->maternofunc }}
                                                        , {{ $listado->nombresfunc }}">{{ $listado->paternofunc }} {{ $listado->maternofunc }}
                                                    , {{ $listado->nombresfunc }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Observaciones
                                        Solicitud</label>
                                    <div class="col-sm-10">
                                        <textarea rows="5" id="obssolint" name="obssolint" class="form-control" required
                                                  placeholder="Nota: Las observaciones serán públicas en la bitácora"
                                                  onkeyup="eventos_obs_sol(this);"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Forma de
                                        Solicitud</label>
                                    <div class="radio col-sm-2">
                                        <label>
                                            <input type="radio" name="forsolint" id="optionsRadios2" value="1"
                                                   checked="">
                                            <i class="fa fa-envelope"></i> Correo Electrónico
                                        </label>
                                    </div>
                                    <div class="radio col-sm-2">
                                        <label>
                                            <input type="radio" name="forsolint" id="optionsRadios2" value="2">
                                            <i class="fa fa-file"></i> Memorandum
                                        </label>
                                    </div>
                                    <div class="radio col-sm-2">
                                        <label>
                                            <input type="radio" name="forsolint" id="optionsRadios2" value="3">
                                            <i class="fa fa-bullhorn"></i> En Persona
                                        </label>
                                    </div>
                                    <div class="radio col-sm-2">
                                        <label>
                                            <input type="radio" name="forsolint" id="optionsRadios2" value="4">
                                            <i class="fa fa-info-circle"></i> Otra
                                        </label>
                                    </div>
                                    <div class="radio col-sm-2">
                                        <label>
                                            <input type="radio" name="forsolint" id="optionsRadios1" value="5">
                                            <i class="fa fa-shield"></i> Reservada
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Referencia
                                        Solicitud</label>
                                    <div class="col-sm-10">
                                        <textarea rows="2" class="form-control" id="refsolint" name="refsolint"
                                                  placeholder="Nota: Estas referencias no serán públicas"
                                                  onkeyup="eventos_obs_ref(this);"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="button" id="btn-ingresar" class="btn btn-success pull-right"><i
                                        class="fa fa-send-o"></i>
                                    Enviar vía Sistema
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane" id="anotaciones">
                        <form class="form-horizontal" id="form_anotaciones">
                            <div class="box-body">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="iddocint" value="{{ $bitacora[0]->iddocint }}">
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Observaciones
                                        al Documento</label>
                                    <div class="col-sm-10">
                                        <textarea rows="5" id="obsbitdocint" name="obsbitdocint" class="form-control"
                                                  required
                                                  placeholder="Nota: Las observaciones podrán ser públicas en la bitácora"
                                                  onkeyup="eventos_obs(this);"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Tipo de
                                        Observación</label>
                                    <div class="radio col-sm-2">
                                        <label>
                                            <input type="radio" name="segobsintdocint" value="1"
                                                   checked="">
                                            <i class="fa fa-unlock"></i> Pública
                                        </label>
                                    </div>
                                    <div class="radio col-sm-2">
                                        <label>
                                            <input type="radio" name="segobsintdocint" value="0">
                                            <i class="fa fa-lock"></i> Privada
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="button" id="btn_ing_obs" class="btn btn-success pull-right"><i
                                        class="fa fa-pencil"></i>
                                    Agregar Observaciones
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane" id="lecturas">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Distribución del Documento y Revisiones por Funcionario</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body no-padding">
                                <table class="table table-condensed">
                                    <tbody>
                                    <tr>
                                        <th>
                                            Funcionario
                                        </th>
                                        <th>
                                            <center>Distribución</center>
                                        </th>
                                        <th>
                                            <center>Lectura</center>
                                        </th>
                                        <th>
                                            <center>Fecha / Hora</center>
                                        </th>
                                        <th>
                                            <center>Estado General</center>
                                        </th>
                                        <th>
                                            <center>Estado Funcionario</center>
                                        </th>
                                    </tr>
                                    @foreach($entregas as $listado)
                                        <tr>
                                            <td>{{ $listado->paternofunc }}, {{ $listado->nombresfunc }}</td>
                                            <td>
                                                <center>
                                                    @if($listado->disdocintfunc == 1)
                                                        <span class="label label-primary">Principal</span>
                                                    @elseif($listado->disdocintfunc == 2)
                                                        <span class="label label-success">En Distribución</span>
                                                    @elseif($listado->disdocintfunc == 3)
                                                        <span class="label label-warning">Copia Posterior</span>
                                                    @endif
                                                </center>
                                            </td>
                                            <td>@if($listado->lectfuncdocint == 0)
                                                    <center>NO</center>
                                                @elseif($listado->lectfuncdocint == 1)
                                                    <center>SI</center>
                                                @endif</td>
                                            <td>
                                                <center>
                                                    @if($listado->lectfuncdocint == 0)
                                                        <center>-</center>
                                                    @else
                                                        {{date('d-m-Y / H:i:s',strtotime($listado -> prilecfundocint))}}
                                                    @endif
                                                </center>
                                            </td>
                                            <td>@if($listado->estadolectdocint == 0)
                                                    <center>
                                                        <form action="/BloquearEntrega" method="POST">
                                                            <input type="hidden" name="_token"
                                                                   value="{{ csrf_token() }}">
                                                            <input type="hidden" name="tipo_bloqueo" value="1">
                                                            <input type="hidden" name="id_reg_hab"
                                                                   value="{{ $listado->idlecdocint }}">
                                                            <button class="btn btn-xs btn-success" type="submit">
                                                                <i class="fa fa-check"></i> HABILITAR
                                                            </button>
                                                        </form>
                                                    </center>
                                                @elseif($listado->estadolectdocint == 1)
                                                    <center>
                                                        <form action="/BloquearEntrega" method="POST">
                                                            <input type="hidden" name="_token"
                                                                   value="{{ csrf_token() }}">
                                                            <input type="hidden" name="tipo_bloqueo" value="0">
                                                            <input type="hidden" name="id_reg_hab"
                                                                   value="{{ $listado->idlecdocint }}">
                                                            <button class="btn btn-xs btn-danger" type="submit">
                                                                <i class="fa fa-eye-slash"></i> BLOQUEAR
                                                            </button>
                                                        </form>
                                                    </center>
                                                @endif</td>
                                            <td>@if($listado->estadofucdocint == null)
                                                    <center>EN BANDEJA</center>
                                                @elseif($listado->estadolectdocint == 0)
                                                    <center>ARCHIVADO POR USUARIO</center>
                                                @endif</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>

                    <div class="tab-pane" id="bitacora">

                        <ul class="timeline timeline-inverse">
                            @foreach($bitacora as $listado)
                                @if($listado->tipoaccbitdocint==1)
                                    <li class="time-label">
                        <span class="bg-green">
                          {{date('d - m - Y',strtotime($listado -> fecbitdocint))}}
                        </span>
                                    </li>
                                    <li>
                                        <i class="fa fa-check-circle bg-green"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i> {{$listado->horabitdocint}}</span>

                                            <h3 class="timeline-header"> {{$listado->accbitdocint}}</h3>

                                            <div class="timeline-body">
                                                <strong>Materia:</strong> {{ $listado -> matdocint }} <br>
                                                <strong>Observaciones:</strong> {{$listado -> obsdocint }}<br>
                                                <strong>Referencia:</strong> {{ $listado -> refdocint }} <br>
                                            </div>
                                        </div>
                                    </li>
                                    <!-- END timeline item -->
                                    <li>
                                        <i class="fa fa-clock-o bg-gray"></i>
                                    </li>
                                @elseif($listado->tipoaccbitdocint==2)
                                    <li class="time-label">
                        <span class="bg-yellow">
                          {{date('d - m - Y',strtotime($listado -> fecbitdocint))}}
                        </span>
                                    </li>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <li>
                                        <i class="fa fa-send-o bg-yellow"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i> {{ $listado -> horabitdocint }}</span>

                                            <h3 class="timeline-header">Copia del documento solicitada vía:
                                                @if($listado->forsoldocint==1)
                                                    <strong>CORREO ELECTRÓNICO</strong>
                                                @elseif($listado->forsoldocint==2)
                                                    <strong>MEMORANDUM</strong>
                                                @elseif($listado->forsoldocint==3)
                                                    <strong>EN PERSONA</strong>
                                                @elseif($listado->forsoldocint==4)
                                                    <strong>OTRA</strong>
                                                @elseif($listado->forsoldocint==5)
                                                    <strong>RESERVADA</strong>
                                                @endif
                                                - y enviada a:
                                                <strong>{{ $listado-> cpbitdocint }}</strong></h3>
                                            <div class="timeline-body">
                                                <strong>Observaciones:</strong> {{ $listado-> obsenvficdocint}}
                                                <br><br>
                                                <strong>Obs: Internas de Of.
                                                    Partes:</strong> {{ $listado->refsolenvdocint }}
                                            </div>
                                        </div>
                                    </li>
                                @elseif($listado->tipoaccbitdocint==3)
                                    <li class="time-label">
                        <span class="bg-aqua">
                         {{date('d - m - Y',strtotime($listado -> fecbitdocint))}}
                        </span>
                                    </li>
                                    <li>
                                        <i class="fa fa-envelope-o bg-aqua"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i> {{ $listado -> horabitdocint }}</span>

                                            <h3 class="timeline-header"><strong>{{$listado->accbitdocint}} -
                                                    El {{ date('d-m-Y',strtotime($listado -> feccgrdocint)) }} a
                                                    las {{ date('H:i:s',strtotime($listado -> horacgrdocint)) }}</strong>
                                            </h3>
                                        </div>
                                    </li>
                                @elseif($listado->tipoaccbitdocint==4)
                                    <li class="time-label">
                        <span class="bg-blue">
                          {{date('d - m - Y',strtotime($listado -> fecbitdocint))}}
                        </span>
                                    </li>
                                    <li>
                                        <i class="fa fa-mail-forward bg-blue"></i>

                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i> {{ $listado -> horabitdocint }}</span>

                                            <h3 class="timeline-header">{{$listado->accbitdocint}}</h3>
                                            <div class="timeline-body"><strong>Respuesta de Contraloría: </strong></div>
                                            <div class="timeline-footer">
                                                @if($listado->respcgrdocint==1)
                                                    <a class="btn btn-primary btn-xs">Con Toma de Razón</a>
                                                @elseif($listado->respcgrdocint==2)
                                                    <a class="btn btn-warning btn-xs">Cursa con Alcance</a>
                                                @elseif($listado->respcgrdocint==3)
                                                    <a class="btn btn-danger btn-xs">Representada</a>
                                                @elseif($listado->respcgrdocint==4)
                                                    <a class="btn btn-danger btn-xs">Se Abtiene</a>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @elseif($listado->tipoaccbitdocint==5)
                                    <li class="time-label">
                        <span class="bg-black">
                          {{date('d - m - Y',strtotime($listado -> fecbitdocint))}}
                        </span>
                                    </li>
                                    <li>
                                        <i class="fa fa-pencil bg-black"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fa fa-clock-o"></i> {{ date('H:i:s',strtotime($listado -> horabitdocint)) }}</span>
                                            <h3 class="timeline-header">Observaciones Anotadas a Posterior</h3>
                                            @if($listado->segobspostint==0)
                                                <div class="timeline-body"><small><strong>Observaciones:</strong>
                                                        <p style="color:#FF0000" ;>ESTA OBSERVACIÓN FUE DECLARADA COMO
                                                            PRIVADA.</p></small>
                                                </div>
                                            @elseif($listado->segobspostint==1)
                                                <div class="timeline-body">
                                                    <strong>
                                                        <small>Observaciones:
                                                    </strong>
                                                    {{ $listado-> obspostdocint}}</small></div>
                                            @endif
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
    </div>

    <div class="modal fade" id="modal-ec">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Formulario de Ingreso a Contraloría</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body no-padding">
                        <div class="modal-content" id="resp_modal">

                        </div>
                        <form class="form-horizontal" id="form_envio_cgr">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Envio a CGR</label>
                                    <div class="col-sm-10">
                                        <input type="datetime-local" id="fechoraingcgr" name="fechoraingcgr"
                                               class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="iddocintresaf" value="{{ $bitacora[0]->iddocint }}">
                            <div class="box-footer">
                                <button type="reset" class="btn btn-default">Cancelar Envío</button>
                                <button type="button" id="btn_cgr_ing" class="btn btn-success pull-right"><i
                                        class="fa fa-send-o"></i>
                                    Confirmar envío del Documento
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="modal-rc">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Formulario de Recepción desde Contraloría</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body no-padding">
                        <div class="modal-content" id="resp_modal_2">

                        </div>
                        <form class="form-horizontal" id="form_recep_cgr">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">Recepción CGR</label>
                                    <div class="col-sm-9">
                                        <input type="datetime-local" id="reccgrdocint" name="reccgrdocint"
                                               class="form-control" required>
                                    </div>
                                </div>
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="iddocintresaf" value="{{ $bitacora[0]->iddocint }}">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">Estado</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="estcgrdocint" name="estcgrdocint">
                                            <option value="1">Con Toma de Razón</option>
                                            <option value="2">Cursa con Alcance</option>
                                            <option value="3">Representada</option>
                                            <option value="4">Se Abtiene</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="reset" class="btn btn-default">Cancelar Envío</button>
                                <button type="button" id="btn_cgr_egr" class="btn btn-success pull-right"><i
                                        class="fa fa-send-o"></i>
                                    Confirmar recepción del Documento
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <script src="https://code.jquery.com/jquery-1.11.3.js"></script>

    <script>
        $(document).on('ready', function () {
            $('#btn_ing_obs').click(function () {

                var url = "GuardarObsBit";

                if ($("#obsbitdocint").val() == "") {
                    $('#resp').html("" +
                        "<div class=\"alert alert-warning alert-dismissable\">\n" +
                        "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                        "<h4><i class=\"icon fa fa-warning\"></i> ¡ALERTA DE SISTEMA!</h4>" +
                        "Campo \"Observaciones al Documento\" es obligatorio.\n" +
                        "</div>");
                    $("#obsbitdocint").focus();
                    $("#obsbitdocint").css('border', '1px solid red');
                    return;
                }

                $.ajax({
                    type: "post",
                    url: url,
                    data: $("#form_anotaciones").serialize(),
                    success: function (data) {
                        if (data == 1) {
                            $('#resp').html("" +
                                "<div class=\"alert alert-success alert-dismissable\">\n" +
                                "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                                "<h4><i class=\"icon fa fa-check\"></i> ¡MENSAJE DE SISTEMA!</h4>" +
                                "Anotación registrada correctamente en la Bitácora del Documento.\n" +
                                "</div>");

                            location.reload();
                        }
                    },
                    error: function (data) {
                        alert(data);
                        alert('ERROR');
                    }
                });


            });
        });
    </script>

    <script>
        $(document).on('ready', function () {
            $('#btn_cgr_ing').click(function () {

                var url = "GuardarEnvCGR";

                if ($("#fechoraingcgr").val() == "") {
                    $('#resp_modal').html("" +
                        "<div class=\"alert alert-warning alert-dismissable\">\n" +
                        "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                        "<h4><i class=\"icon fa fa-info\"></i> Alerta de Sistema!</h4>" +
                        "Campo Envio a CGR es Obligatorio.\n" +
                        "</div>");

                    return;
                }

                $.ajax({
                    type: "post",
                    url: url,
                    data: $("#form_envio_cgr").serialize(),
                    success: function (data) {
                        if (data == 1) {
                            $('#resp_modal').html("" +
                                "<div class=\"alert alert-success alert-dismissable\">\n" +
                                "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                                "<h4><i class=\"icon fa fa-check\"></i> Mensaje de Sistema!</h4>" +
                                "Documento Enviado a Casilla Electrónica Funcionaria.\n" +
                                "</div>");
                            $("#fechoraingcgr").focus();
                            $("#fechoraingcgr").css('border', '1px solid red');
                            location.reload();
                        }
                    },
                    error: function (data) {
                        alert(data);
                        alert('ERROR');
                    }
                });


            });
        });
    </script>

    <script>
        $(document).on('ready', function () {
            $('#btn_cgr_egr').click(function () {

                var url = "GuardarRecCGR";

                if ($("#reccgrdocint").val() == "") {
                    $('#resp_modal_2').html("" +
                        "<div class=\"alert alert-warning alert-dismissable\">\n" +
                        "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                        "<h4><i class=\"icon fa fa-info\"></i> Alerta de Sistema!</h4>" +
                        "Campo Recepción CGR es Obligatorio.\n" +
                        "</div>");

                    return;
                }

                $.ajax({
                    type: "post",
                    url: url,
                    data: $("#form_recep_cgr").serialize(),
                    success: function (data) {
                        if (data == 1) {
                            $('#resp_modal_2').html("" +
                                "<div class=\"alert alert-success alert-dismissable\">\n" +
                                "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                                "<h4><i class=\"icon fa fa-check\"></i> Mensaje de Sistema!</h4>" +
                                "Documento Enviado a Casilla Electrónica Funcionaria.\n" +
                                "</div>");
                            location.reload();
                        }
                    },
                    error: function (data) {
                        alert(data);
                        alert('ERROR');
                    }
                });

            });
        });
    </script>

    <script>
        $(document).on('ready', function () {
            $('#btn-ingresar').click(function () {
                var url = "GuardarEnvInt";
                var validacion_ok = 0;

                if ($("#obssolint").val() == "") {
                    $('#resp').html("" +
                        "<div class=\"alert alert-warning alert-dismissable\">\n" +
                        "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                        "<h4><i class=\"icon fa fa-info\"></i> ¡ALERTA DE SISTEMA!</h4>" +
                        "Campo \"Observaciones Solicitud\" es obligatorio.\n" +
                        "</div>");
                    $("#obssolint").focus();
                    $("#obssolint").css('border', '1px solid red');
                    return;
                }

                if ($("#refsolint").val() == "") {
                    $('#resp').html("" +
                        "<div class=\"alert alert-warning alert-dismissable\">\n" +
                        "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                        "<h4><i class=\"icon fa fa-info\"></i> Alerta de Sistema!</h4>" +
                        "Campo \"Referencia Solicitud\" es obligatorio.\n" +
                        "</div>");
                    $("#refsolint").focus();
                    $("#refsolint").css('border', '1px solid red');
                    return;
                }

                $.ajax({
                    type: "post",
                    url: url,
                    data: $("#formulario").serialize(),
                    success: function (data) {
                        if (data == 1) {
                            $('#resp').html("" +
                                "<div class=\"alert alert-success alert-dismissable\">\n" +
                                "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                                "<h4><i class=\"icon fa fa-check\"></i> Mensaje de Sistema!</h4>" +
                                "Documento Enviado a Casilla Electrónica Funcionaria.\n" +
                                "</div>");
                            setTimeout(function () {
                                location.reload(true);
                            }, 3000);
                        }
                    },
                    error: function (data) {
                        alert('ERROR');
                    }
                });
            });
            return;
        });
    </script>

    <script>
        function eventos_obs(e) {
            $("#obsbitdocint").css('border', '2px solid green');
            var tecla = e.value;
            $("#obsbitdocint").val(tecla.toUpperCase());
            $('#resp').html("");
            return;
        }

        function eventos_obs_sol(e) {
            $("#obssolint").css('border', '2px solid green');
            var tecla = e.value;
            $("#obssolint").val(tecla.toUpperCase());
            $('#resp').html("");
            return;
        }

        function eventos_obs_ref(e) {
            $("#refsolint").css('border', '2px solid green');
            var tecla = e.value;
            $("#refsolint").val(tecla.toUpperCase());
            $('#resp').html("");
            return;
        }
    </script>
@endsection

