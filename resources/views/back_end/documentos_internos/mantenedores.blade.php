@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Mantenedor de Grupos de Distribución
@endsection

@section('contentheader_title')
    Mantenedor de Grupos de Distribución
@endsection

@section('contentheader_description')
    - Interna y Externa
@endsection

@section('main-content')

    <div class="col-xs-2">
        <div class="small-box bg-green">
            <div class="inner"><h3>{{ $conta_gi-1 }}<sup style="font-size: 15px">Grupos</sup></h3>
                <p><small>Distribución Interna</small></p></div>
            <div class="icon"><i class="fa fa-group"></i></div>
            <a type="button" data-toggle="modal" data-target="#modal-grupint" class="small-box-footer">
                Agregar Grupo Distribución <i class="fa fa-plus-circle"></i></a></div>

        <div class="small-box bg-green">
            <div class="inner"><h3>{{ $conta_ge-1 }}<sup style="font-size: 15px">Grupos</sup></h3>
                <p><small>Distribución Externa</small></p></div>
            <div class="icon"><i class="fa fa-building"></i></div>
            <a type="button" data-toggle="modal" data-target="#modal-grupext" class="small-box-footer">
                Agregar Grupo Distribución <i class="fa fa-plus-circle"></i></a></div>
    </div>

    <div class="col-sm-10">
        <div id="resp"></div>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#inicio" data-toggle="tab" aria-expanded="false"><i class="fa fa-info"></i>
                        <strong>Resumen</strong></a></li>
                <li class=""><a href="#dis_interna" data-toggle="tab" aria-expanded="true"><i
                            class="fa fa-user"></i> <strong>Asignar Distribución Interna</strong></a></li>
                <li><a href="#dis_externa" data-toggle="tab" aria-expanded="false"><i class="fa fa-database"></i>
                        <strong>Base de Grupos/Funcionarios</strong></a></li>

            </ul>


            <div class="tab-content">
                <div id="inicio" class="tab-pane active">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Lista de Grupos Distribución Internos</h3>
                            <!-- /.box-tools -->
                        </div>
                        <ul>
                            @foreach($grupos_internos as $listado)
                                <small>
                                    <li>
                                        {{ $listado->nomgrpdisint}}
                                    </li>
                                </small>
                            @endforeach
                        </ul>
                    </div>

                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Lista de Grupos Distribución Externos</h3>
                            <!-- /.box-tools -->
                        </div>
                        <ul>
                            @foreach($grupos_externos as $listado)
                                <small>
                                    <li>
                                        {{ $listado->tiposervdisext}} - {{ $listado->nomgrpdisext}}
                                    </li>
                                </small>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div id="dis_interna" class="tab-pane">
                    <form class='form-horizontal' action="/GuardarGrupDis" method="POST" id='formulario_grup'>
                        <input type="hidden" name="tipogrudpdis" value="1">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Grupos Internos</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="idgrupdocint">
                                        @foreach($grupos_internos as $listado)
                                            <option
                                                value="{{$listado->idgrpdisint}}">{{ $listado->nomgrpdisint}}</option>
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
                                <label for="inputEmail3" class="col-sm-2 control-label">Funcionario Institución</label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="idfuncgrpdocint[]">
                                        @foreach($funcionarios as $listado)
                                            <option
                                                value="{{$listado->idfunc}}">{{ $listado->paternofunc}} {{ $listado->maternofunc }}
                                                , {{ $listado->nombresfunc }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" id="" class="btn btn-primary"
                                            onclick="agrega_funcionarios();"><i class="fa fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>

                            <div id="div_macro_1">
                                <div id="funcionarios_ocultos">
                                </div>
                            </div>

                        </div>
                        <div class="box-footer">
                            <button type="button" id="btn-grupint" class="btn btn-success pull-right"><i
                                    class="fa fa-save"></i> Actualizar Grupo Distribución
                            </button>
                        </div>
                    </form>
                </div>

                <div id="dis_externa" class="tab-pane">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Gestión de Grupos Internos</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table id="GrillaPrincipal" class="table table-bordered table-striped dataTable"
                                               role="grid" aria-describedby="example1_info">
                                            <thead>
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="example1"
                                                    rowspan="1" colspan="1" aria-sort="ascending"
                                                    aria-label="Rendering engine: activate to sort column descending"
                                                    style="width: 220px;">Nombre del Grupo
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 270px;">Funcionario
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 270px;">Correo Notificación
                                                </th>
                                                <th class="sorting" tabindex="0" aria-controls="example1"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 270px;">Habilitar/Deshabilitar
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($grilla_gi as $listado)
                                                <tr>
                                                    <td>{{ $listado->nomgrpdisint }}</td>
                                                    <td>{{ $listado->paternofunc }} {{ $listado->maternofunc }}
                                                        , {{ $listado->nombresfunc }}</td>
                                                    <td>{{ $listado->mailfunc }}</td>
                                                    <td>
                                                        @if($listado->estadositdetfunc==1)
                                                            <center>
                                                                <form action="/HabDesFuncGrpInt" method="POST">
                                                                    <input type="hidden" name="hab" value="0">
                                                                    <input type="hidden" name="_token"
                                                                           value="{{ csrf_token() }}">
                                                                    <input type="hidden" name="idfungrpdocint"
                                                                           value="{{ $listado->iddetallegrpint }}">
                                                                    <button class="btn btn-xs btn-danger" type="submit">
                                                                        <i class="fa fa-close"></i> Deshabilitar
                                                                    </button>
                                                                </form>
                                                            </center>

                                                        @elseif($listado->estadositdetfunc==0)

                                                            <center>
                                                                <form action="/HabDesFuncGrpInt" method="POST">
                                                                    <input type="hidden" name="hab" value="1">
                                                                    <input type="hidden" name="_token"
                                                                           value="{{ csrf_token() }}">
                                                                    <input type="hidden" name="idfungrpdocint"
                                                                           value="{{ $listado->iddetallegrpint }}">
                                                                    <button class="btn btn-xs btn-success"
                                                                            type="submit"><i
                                                                            class="fa fa-check-circle"></i> Habilitar
                                                                    </button>
                                                                </form>
                                                            </center>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">Nombre del Grupo</th>
                                                <th rowspan="1" colspan="1">Funcionario</th>
                                                <th rowspan="1" colspan="1">Correo de Notificación</th>
                                                <th rowspan="1" colspan="1">Habilitar/Deshabilitar</th>
                                            </tr>
                                            </tfoot>
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

        <div style="display: none;" id="div_distrib_int">
            <div id="div_select_func">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label"><strong><i class="fa fa-plus"></i>
                            Adicional</strong></label>
                    <div class="col-sm-8">
                        <select class="form-control" name="idfuncgrpdocint[]">
                            @foreach($funcionarios as $listado)
                                <option
                                    value="{{$listado->idfunc}}">{{ $listado->paternofunc}} {{ $listado->maternofunc }}
                                    , {{ $listado->nombresfunc }}</option>
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

        <div class="modal fade" id="modal-grupint">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Formulario de Creación Grupos Internos</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body no-padding">
                            <div class="modal-content" id="resp_modal_2">

                            </div>
                            <form class="form-horizontal" id="form_nuevo_grupo">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Nombre del Grupo</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="nomgrupdocint" name="nomgrupdocint"
                                                   class="form-control" onkeyup="evento_nomgrudocint(this);" required>
                                        </div>
                                    </div>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="reset" class="btn btn-default">Cancelar Envío</button>
                                    <button type="button" id="btn_nuevogrupoint" class="btn btn-success pull-right"><i
                                            class="fa fa-save"></i>
                                        Nuevo Grupo
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

        <div class="modal fade" id="modal-grupext">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Formulario de Creación Grupos Externos</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body no-padding">
                            <div class="modal-content" id="resp_modal_2">

                            </div>
                            <form class="form-horizontal" id="form_nuevo_grupo_ex">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Tipo Institución</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="tipoinstgrpext" name="tipoinstgrpext"
                                                   class="form-control" onkeyup="evento_tipo(this);" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-3 control-label">Nombre
                                            Institución</label>
                                        <div class="col-sm-9">
                                            <input type="text" id="nombreinstgrpext" name="nombreinstgrpext"
                                                   class="form-control" onkeyup="evento_nombre(this);" required>
                                        </div>
                                    </div>
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </div>
                                <!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="reset" class="btn btn-default">Cancelar Envío</button>
                                    <button type="button" id="btn_nuevogrupoext" class="btn btn-success pull-right"><i
                                            class="fa fa-save"></i>
                                        Nuevo Grupo
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
            function agrega_funcionarios() {
                var agrega = $("#div_select_func").html();
                $("#funcionarios_ocultos").append(agrega);
            }

            function evento_nomgrudocint(e) {
                $("#nomgrupdocint").css('border', '2px solid green');
                var tecla = e.value;
                $("#nomgrupdocint").val(tecla.toUpperCase());
                $('#resp').html("");
                return;
            }

            function evento_tipo(e) {
                $("#tipoinstgrpext").css('border', '2px solid green');
                var tecla = e.value;
                $("#tipoinstgrpext").val(tecla.toUpperCase());
                $('#resp').html("");
                return;
            }

            function evento_nombre(e) {
                $("#nombreinstgrpext").css('border', '2px solid green');
                var tecla = e.value;
                $("#nombreinstgrpext").val(tecla.toUpperCase());
                $('#resp').html("");
                return;
            }
        </script>

        <script>
            $(document).on('ready', function () {
                $('#btn-grupint').click(function () {
                    var url = "GuardarGrupDis";
                    var validacion_ok = 0;

                    $.ajax({
                        type: "post",
                        url: url,
                        data: $("#formulario_grup").serialize(),
                        success: function (data) {
                            if (data == 1) {
                                $('#resp').html("" +
                                    "<div class=\"alert alert-success alert-dismissable\">\n" +
                                    "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                                    "<h4><i class=\"icon fa fa-check\"></i> ¡MENSAJE DE SISTEMA!</h4>" +
                                    "Funcionario(s) asignado(s) a la lista de distribución interna.\n" +
                                    "</div>");
                                setTimeout(function () {
                                    location.reload(true);
                                }, 3000);
                            }
                        },
                        error: function (data) {
                            $('#resp').html("" +
                                "<div class=\"alert alert-warning alert-dismissable\">\n" +
                                "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                                "<h4><i class=\"icon fa fa-info\"></i> ¡ALERTA DE SISTEMA!</h4>" +
                                "Uno o más funcionarios no pudieron ser agregados porque ya estaban en la lista de distribución.\n" +
                                "</div>");
                        }
                    });
                });
                return;
            });
        </script>

        <script>
            $(document).on('ready', function () {
                $('#btn_nuevogrupoint').click(function () {
                    var url = "GuardarNuevoGrupoInterno";
                    var validacion_ok = 0;

                    if ($("#nomgrupdocint").val() == "") {
                        $('#resp').html("" +
                            "<div class=\"alert alert-warning alert-dismissable\">\n" +
                            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                            "<h4><i class=\"icon fa fa-warning\"></i> ¡ALERTA DE SISTEMA!</h4>" +
                            "Campo \"Nombre del Grupo\" es obligatorio.\n" +
                            "</div>");
                        $("#nomgrupdocint").focus();
                        $("#nomgrupdocint").css('border', '1px solid red');
                        return;
                    }

                    $.ajax({
                        type: "post",
                        url: url,
                        data: $("#form_nuevo_grupo").serialize(),
                        success: function (data) {
                            if (data == 1) {
                                $('#resp').html("" +
                                    "<div class=\"alert alert-success alert-dismissable\">\n" +
                                    "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                                    "<h4><i class=\"icon fa fa-check\"></i> ¡MENSAJE DE SISTEMA!</h4>" +
                                    "Grupo Interno creado exitosamente.\n" +
                                    "</div>");
                                $("#modal-grupint").modal('hide');
                                setTimeout(function () {
                                    location.reload(true);
                                }, 3000);
                            }
                        },
                        error: function (data) {
                            $('#resp').html("" +
                                "<div class=\"alert alert-warning alert-dismissable\">\n" +
                                "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                                "<h4><i class=\"icon fa fa-info\"></i> ¡ALERTA DE SISTEMA!</h4>" +
                                "No se pudo crear el grupo, notifique al administrador.\n" +
                                "</div>");
                            $("#modal-grupint").modal('hide');
                        }
                    });
                });
                return;
            });
        </script>


        <script>
            $(document).on('ready', function () {
                $('#btn_nuevogrupoext').click(function () {
                    var url = "GuardarNuevoGrupoExterno";
                    var validacion_ok = 0;

                    if ($("#tipoinstgrpext").val() == "") {
                        $('#resp').html("" +
                            "<div class=\"alert alert-warning alert-dismissable\">\n" +
                            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                            "<h4><i class=\"icon fa fa-warning\"></i> ¡ALERTA DE SISTEMA!</h4>" +
                            "Campo \"Tipo Institución\" es obligatorio.\n" +
                            "</div>");
                        $("#tipoinstgrpext").focus();
                        $("#tipoinstgrpext").css('border', '1px solid red');
                        return;
                    }

                    if ($("#nombreinstgrpext").val() == "") {
                        $('#resp').html("" +
                            "<div class=\"alert alert-warning alert-dismissable\">\n" +
                            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                            "<h4><i class=\"icon fa fa-warning\"></i> ¡ALERTA DE SISTEMA!</h4>" +
                            "Campo \"Nombre Institución\" es obligatorio.\n" +
                            "</div>");
                        $("#nombreinstgrpext").focus();
                        $("#nombreinstgrpext").css('border', '1px solid red');
                        return;
                    }

                    $.ajax({
                        type: "post",
                        url: url,
                        data: $("#form_nuevo_grupo_ex").serialize(),
                        success: function (data) {
                            if (data == 1) {
                                $('#resp').html("" +
                                    "<div class=\"alert alert-success alert-dismissable\">\n" +
                                    "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                                    "<h4><i class=\"icon fa fa-check\"></i> ¡MENSAJE DE SISTEMA!</h4>" +
                                    "Grupo Externo creado exitosamente.\n" +
                                    "</div>");
                                $("#modal-grupext").modal('hide');
                                setTimeout(function () {
                                    location.reload(true);
                                }, 3000);
                            }
                        },
                        error: function (data) {
                            $('#resp').html("" +
                                "<div class=\"alert alert-warning alert-dismissable\">\n" +
                                "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button>" +
                                "<h4><i class=\"icon fa fa-info\"></i> ¡ALERTA DE SISTEMA!</h4>" +
                                "No se pudo crear el grupo, notifique al administrador.\n" +
                                "</div>");
                            $("#modal-grupext").modal('hide');
                        }
                    });
                });
                return;
            });
        </script>
@endsection
