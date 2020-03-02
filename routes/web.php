<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'DocumentosInternosController@index');
    Route::get('/home', 'DocumentosInternosController@index');
    Route::get('/IngresoDocumento', 'DocumentosInternosController@ingreso_documento');
    Route::get('/GestionDocsInt', 'DocumentosInternosController@gestion_docs_int');
    Route::get('/FichaDocsInt', 'DocumentosInternosController@ingreso_documento');
    Route::get('/Mantenedores', 'DocumentosInternosController@gestion_mantenedores');
    Route::get('/BuscarRegistros', 'DocumentosInternosController@buscar_registros');

    Route::post('/FichaDocsInt', 'DocumentosInternosController@ficha_docs_interno');

    Route::post('/GuardarNuevoDoc', 'DocumentosInternosController@guardar_nuevo_documento');
    Route::post('/GuardarEnvInt', 'DocumentosInternosController@guardar_envio_interno');
    Route::post('/GuardarEnvCGR', 'DocumentosInternosController@guardar_envio_interno_cgr');
    Route::post('/GuardarRecCGR', 'DocumentosInternosController@guardar_recep_interno_cgr');
    Route::post('/GuardarObsBit', 'DocumentosInternosController@guardar_obs_b_interno_cgr');
    Route::post('/GuardarGrupDis', 'DocumentosInternosController@guardar_grupo_dis_int');

    Route::post('/HabDesFuncGrpInt', 'DocumentosInternosController@hab_des_mante_fun_grp');
    Route::post('/GuardarNuevoGrupoInterno', 'DocumentosInternosController@guardar_grupo_int');
    Route::post('/GuardarNuevoGrupoExterno', 'DocumentosInternosController@guardar_grupo_ext');

    Route::post('/BloquearEntrega', 'DocumentosInternosController@bloquear_doc');

});


