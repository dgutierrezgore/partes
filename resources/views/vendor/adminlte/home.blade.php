@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection


@section('main-content')



        <div class="container-fluid spark-screen">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">Inicio</div>

                        <div class="panel-body">
                            Hola!, <strong>{{ \Illuminate\Support\Facades\Auth::user()->name }}</strong>, Bienvenido a Oficina de Partes Digital
                        </div>
                        <div class="panel-body">
                            Si tienes dudas, consultas o sugerencias, contáctate con Daniel Gutiérrez al anexo 782 ó escribe
                            un correo a dgutierrez@gorebiobio.cl
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
