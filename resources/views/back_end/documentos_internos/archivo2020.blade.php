@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Grilla de Documentos Internos
@endsection

@section('contentheader_title')
    Archivo Resoluciones Exentas, Afectas y Ordinarios
@endsection

@section('contentheader_description')
    - Grilla 2020
@endsection

@section('main-content')

    <div class="row">
        <div class="col-sm-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#inicio" data-toggle="tab" aria-expanded="true"><i
                                class="fa fa-home"></i>
                            <strong>Año en Curso 2020</strong></a></li>
                    <li class=""><a href="#exentas2020" data-toggle="tab" aria-expanded="false"><i
                                class="fa fa-calendar"></i>
                            <strong>Res. Exentas</strong></a></li>
                    <li class=""><a href="#afectas2020" data-toggle="tab" aria-expanded="false"><i
                                class="fa fa-calendar"></i>
                            <strong>Res. Afectas</strong></a></li>
                    <li class=""><a href="#ordinarios2020" data-toggle="tab" aria-expanded="false"><i
                                class="fa fa-calendar"></i>
                            <strong>Ordinarios</strong></a></li>
                </ul>

                <div class="tab-content">

                    <div id="inicio" class="tab-pane active">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Últimos 10 documentos ingresados</h3>
                                <!-- /.box-tools -->
                            </div>
                            <div class="box-body no-padding">
                                <table class="table table-striped">
                                    <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th>Tipo Res.</th>
                                        <th>Materia</th>
                                        <th>Privacidad</th>
                                    </tr>
                                    <?php foreach ($grilla_total as $listado) {
                                        echo "<tr><td>";
                                        echo "<small>" . $listado->foliodocint . " - 2020</small>";
                                        echo "</td>";

                                        echo "<td>";
                                        echo "<small>" . $listado->tipodocint . "</small>";
                                        echo "</td>";

                                        echo "<td>";
                                        echo "<small>" . wordwrap($listado->matdocint, 100, '<br>', true) . "</small>";
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
                                        echo "</td>";
                                    }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="exentas2020">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Grilla de Resoluciones Exentas del año 2020</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="GrillaPrincipal" class="table table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th>Folio / Fecha</th>
                                                    <th>Materia</th>
                                                    <th>A</th>
                                                    <th>Privacidad</th>
                                                    <th>Observaciones</th>
                                                    <th>Referencia</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($grilla_res_ex as $listado) {
                                                    echo "<tr><td>";
                                                    echo "<center><form action='/FichaDocsInt' method='POST'><input type='hidden' name='_token' value='" . csrf_token() . "'><input type='hidden' name='idficdocint' value='" . $listado->iddocint . "'>
                                                <button class='btn btn-xs btn-success'><i class='fa fa-file-archive-o'></i> <br>RES EX." . $listado->foliodocint . "<br>" . date('d - m - Y', strtotime($listado->fechadocint)) . "</button></form></center>";
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo "<small>" . wordwrap($listado->matdocint, 45, '<br>', true) . "</small>";
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo "<center><strong><small>" . $listado->paternofunc . " " . $listado->maternofunc . "<br></small></strong></center>";
                                                    echo "<center><strong><small>" . $listado->nombresfunc . "<br></small></strong></center>";
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
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo "<small>" . wordwrap($listado->obsdocint, 45, '<br>', true) . "</small>";
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo "<small>" . wordwrap($listado->refdocint, 45, '<br>', true) . "</small>";
                                                    echo "</td>";
                                                }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>

                    <div class="tab-pane" id="afectas2020">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Grilla de Resoluciones Afectas del año 2020</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="GrillaPrincipal2" class="table table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th>Folio / Fecha</th>
                                                    <th>Materia</th>
                                                    <th>A</th>
                                                    <th>Estado</th>
                                                    <th>Privacidad</th>
                                                    <th>Observaciones</th>
                                                    <th>Referencia</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($grilla_res_af as $listado) {
                                                    echo "<tr><td>";
                                                    echo "<center><form action='/FichaDocsInt' method='POST'><input type='hidden' name='_token' value='" . csrf_token() . "'><input type='hidden' name='idficdocint' value='" . $listado->iddocint . "'>
                                                <button class='btn btn-xs btn-success'><i class='fa fa-file-archive-o'></i> <br>RES AF." . $listado->foliodocint . "<br>" . date('d - m - Y', strtotime($listado->fechadocint)) . "</button></form></center>";
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo "<small>" . wordwrap($listado->matdocint, 45, '<br>', true) . "</small>";
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo "<center><strong><small>CONTRALORÍA REGIONAL<br></small></strong></center>";
                                                    echo "</td>";

                                                    echo "<td>";
                                                    if ($listado->respcgrdocint == 1) {
                                                        echo "<center>" . "<span class='badge bg-green'><i class='fa fa-check-circle-o'></i> <br>TOMA DE RAZÓN</span>" . "</center>";
                                                    } elseif ($listado->respcgrdocint == 2) {
                                                        echo "<center>" . "<span class='badge bg-yellow'><i class='fa fa-info'></i> <br>SE ABSTIENE</span>" . "</center>";
                                                    } elseif ($listado->respcgrdocint == 3) {
                                                        echo "<center>" . "<span class='badge bg-red'><i class='fa fa-warning'></i> <br>DENEGADO</span>" . "</center>";
                                                    } else {
                                                        echo "<center>" . "<span class='badge bg-black'><i class='fa fa-close'></i> SIN TRAMITAR</span>" . "</center>";
                                                    }
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
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo "<small>" . wordwrap($listado->obsdocint, 45, '<br>', true) . "</small>";
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo "<small>" . wordwrap($listado->refdocint, 45, '<br>', true) . "</small>";
                                                    echo "</td>";
                                                }?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                    </div>

                    <div class="tab-pane" id="ordinarios2020">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Grilla de Ordinarios del año 2020</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="GrillaPrincipal3" class="table table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th>Folio / Fecha</th>
                                                    <th>A</th>
                                                    <th>Materia</th>
                                                    <th>Privacidad</th>
                                                    <th>Observaciones</th>
                                                    <th>Referencia</th>
                                                </tr>
                                                </thead>
                                                <?php foreach ($grilla_ord as $listado) {
                                                    echo "<tr><td>";
                                                    echo "<center><form action='/FichaDocsInt' method='POST'><input type='hidden' name='_token' value='" . csrf_token() . "'><input type='hidden' name='idficdocint' value='" . $listado->iddocint . "'>
                                                <button class='btn btn-xs btn-success'><i class='fa fa-file-archive-o'></i> <br>ORD." . $listado->foliodocint . "<br>" . date('d - m - Y', strtotime($listado->fechadocint)) . "</button></form></center>";
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo "<small>" . wordwrap($listado->adocintord, 45, '<br>', true) . "</small>";
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo "<small>" . wordwrap($listado->matdocint, 45, '<br>', true) . "</small>";
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
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo "<small>" . wordwrap($listado->obsdocint, 45, '<br>', true) . "</small>";
                                                    echo "</td>";

                                                    echo "<td>";
                                                    echo "<small>" . wordwrap($listado->refdocint, 45, '<br>', true) . "</small>";
                                                    echo "</td>";
                                                }?>
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
    </div>


@endsection
