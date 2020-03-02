@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Carga de Documentos
@endsection

@section('contentheader_title')
    Documentación Interna
@endsection

@section('contentheader_description')
    - Formulario de Registro
@endsection

@section('main-content')

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @elseif(session('cuidado'))
        <div class="alert alert-warning">
            {{ session('cuidado') }}
        </div>
    @endif

    <div class="col-xs-3 ">
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $ult_res_ex-1 }}</h3>

                <p>Resoluciones Exentas</p>
            </div>
            <div class="icon">
                <i class="fa fa-file-pdf-o"></i>
            </div>
            <a type="button" class="small-box-footer" data-toggle="modal"
               data-target="#modal-res_ex">
                Listar 5 últimos <i class="fa fa-list-alt"></i>
            </a>
        </div>

        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $ult_res_af-1 }}</h3>

                <p>Resoluciones Afectas</p>
            </div>
            <div class="icon">
                <i class="fa fa-file-pdf-o"></i>
            </div>
            <a type="button" class="small-box-footer" data-toggle="modal"
               data-target="#modal-res_af">
                Listar 5 últimos <i class="fa fa-list-alt"></i>
            </a>
        </div>

        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $ult_circ-1 }}</h3>

                <p>Ordinarios</p>
            </div>
            <div class="icon">
                <i class="fa fa-file-pdf-o"></i>
            </div>
            <a type="button" class="small-box-footer" data-toggle="modal"
               data-target="#modal-ord">
                Listar 5 últimos <i class="fa fa-list-alt"></i>
            </a>
        </div>

    </div>

    <div class="col-sm-9">
        <div id="resp">

        </div>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#inicio" data-toggle="tab" aria-expanded="true"><i class="fa fa-info"></i>
                        <strong>Resumen</strong></a></li>
                <li class=""><a href="#res_ex" data-toggle="tab" aria-expanded="false"><i class="fa fa-paperclip"></i>
                        <strong>Resolución Exenta</strong></a></li>
                <li class=""><a href="#res_af" data-toggle="tab" aria-expanded="false"><i class="fa fa-paperclip"></i>
                        <strong>Resolución Afecta</strong></a></li>
                <li class=""><a href="#ordinarios" data-toggle="tab" aria-expanded="false"><i
                            class="fa fa-paperclip"></i> <strong>Ordinarios</strong></a></li>
            </ul>

            <div class="tab-content">

                <div class="tab-pane active" id="inicio">

                </div>

                <div class="tab-pane" id="res_ex">

                    <form class='form-horizontal' action="/GuardarNuevoDoc" method="POST" id='formulario_res_ex'
                          enctype="multipart/form-data">
                        <input type="hidden" name="tipodocint" value="1">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Fecha</label>
                                <div class="col-sm-2">
                                    <input type="date" class="form-control" id="fecdocint" name="fecdocint"
                                           onchange="eventos_fechas()" required>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Folio</label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control" value="{{ $ult_res_ex }}" id="foliodocint"
                                           name="foliodocint" min="{{ $ult_res_ex }}">
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
                                              onkeyup="eventos_materias(this)"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Funcionario Institución</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="funinvdocint">
                                        @foreach($funcionarios as $listado)
                                            <option
                                                value="{{$listado->idfunc}}">{{ $listado->paternofunc}} {{ $listado->maternofunc }}
                                                , {{ $listado->nombresfunc }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" id="" class="btn btn-primary"
                                            onclick=""><i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Grupo Dist. Interna</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="idgrupintdocint[]">
                                        @foreach($dis_int as $listado)
                                            <option
                                                value="{{ $listado-> idgrpdisint}}">{{ $listado->nomgrpdisint }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-2">
                                    <button type="button" id="agrega_d_int" class="btn btn-primary"
                                            onclick="agregar_d_int();"><i
                                            class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <div id="div_macro_1">
                                <div id="cuerpo_1">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Grupo Dist. Externa</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="idgrupextdocint[]">
                                        @foreach($dis_ex as $listado)
                                            <option
                                                value="{{ $listado-> idgrpdisext}}">{{ $listado->tiposervdisext }} {{ $listado->nomgrpdisext }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" id="agrega_d_ext" class="btn btn-primary"
                                            onclick="agregar_d_ext();"><i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <div id="div_macro_2">
                                <div id="cuerpo_2">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Documento Digital</label>
                                <div class="col-sm-8">
                                    <input type="file" name="arcdocint" id="arcdocint" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Publicación en Buscador</label>
                                <div class="radio col-sm-2">
                                    <label>
                                        <input type="radio" name="segdocint" value="1"
                                               checked="">
                                        <i class="fa fa-close"></i> No, Sólo Distribución
                                    </label>
                                </div>
                                <div class="radio col-sm-2">
                                    <label>
                                        <input type="radio" name="segdocint" value="2">
                                        <i class="fa fa-lock"></i> No, de uso Restringido
                                    </label>
                                </div>
                                <div class="radio col-sm-2">
                                    <label>
                                        <input type="radio" name="segdocint" value="3">
                                        <i class="fa fa-user"></i> No, Uso Interno Partes
                                    </label>
                                </div>
                                <div class="radio col-sm-2">
                                    <label>
                                        <input type="radio" name="segdocint" value="4">
                                        <i class="fa fa-users"></i> Si, Público en Buscador
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Observaciones</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control" id="ingobsdocint" name="ingobsdocint" rows="2"
                                              onkeyup="eventos_obs(this)"></textarea>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Referencia Documento
                                    Anterior</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="ingrefdocint" name="ingrefdocint"
                                           onkeyup="eventos_ref(this)">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="reset" class="btn btn-default"><i class="fa fa-eraser"></i> Limpiar Formulario
                            </button>
                            <button type="submit" id="btn-res-ex" class="btn btn-success pull-right"><i
                                    class="fa fa-save"></i> Guardar
                                Documento
                            </button>
                        </div>
                    </form>

                </div>

                <div class="tab-pane" id="res_af">
                    <form class='form-horizontal' action="/GuardarNuevoDoc" method="POST" id='formulario_res_af'
                          enctype="multipart/form-data">
                        <input type="hidden" name="tipodocint" value="2">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Fecha</label>
                                <div class="col-sm-2">
                                    <input type="date" class="form-control" id="fecdocint2" name="fecdocint"
                                           onchange="eventos_fechas2()" required>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Folio</label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control" value="{{ $ult_res_af }}" id="foliodocint"
                                           name="foliodocint" min="{{ $ult_res_af }}">
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
                                    <textarea class="form-control" id="matbitdocint2" name="matbitdocint" rows="2"
                                              required
                                              onkeyup="eventos_materias2(this)"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Grupo Dist. Interna</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="idgrupintdocint[]">
                                        @foreach($dis_int as $listado)
                                            <option
                                                value="{{ $listado-> idgrpdisint}}">{{ $listado->nomgrpdisint }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-2">
                                    <button type="button" id="agrega_d_int" class="btn btn-primary"
                                            onclick="agregar_d_int_afe();"><i
                                            class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <div id="div_macro_int_af">
                                <div id="cuerpo_int_af">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Documento Digital</label>
                                <div class="col-sm-8">
                                    <input type="file" name="arcdocintaf" id="arcdocintaf" required></div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Publicación en Buscador</label>
                                <div class="radio col-sm-2">
                                    <label>
                                        <input type="radio" name="segdocint" value="1"
                                               checked="">
                                        <i class="fa fa-close"></i> No, Sólo Distribución
                                    </label>
                                </div>
                                <div class="radio col-sm-2">
                                    <label>
                                        <input type="radio" name="segdocint" value="2">
                                        <i class="fa fa-lock"></i> No, de uso Restringido
                                    </label>
                                </div>
                                <div class="radio col-sm-2">
                                    <label>
                                        <input type="radio" name="segdocint" value="3">
                                        <i class="fa fa-user"></i> No, Uso Interno Partes
                                    </label>
                                </div>
                                <div class="radio col-sm-2">
                                    <label>
                                        <input type="radio" name="segdocint" value="4">
                                        <i class="fa fa-users"></i> Si, Público en Buscador
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Observaciones</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control" id="ingobsdocint2" name="ingobsdocint" rows="2"
                                              onkeyup="eventos_obs2(this)"></textarea>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Referencia Documento
                                    Anterior</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="ingrefdocint2" name="ingrefdocint"
                                           onkeyup="eventos_ref2(this)">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="reset" class="btn btn-default"><i class="fa fa-eraser"></i> Limpiar Formulario
                            </button>
                            <button type="submit" id="btn-res-af" class="btn btn-success pull-right"><i
                                    class="fa fa-save"></i> Guardar
                                Documento
                            </button>
                        </div>
                    </form>
                </div>

                <div class="tab-pane" id="ordinarios">
                    <form class='form-horizontal' action="/GuardarNuevoDoc" method="POST" id='formulario_ord'
                          enctype="multipart/form-data">
                        <input type="hidden" name="tipodocint" value="3">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Fecha</label>
                                <div class="col-sm-2">
                                    <input type="date" class="form-control" id="fecdocint3" name="fecdocint"
                                           onchange="eventos_fechas3()" required>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Folio</label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control" value="{{ $ult_circ }}" id="foliodocint"
                                           name="foliodocint" min="{{ $ult_circ }}">
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
                                    <textarea class="form-control" id="matbitdocint3" name="matbitdocint" rows="2"
                                              required
                                              onkeyup="eventos_materias3(this)"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Grupo Dist. Interna</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="idgrupintdocint[]">
                                        @foreach($dis_int as $listado)
                                            <option
                                                value="{{ $listado-> idgrpdisint}}">{{ $listado->nomgrpdisint }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-2">
                                    <button type="button" id="agrega_d_int" class="btn btn-primary"
                                            onclick="agregar_d_int_ord();"><i
                                            class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <div id="div_macro_1">
                                <div id="cuerpo_int_ord">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Grupo Dist. Externa</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="idgrupextdocint[]">
                                        @foreach($dis_ex as $listado)
                                            <option
                                                value="{{ $listado-> idgrpdisext}}">{{ $listado->tiposervdisext }} {{ $listado->nomgrpdisext }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" id="agrega_d_ext" class="btn btn-primary"
                                            onclick="agregar_d_ext_ord();"><i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>

                            <div id="div_macro_2">
                                <div id="cuerpo_ext_ord">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Documento Digital</label>
                                <div class="col-sm-8">
                                    <input type="file" name="arcdocintcir" id="arcdocintcir" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Publicación en Buscador</label>
                                <div class="radio col-sm-2">
                                    <label>
                                        <input type="radio" name="segdocint" value="1"
                                               checked="">
                                        <i class="fa fa-close"></i> No, Sólo Distribución
                                    </label>
                                </div>
                                <div class="radio col-sm-2">
                                    <label>
                                        <input type="radio" name="segdocint" value="2">
                                        <i class="fa fa-lock"></i> No, de uso Restringido
                                    </label>
                                </div>
                                <div class="radio col-sm-2">
                                    <label>
                                        <input type="radio" name="segdocint" value="3">
                                        <i class="fa fa-user"></i> No, Uso Interno Partes
                                    </label>
                                </div>
                                <div class="radio col-sm-2">
                                    <label>
                                        <input type="radio" name="segdocint" value="4">
                                        <i class="fa fa-users"></i> Si, Público en Buscador
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Observaciones</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control" id="ingobsdocint3" name="ingobsdocint" rows="2"
                                              onkeyup="eventos_obs3(this)"></textarea>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Referencia Documento
                                    Anterior</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" id="ingrefdocint3" name="ingrefdocint"
                                           onkeyup="eventos_ref3(this)">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="reset" class="btn btn-default"><i class="fa fa-eraser"></i> Limpiar Formulario
                            </button>
                            <button type="submit" id="btn-ordinarios" class="btn btn-success pull-right"><i
                                    class="fa fa-save"></i> Guardar
                                Documento
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div style="display: none;" id="div_distrib_int">
        <div id="div_select1">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label"><strong><i class="fa fa-plus"></i>
                        Adicional</strong></label>
                <div class="col-sm-8">
                    <select class="form-control" name="idgrupintdocint[]">
                        @foreach($dis_int as $listado)
                            <option
                                value="{{ $listado-> idgrpdisint}}">{{ $listado->nomgrpdisint }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-2">
                    <span type="button" class="btn btn-danger" rel="eliminar" id="eliminar"><i
                            class="fa  fa-close"></i></span>
                </div>

            </div>
        </div>
    </div>

    <div style="display: none;" id="div_distrib_ext">
        <div id="div_select2">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label"><strong><i class="fa fa-plus"></i>
                        Adicional</strong></label>
                <div class="col-sm-8">
                    <select class="form-control" name="idgrupextdocint[]">
                        @foreach($dis_ex as $listado)
                            <option
                                value="{{ $listado-> idgrpdisext}}">{{ $listado->tiposervdisext }} {{ $listado->nomgrpdisext }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-2">
                    <span type="button" class="btn btn-danger" rel="eliminar" id="eliminar"><i
                            class="fa  fa-close"></i></span>
                </div>

            </div>
        </div>
    </div>

    <script>
        function agregar_d_int_ord() {
            var agrega = $("#div_select1").html();
            $("#cuerpo_int_ord").append(agrega);
        }

        function agregar_d_ext_ord() {
            var agrega = $("#div_select2").html();
            $("#cuerpo_ext_ord").append(agrega);
        }

        function agregar_d_int() {
            var agrega = $("#div_select1").html();
            $("#cuerpo_1").append(agrega);
        }

        function agregar_d_ext() {
            var agrega = $("#div_select2").html();
            $("#cuerpo_2").append(agrega);
        }

        function agregar_d_int_afe() {
            var agrega = $("#div_select1").html();
            $("#cuerpo_int_af").append(agrega);
        }
    </script>

    <div class="modal fade" id="modal-res_ex">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Últimas Resoluciones Exentas</h4>
                </div>
                <div class="modal-body">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title"><i class="fa fa-list-alt"></i> Detalle de Documentos</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <table class="table table-condensed">
                                <tbody>
                                <tr>
                                    <th style="width: 10px"># Doc</th>
                                    <th>Materia</th>
                                    <th style="width: 10px">Ficha</th>
                                    <th style="width: 40px">Privacidad</th>
                                </tr>

                                <?php foreach ($res_ex_5 as $listado) {
                                    echo "<tr><td>";
                                    echo "<small>RES EX #" . $listado->foliodocint . "</small>";
                                    echo "</td>";

                                    echo "<td>";
                                    echo "<small>" . wordwrap($listado->matdocint, 45, '<br>', true) . "</small>";
                                    echo "</td>";

                                    echo "<td>";
                                    echo "<form action='/FichaDocsInt' method='POST'><input type='hidden' name='_token' value='" . csrf_token() . "'><input type='hidden' name='idficdocint' value='" . $listado->iddocint . "'><button class='btn btn-xs btn-success'><i class='fa fa-file-archive-o'></i></button></form>";
                                    echo "</td>";

                                    echo "<td>";
                                    if ($listado->segdocint == 1) {
                                        echo "<center>" . "<span class='badge bg-red'><i class='fa fa-close'></i> No, <br>Sólo Distribución</span>" . "</center>";
                                    } elseif ($listado->segdocint == 2) {
                                        echo "<center>" . "<span class='badge bg-primary'><i class='fa fa-lock'></i> No, <br>Uso Restringido</span>" . "</center>";
                                    } elseif ($listado->segdocint == 3) {
                                        echo "<center>" . "<span class='badge bg-yellow'><i class='fa fa-building'></i> No, <br>Uso Interno Partes</span>" . "</center>";
                                    } elseif ($listado->segdocint == 4) {
                                        echo "<center>" . "<span class='badge bg-green'><i class='fa fa-check-circle'></i> Si, <br> Público en Buscador</span>" . "</center>";
                                    }
                                    echo "</td></tr>";
                                }?>

                                </tbody>
                            </table>
                            <hr>
                        </div>
                        <!-- /.box-body -->
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

    <div class="modal fade" id="modal-res_af">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Formulario de Ingreso de Resoluciones Afectas</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                            <tbody>
                            <tr>
                                <th style="width: 10px"># Doc</th>
                                <th>Materia</th>
                                <th style="width: 10px">Doc</th>
                                <th style="width: 40px">Privacidad</th>
                            </tr>
                            <?php foreach ($res_af_5 as $listado) {
                                echo "<tr><td>";
                                echo "<small>RES AF #" . $listado->foliodocint . "</small>";
                                echo "</td>";

                                echo "<td>";
                                echo "<small>" . wordwrap($listado->matdocint, 45, '<br>', true) . "</small>";
                                echo "</td>";

                                echo "<td>";
                                echo "<form action='/FichaDocsInt' method='POST'><input type='hidden' name='_token' value='" . csrf_token() . "'><input type='hidden' name='idficdocint' value='" . $listado->iddocint . "'><button class='btn btn-xs btn-success'><i class='fa fa-file-archive-o'></i></button></form>";
                                echo "</td>";

                                echo "<td>";
                                if ($listado->segdocint == 1) {
                                    echo "<center>" . "<span class='badge bg-red'><i class='fa fa-close'></i> No, <br>Sólo Distribución</span>" . "</center>";
                                } elseif ($listado->segdocint == 2) {
                                    echo "<center>" . "<span class='badge bg-primary'><i class='fa fa-lock'></i> No, <br>Uso Restringido</span>" . "</center>";
                                } elseif ($listado->segdocint == 3) {
                                    echo "<center>" . "<span class='badge bg-yellow'><i class='fa fa-building'></i> No, <br>Uso Interno Partes</span>" . "</center>";
                                } elseif ($listado->segdocint == 4) {
                                    echo "<center>" . "<span class='badge bg-green'><i class='fa fa-check-circle'></i> Si, <br> Público en Buscador</span>" . "</center>";
                                }
                                echo "</td></tr>";
                            }?>
                            </tbody>
                        </table>
                        <hr>
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

    <div class="modal fade" id="modal-ord">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Formulario de Ingreso de Ordinarios</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body no-padding">
                        <table class="table table-condensed">
                            <tbody>
                            <tr>
                                <th style="width: 10px"># Doc</th>
                                <th>Materia</th>
                                <th style="width: 10px">Doc</th>
                                <th style="width: 40px">Privacidad</th>
                            </tr>
                            <?php foreach ($ord_5 as $listado) {
                                echo "<tr><td>";
                                echo "<small>ORD #" . $listado->foliodocint . "</small>";
                                echo "</td>";

                                echo "<td>";
                                echo "<small>" . wordwrap($listado->matdocint, 45, '<br>', true) . "</small>";
                                echo "</td>";

                                echo "<td>";
                                echo "<form action='/FichaDocsInt' method='POST'><input type='hidden' name='_token' value='" . csrf_token() . "'><input type='hidden' name='idficdocint' value='" . $listado->iddocint . "'><button class='btn btn-xs btn-success'><i class='fa fa-file-archive-o'></i></button></form>";
                                echo "</td>";

                                echo "<td>";
                                if ($listado->segdocint == 1) {
                                    echo "<center>" . "<span class='badge bg-red'><i class='fa fa-close'></i> No, <br>Sólo Distribución</span>" . "</center>";
                                } elseif ($listado->segdocint == 2) {
                                    echo "<center>" . "<span class='badge bg-primary'><i class='fa fa-lock'></i> No, <br>Uso Restringido</span>" . "</center>";
                                } elseif ($listado->segdocint == 3) {
                                    echo "<center>" . "<span class='badge bg-yellow'><i class='fa fa-building'></i> No, <br>Uso Interno Partes</span>" . "</center>";
                                } elseif ($listado->segdocint == 4) {
                                    echo "<center>" . "<span class='badge bg-green'><i class='fa fa-check-circle'></i> Si, <br> Público en Buscador</span>" . "</center>";
                                }
                                echo "</td></tr>";
                            }?>
                            </tbody>
                        </table>
                        <hr>
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
            $('#btn-res-ex').click(function () {
                if ($("#fecdocint").val() == "") {
                    $('#resp').html("" +
                        "<div class=\"alert alert-warning alert-dismissable\">\n" +
                        "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                        "<h4><i class=\"icon fa fa-warning\"></i> ¡ALERTA DE SISTEMA!</h4>" +
                        "Campo \"Fecha\" es obligatorio.\n" +
                        "</div>");
                    $("#fecdocint").focus();
                    $("#fecdocint").css('border', '1px solid red');
                    return;
                } else if ($("#matbitdocint").val() == "") {
                    $('#resp').html("" +
                        "<div class=\"alert alert-warning alert-dismissable\">\n" +
                        "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                        "<h4><i class=\"icon fa fa-warning\"></i> ¡ALERTA DE SISTEMA!</h4>" +
                        "Campo \"Materia\" es obligatorio.\n" +
                        "</div>");
                    $("#matbitdocint").focus();
                    $("#matbitdocint").css('border', '1px solid red');
                    return;
                }
            });

            $('#btn-res-af').click(function () {
                if ($("#fecdocint2").val() == "") {
                    $('#resp').html("" +
                        "<div class=\"alert alert-warning alert-dismissable\">\n" +
                        "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                        "<h4><i class=\"icon fa fa-warning\"></i> ¡ALERTA DE SISTEMA!</h4>" +
                        "Campo \"Fecha\" es obligatorio.\n" +
                        "</div>");
                    $("#fecdocint2").focus();
                    $("#fecdocint2").css('border', '1px solid red');
                    return;
                } else if ($("#matbitdocint2").val() == "") {
                    $('#resp').html("" +
                        "<div class=\"alert alert-warning alert-dismissable\">\n" +
                        "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                        "<h4><i class=\"icon fa fa-warning\"></i> ¡ALERTA DE SISTEMA!</h4>" +
                        "Campo \"Materia\" es obligatorio.\n" +
                        "</div>");
                    $("#matbitdocint2").focus();
                    $("#matbitdocint2").css('border', '1px solid red');
                    return;
                }
            });

            $('#btn-ordinarios').click(function () {
                if ($("#fecdocint3").val() == "") {
                    $('#resp').html("" +
                        "<div class=\"alert alert-warning alert-dismissable\">\n" +
                        "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                        "<h4><i class=\"icon fa fa-warning\"></i> ¡ALERTA DE SISTEMA!</h4>" +
                        "Campo \"Fecha\" es obligatorio.\n" +
                        "</div>");
                    $("#fecdocint3").focus();
                    $("#fecdocint3").css('border', '1px solid red');
                    return;
                } else if ($("#matbitdocint3").val() == "") {
                    $('#resp').html("" +
                        "<div class=\"alert alert-warning alert-dismissable\">\n" +
                        "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                        "<h4><i class=\"icon fa fa-warning\"></i> ¡ALERTA DE SISTEMA!</h4>" +
                        "Campo \"Materia\" es obligatorio.\n" +
                        "</div>");
                    $("#matbitdocint3").focus();
                    $("#matbitdocint3").css('border', '1px solid red');
                    return;
                }
            });
            return;
        });
    </script>


    <script>

        function eventos_fechas() {
            $("#fecdocint").css('border', '2px solid green');
            $('#resp').html("");
            return;
        }

        function eventos_materias(e) {
            $("#matbitdocint").css('border', '2px solid green');
            var tecla = e.value;
            $("#matbitdocint").val(tecla.toUpperCase());
            $('#resp').html("");
            return;
        }

        function eventos_obs(e) {
            $("#ingobsdocint").css('border', '2px solid green');
            var tecla = e.value;
            $("#ingobsdocint").val(tecla.toUpperCase());
            $('#resp').html("");
            return;
        }

        function eventos_ref(e) {
            $("#ingrefdocint").css('border', '2px solid green');
            var tecla = e.value;
            $("#ingrefdocint").val(tecla.toUpperCase());
            $('#resp').html("");
            return;
        }

        function eventos_fechas2() {
            $("#fecdocint2").css('border', '2px solid green');
            $('#resp').html("");
            return;
        }

        function eventos_materias2(e) {
            $("#matbitdocint2").css('border', '2px solid green');
            var tecla = e.value;
            $("#matbitdocint2").val(tecla.toUpperCase());
            $('#resp').html("");
            return;
        }

        function eventos_obs2(e) {
            $("#ingobsdocint2").css('border', '2px solid green');
            var tecla = e.value;
            $("#ingobsdocint2").val(tecla.toUpperCase());
            $('#resp').html("");
            return;
        }

        function eventos_ref2(e) {
            $("#ingrefdocint2").css('border', '2px solid green');
            var tecla = e.value;
            $("#ingrefdocint2").val(tecla.toUpperCase());
            $('#resp').html("");
            return;
        }

        function eventos_fechas3() {
            $("#fecdocint3").css('border', '2px solid green');
            $('#resp').html("");
            return;
        }

        function eventos_materias3(e) {
            $("#matbitdocint3").css('border', '2px solid green');
            var tecla = e.value;
            $("#matbitdocint3").val(tecla.toUpperCase());
            $('#resp').html("");
            return;
        }

        function eventos_obs3(e) {
            $("#ingobsdocint3").css('border', '2px solid green');
            var tecla = e.value;
            $("#ingobsdocint3").val(tecla.toUpperCase());
            $('#resp').html("");
            return;
        }

        function eventos_ref3(e) {
            $("#ingrefdocint3").css('border', '2px solid green');
            var tecla = e.value;
            $("#ingrefdocint3").val(tecla.toUpperCase());
            $('#resp').html("");
            return;
        }
    </script>
@endsection
