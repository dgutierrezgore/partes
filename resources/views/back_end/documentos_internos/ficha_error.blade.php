@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Ficha Documentos Erroneos
@endsection

@section('contentheader_title')
    Ficha de Reparación
@endsection

@section('contentheader_description')
    - Digitalización de Documentos
@endsection

@section('main-content')
    <div class="col-sm-12">
        <div id="resp">

        </div>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#inicio" data-toggle="tab" aria-expanded="true"><i class="fa fa-info"></i>
                        <strong>Resumen</strong></a></li>
                <li class=""><a href="#res_ex" data-toggle="tab" aria-expanded="false"><i class="fa fa-edit"></i>
                        <strong> Campos Editables del Documento</strong></a></li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane active" id="inicio">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <i class="fa fa-warning"></i><strong> Alerta, leer antes de proceder.</strong>
                        </div>
                        <div class="panel-body">
                            Antes de modificar el documento verifique que efectivamente el documento se encuentre
                            incorrecto en el sistema de digitalización.
                            <br><br>
                            Recuerde que <strong>toda acción</strong> sobre el documento quedará registrada en la
                            bitácora de éste. <br><br>
                            Finalmente, si no es posible corregir el documento a través del formulario, debe contactar
                            al administrador del sistema.
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="res_ex">

                    <center><h4>Tipo de documento: <strong>{{ $info->tipodocint }}</strong></h4></center>

                    <form class='form-horizontal' action="/GuardarDocCorreg" method="POST"
                          enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="iddocint" value="{{ $info->iddocint }}">
                        <input type="hidden" name="idferror" value="{{ $error}}">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Fecha</label>
                                <div class="col-sm-2">
                                    <input type="date" class="form-control" id="fecdocint" name="fecdocint"
                                           value="{{ $info->fechadocint }}" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Folio</label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control" value="{{ $info->foliodocint }}"
                                           id="foliodocint"
                                           name="foliodocint" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-1 control-label">Año</label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control" min="0" id="anniodocint"
                                           value="{{ date('Y') }}" name="anniodocint" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Materia</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="matbitdocint" name="matbitdocint" rows="2"
                                              required
                                              onkeyup="eventos_materias(this)">{{ $info->matdocint }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Documento Digital</label>
                                <div class="col-sm-8">
                                    <input type="file" name="arcdocint" id="arcdocint" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Observaciones</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control" id="ingobsdocint" name="ingobsdocint" rows="2"
                                              onkeyup="eventos_obs(this)">{{ $info->obsdocint }}</textarea>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Referencia Documento
                                    Anterior</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="ingrefdocint" name="ingrefdocint"
                                           value="{{ $info->refdocint }}"
                                           onkeyup="eventos_ref(this)">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="reset" class="btn btn-default"><i class="fa fa-eraser"></i> Limpiar Formulario
                            </button>
                            <button type="submit" id="btn-res-ex" class="btn btn-primary pull-right"><i
                                    class="fa fa-save"></i> Corregir
                                Documento
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection()
