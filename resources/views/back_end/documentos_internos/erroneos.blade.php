@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Documentos Erroneos
@endsection

@section('contentheader_title')
    Documentos Erroneos
@endsection

@section('contentheader_description')
    - Reportados por Usuario
@endsection

@section('main-content')


    <div class="col-sm-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#inicio" data-toggle="tab" aria-expanded="true"><i class="fa fa-home"></i>
                        <strong>Inicio</strong></a></li>
                <li class=""><a href="#pendientes" data-toggle="tab" aria-expanded="false"><i
                            class="fa fa-recycle"></i>
                        <strong>Pendientes</strong></a></li>
                <li class=""><a href="#corregidos" data-toggle="tab" aria-expanded="false"><i
                            class="fa fa-check"></i>
                        <strong>Corregidos</strong></a></li>
            </ul>

            <div class="tab-content">

                <div id="inicio" class="tab-pane active">

                </div>

                <div class="tab-pane" id="pendientes">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Grilla de Documentos Pendientes de Corrección</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="GrillaPrincipal" class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>Tipo / Folio / Año</th>
                                                <th>Fecha / Hora del Reporte</th>
                                                <th>Usuario que Reporta</th>
                                                <th>Tipo de Error</th>
                                                <th>Acciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($grilla_pendientes as $listado)
                                                <tr>
                                                    <td>{{ $listado -> foliocompdocint   }}</td>
                                                    <td>{{date('d-m-Y / H:i:s',strtotime($listado -> fecreperrint))}}</td>
                                                    <td>{{ $listado -> paternofunc }} {{ $listado -> maternofunc }}
                                                        , {{ $listado -> nombresfunc }}</td>
                                                    <td>{{ $listado -> tipoerror}}</td>
                                                    <td>
                                                        <center>
                                                            <form action="/FichaErrorDocInt" method="POST">
                                                                <input type="hidden" name="_token"
                                                                       value="{{ csrf_token() }}">
                                                                <input type="hidden" name="id_error" value="{{ $listado -> iderrdocint}}">
                                                                <input type="hidden" name="id_doc_erroneo"
                                                                       value="{{ $listado->op_documentos_internos_iddocint }}">
                                                                <button class="btn btn-xs btn-danger" type="submit">
                                                                    <i class="fa fa-edit"></i> CORREGIR DOCUMENTO
                                                                </button>
                                                            </form>
                                                        </center>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="tab-pane" id="corregidos">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Grilla de Documentos Corregidos</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="GrillaPrincipal2" class="table table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th>Folio / Tipo</th>
                                                <th>Fecha del Reporte</th>
                                                <th>Usuario que Reporta</th>
                                                <th>Tipo de Error</th>
                                                <th>Fecha de la Corrección</th>
                                                <th>Corrigió</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($grilla_corregidos as $listado)
                                                <tr>
                                                    <td>{{ $listado -> foliocompdocint   }}</td>
                                                    <td>{{date('d-m-Y / H:i:s',strtotime($listado -> fecreperrint))}}</td>
                                                    <td>{{ $listado -> paternofunc }} {{ $listado -> maternofunc }}
                                                        , {{ $listado -> nombresfunc }}</td>
                                                    <td>{{ $listado -> tipoerror}}</td>
                                                    <td>{{date('d-m-Y / H:i:s',strtotime($listado -> feccorrerrint))}}</td>
                                                    <td>{{ $listado->name }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection
