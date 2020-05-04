@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection


@section('main-content')



    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-success">
                    <div class="panel-heading"><i class="fa fa-home"></i> Inicio</div>

                    <div class="panel-body">
                        ¡Hola!, <strong>{{ \Illuminate\Support\Facades\Auth::user()->name }}</strong>, Bienvenido a
                        <strong>Oficina de Partes Digital</strong>.
                    </div>
                    <div class="panel-body">
                        Si tienes dudas, consultas o sugerencias, contáctate con Daniel Gutiérrez Fariña al anexo 782 ó escribe
                        un correo a: dgutierrez@gorebiobio.cl.
                    </div>
                </div>

                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <i class="fa fa-newspaper-o"></i> <strong>Cuadro Panel de Novedades al 04 de Mayo 2020</strong>
                        <small>V.01</small>
                    </div>

                    <div class="panel-body">
                        Hemos incorporado este panel de novedades para que revises los avances de digitalización
                        :)
                    </div>
                    <div class="panel-body">
                        <ul>
                            <i class="fa fa-check"></i> Se incorpora nuevo panel de novedades. <br>
                            <i class="fa fa-check"></i> Ahora es posible digitalizar documentos con folios anteriores al último registrado.
                            <br>
                            <i class="fa fa-check"></i> Se incorpora la posibilidad de volver a cargar documentos con
                            errores de digitalización.
                            <br>
                            <i class="fa fa-check"></i> Ahora los documentos se listan por el último folio digitalizado.
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
