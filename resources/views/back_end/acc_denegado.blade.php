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

    <section class="content">
        <section class="content">

            <div class="error-page">
                <h2 class="headline text-red">300</h2>

                <div class="error-content">
                    <h3><i class="fa fa-warning text-red"></i> Oops! Usted no tiene acceso a este sistema.</h3>

                    <p>
                        Por favor tome contacto con la Unidad Informática del Gobierno Regional.
                    </p>
                    <p>Al teléfono 2405 782 ó al correo electrónico dgutierrez@gorebiobio.cl</p>

                </div>
            </div>
            <!-- /.error-page -->

        </section>

@endsection
