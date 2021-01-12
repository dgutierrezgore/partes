<?php

namespace App\Http\Controllers;

use Ajaxray\PHPWatermark\Watermark;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\AvisoDocumentoInterno;
use App\Mail\AvisoReEnvioDocumentoInterno;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;

class DocumentosInternosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //CAPA SEGURIDAD
        $accesos = DB::table('sys_acc_sistemas')
            ->where([
                ['users_id', Auth::user()->id]
            ])
            ->first();
        if ($accesos->sys_sistemas_idsistemasgore == 1 && $accesos->estadoacc == 1) {
            if ($accesos->nivelacc == 1 || $accesos->nivelacc == 2) {
                return view('vendor.adminlte.home');
            } else {
                DB::table('sys_acc_denegado')->insert([
                    'fecregistro' => date('Y-m-d H:i:s'),
                    'ip' => \Request::ip(),
                    'tipo' => 'NIVEL',
                    'modulo' => 'INDEX',
                    'sys_sistemas_idsistemasgore' => 1,
                    'users_id' => Auth::id()
                ]);
                return view('back_end.acc_denegado');
            }
        } else {
            DB::table('sys_acc_denegado')->insert([
                'fecregistro' => date('Y-m-d H:i:s'),
                'ip' => \Request::ip(),
                'tipo' => 'SISTEMA',
                'sys_sistemas_idsistemasgore' => 1,
                'users_id' => Auth::id()
            ]);
            return view('back_end.acc_denegado');
        }

    } // SEGURIDAD OK

    public function ingreso_documento()
    {

        $accesos = DB::table('sys_acc_sistemas')
            ->where([
                ['users_id', Auth::user()->id]
            ])
            ->first();
        if ($accesos->sys_sistemas_idsistemasgore == 1 && $accesos->estadoacc == 1) {
            if ($accesos->nivelacc == 1 || $accesos->nivelacc == 2) {
                //Obtiene último folio asignado Res.Ex
                $ult_res_ex = DB::table('op_documentos_internos')
                    ->where([
                        ['estdocint', '=', 1],
                        ['tipos_docs_internos_iddocsint', '=', 1],
                    ]) //Cambiar por tipo
                    ->whereYear('fechadocint', date('Y'))
                    ->max('foliodocint');

                //Le suma 1 al último folio asignado Res.Ex
                $ult_res_ex = $ult_res_ex + 1;

                $ult_res_af = DB::table('op_documentos_internos')
                    ->where([
                        ['estdocint', '=', 1],
                        ['tipos_docs_internos_iddocsint', '=', 2]
                    ]) //Cambiar por tipo
                    ->whereYear('fechadocint', date('Y'))
                    ->max('foliodocint');

                $ult_res_af = $ult_res_af + 1;

                $ult_circ = DB::table('op_documentos_internos')
                    ->where([
                        ['estdocint', '=', 1],
                        ['tipos_docs_internos_iddocsint', '=', 3]
                    ]) //Cambiar por tipo
                    ->whereYear('fechadocint', date('Y'))
                    ->max('foliodocint');

                $ult_circ = $ult_circ + 1;

                //Obtiene últimas 5 Res.Ex
                $res_ex_5 = DB::table('op_documentos_internos')
                    ->where([
                        ['estdocint', '=', 1],
                        ['tipos_docs_internos_iddocsint', '=', '1']
                    ]) //Cambiar por tipo
                    ->whereYear('fechadocint', date('Y'))
                    ->orderby('foliodocint', 'DESC')
                    ->limit(5)
                    ->get();

                $res_af_5 = DB::table('op_documentos_internos')
                    ->where([
                        ['estdocint', '=', 1],
                        ['tipos_docs_internos_iddocsint', '=', 2]
                    ]) //Cambiar por tipo
                    ->whereYear('fechadocint', date('Y'))
                    ->orderby('foliodocint', 'DESC')
                    ->limit(5)
                    ->get();

                $ord_5 = DB::table('op_documentos_internos')
                    ->where([
                        ['estdocint', '=', 1],
                        ['tipos_docs_internos_iddocsint', '=', 3]
                    ]) //Cambiar por tipo
                    ->whereYear('fechadocint', date('Y'))
                    ->orderby('foliodocint', 'DESC')
                    ->limit(5)
                    ->get();

                //Obtiene Grupos de Distribución Interna
                $listado_dist_int = DB::table('op_grupos_dis_internos')
                    ->where('estgrpdisint', 1)
                    ->OrderBy('nomgrpdisint', 'ASC')
                    ->get();

                $listado_dist_ex = DB::table('op_grupos_dis_externos')
                    ->where('estgrpdisext', 1)
                    ->OrderBy('tiposervdisext', 'ASC')
                    ->OrderBy('nomgrpdisext', 'ASC')
                    ->get();

                //Obtiene listado de funcionarios
                $funcionarios = DB::table('listado_funcionarios')
                    ->OrderBy('paternofunc', 'ASC')
                    ->OrderBy('maternofunc', 'ASC')
                    ->get();

                //Vista
                return view('back_end.documentos_internos.registrar', [
                    'ult_res_ex' => $ult_res_ex,
                    'ult_res_af' => $ult_res_af,
                    'ult_circ' => $ult_circ,
                    'funcionarios' => $funcionarios,
                    'res_ex_5' => $res_ex_5,
                    'res_af_5' => $res_af_5,
                    'ord_5' => $ord_5,
                    'dis_int' => $listado_dist_int,
                    'dis_ex' => $listado_dist_ex
                ]);
            } else {
                DB::table('sys_acc_denegado')->insert([
                    'fecregistro' => date('Y-m-d H:i:s'),
                    'ip' => \Request::ip(),
                    'tipo' => 'NIVEL',
                    'modulo' => 'NUEVO DOCUMENTO',
                    'sys_sistemas_idsistemasgore' => 1,
                    'users_id' => Auth::id()
                ]);
                return view('back_end.acc_denegado');
            }

        } else {
            DB::table('sys_acc_denegado')->insert([
                'fecregistro' => date('Y-m-d H:i:s'),
                'ip' => \Request::ip(),
                'tipo' => 'SISTEMA',
                'sys_sistemas_idsistemasgore' => 1,
                'users_id' => Auth::id()
            ]);
            return view('back_end.acc_denegado');
        }

    } // SEGURIDAD OK

    public function guardar_nuevo_documento(Request $request)
    {

        $accesos = DB::table('sys_acc_sistemas')
            ->where([
                ['users_id', Auth::user()->id]
            ])
            ->first();
        if ($accesos->sys_sistemas_idsistemasgore == 1 && $accesos->estadoacc == 1) {
            if ($accesos->nivelacc == 1 || $accesos->nivelacc == 2) {
                //Base de Datos -> Documento Interno
                //A Tipo de Documento Interno :: 1 = ResEx ; 2 = ResAf ; 3 = Ord.
                //B Tipo Actividad Bitácora   :: 1 = Creación

                $tipodoc = $request->tipodocint;

                try {
                    if ($tipodoc == 1) {

                        //Verifica Si existe Res Ex con Igual Numero

                        $folio_existe = DB::table('op_documentos_internos')
                            ->where([
                                ['tipos_docs_internos_iddocsint', $tipodoc],
                                ['foliocompdocint', 'RES_EX_' . $request->foliodocint . '_' . $request->anniodocint]
                            ])
                            ->count();

                        if ($folio_existe >= 1) {

                            return back()->with('error', '¡EL FOLIO INGRESADO YA EXISTE REGISTRADO EN LA BASE DE DATOS!');

                        } else {

                            $tipo = 'RES_EX';
                            $annio = date("Y");
                            $file = $request->file('arcdocint');
                            $name = $annio . '-' . $tipo . '-' . time() . '-' . $file->getClientOriginalName();
                            $file->move(public_path() . '/StoragePartes/', $name);

                            // Documentos Internos //
                            $id_doc_int = DB::table('op_documentos_internos')->insertGetId([
                                'foliodocint' => $request->foliodocint,
                                'foliosimpledocint' => $request->foliodocint . '_' . $request->anniodocint,
                                'foliocompdocint' => 'RES_EX_' . $request->foliodocint . '_' . $request->anniodocint,
                                'matdocint' => $request->matbitdocint,
                                'fechadocint' => $request->fecdocint,
                                'urldocint' => $name,
                                'obsdocint' => $request->ingobsdocint,
                                'refdocint' => $request->ingrefdocint,
                                'feccgrdocint' => null,
                                'horacgrdocint' => null,
                                'segdocint' => $request->segdocint,
                                'estdocint' => 1,
                                'tipos_docs_internos_iddocsint' => $tipodoc,
                                'listado_funcionarios_idfunc' => $request->funinvdocint,
                                'users_id' => Auth::user()->id
                            ]);

                            //Bitácora //
                            DB::table('op_bitacora_docs_internos')->insert([
                                'accbitdocint' => 'Creación del Documento en Sistema',
                                'tipoaccbitdocint' => 1,
                                'fecbitdocint' => date('Y-m-d'),
                                'horabitdocint' => date('h:i:s'),
                                'forsoldocint' => null,
                                'documentos_internos_iddocint' => $id_doc_int,
                                'users_id' => Auth::user()->id
                            ]);

                            //Asignación de Distribución Interna //
                            $grupos_int = $request->idgrupintdocint;

                            foreach ($grupos_int as $key => $value) {

                                DB::table('op_det_dist_docs_int')->insert([
                                    'fecenlacedocfunc' => date('Y-m-d h:i:s'),
                                    'documentos_internos_iddocint' => $id_doc_int,
                                    'grupos_dis_internos_idgrpdisint' => $grupos_int[$key]
                                ]);

                                $ids_grupos[] = $grupos_int[$key];
                            }

                            DB::table('op_lec_doc_int')->insert([
                                'disdocintfunc' => 1,
                                'recepfuncdocint' => 0,
                                'lectfuncdocint' => 0,
                                'estadolectdocint' => 1,
                                'listado_funcionarios_idfunc' => $request->funinvdocint,
                                'op_documentos_internos_iddocint' => $id_doc_int
                            ]);

                            $id_func = DB::table('op_detalle_grupos_int')
                                ->where('estadositdetfunc', 1)
                                ->whereIn('grupos_dis_internos_idgrpdisint', DB::table('op_det_dist_docs_int')
                                    ->where('documentos_internos_iddocint', $id_doc_int)
                                    ->pluck('grupos_dis_internos_idgrpdisint'))
                                ->select('listado_funcionarios_idfunc')
                                ->distinct()
                                ->pluck('listado_funcionarios_idfunc');


                            foreach ($id_func as $key => $value) {

                                DB::table('op_lec_doc_int')->insert([
                                    'disdocintfunc' => 2,
                                    'recepfuncdocint' => 0,
                                    'lectfuncdocint' => 0,
                                    'estadolectdocint' => 1,
                                    'listado_funcionarios_idfunc' => $id_func[$key],
                                    'op_documentos_internos_iddocint' => $id_doc_int
                                ]);

                            }

                            //Asignación de Distribución Externa //
                            $grupos_ext = $request->idgrupextdocint;

                            foreach ($grupos_ext as $key => $value) {

                                DB::table('op_det_dist_docs_ext')->insert([
                                    'fecenlacedocext' => date('Y-m-d h:i:s'),
                                    'documentos_internos_iddocint' => $id_doc_int,
                                    'grupos_dis_externos_idgrpdisext' => $grupos_ext[$key]
                                ]);
                            }

                            $datos_correo = DB::table('op_documentos_internos')
                                ->join('listado_funcionarios', 'listado_funcionarios.idfunc', 'op_documentos_internos.listado_funcionarios_idfunc')
                                ->where('iddocint', $id_doc_int)
                                ->first();

                            $data_correo = array(
                                'fecha' => $datos_correo->fechadocint,
                                'materia' => $datos_correo->matdocint,
                                'tipodoc' => 'RES. EXENTA',
                                'numdoc' => $datos_correo->foliocompdocint,
                                'referencia' => $datos_correo->refdocint
                            );

                            Mail::to($datos_correo->mailfunc)
                                ->send(new AvisoDocumentoInterno($data_correo));

                            foreach ($ids_grupos as $key => $value) {
                                $id_temp = DB::table('op_detalle_grupos_int')
                                    ->join('listado_funcionarios', 'listado_funcionarios.idfunc', 'op_detalle_grupos_int.listado_funcionarios_idfunc')
                                    ->where([
                                        ['grupos_dis_internos_idgrpdisint', $ids_grupos[$key]],
                                        ['estadositdetfunc', 1]
                                    ])
                                    ->pluck('mailfunc');

                                Mail::to($id_temp)
                                    ->send(new AvisoDocumentoInterno($data_correo));
                            }

                        }

                    } elseif ($tipodoc == 2) {

                        $folio_existe = DB::table('op_documentos_internos')
                            ->where([
                                ['tipos_docs_internos_iddocsint', $tipodoc],
                                ['foliocompdocint', 'RES_AF_' . $request->foliodocint . '_' . $request->anniodocint]
                            ])
                            ->count();

                        if ($folio_existe >= 1) {

                            return back()->with('error', '¡EL FOLIO INGRESADO YA EXISTE REGISTRADO EN LA BASE DE DATOS!');

                        } else {

                            $tipo = 'RES_AF';
                            $annio = date("Y");
                            $file = $request->file('arcdocintaf');
                            $name = $annio . '-' . $tipo . '-' . time() . '-' . $file->getClientOriginalName();
                            $file->move(public_path() . '/StoragePartes/', $name);

                            // Documentos Internos //
                            $id_doc_int = DB::table('op_documentos_internos')->insertGetId([
                                'foliodocint' => $request->foliodocint,
                                'foliosimpledocint' => $request->foliodocint . '_' . $request->anniodocint,
                                'foliocompdocint' => 'RES_AF_' . $request->foliodocint . '_' . $request->anniodocint,
                                'matdocint' => $request->matbitdocint,
                                'fechadocint' => $request->fecdocint,
                                'urldocint' => $name,
                                'obsdocint' => $request->ingobsdocint,
                                'refdocint' => $request->ingrefdocint,
                                'feccgrdocint' => null,
                                'horacgrdocint' => null,
                                'segdocint' => $request->segdocint,
                                'estdocint' => 1,
                                'tipos_docs_internos_iddocsint' => $tipodoc,
                                'listado_funcionarios_idfunc' => null,
                                'users_id' => Auth::user()->id
                            ]);

                            //Bitácora //
                            DB::table('op_bitacora_docs_internos')->insert([
                                'accbitdocint' => 'Creación del Documento en Sistema',
                                'tipoaccbitdocint' => 1,
                                'fecbitdocint' => date('Y-m-d'),
                                'horabitdocint' => date('h:i:s'),
                                'forsoldocint' => null,
                                'documentos_internos_iddocint' => $id_doc_int,
                                'users_id' => Auth::user()->id
                            ]);

                            //Asignación de Distribución Interna //
                            $grupos_int = $request->idgrupintdocint;

                            foreach ($grupos_int as $key => $value) {

                                DB::table('op_det_dist_docs_int')->insert([
                                    'fecenlacedocfunc' => date('Y-m-d h:i:s'),
                                    'documentos_internos_iddocint' => $id_doc_int,
                                    'grupos_dis_internos_idgrpdisint' => $grupos_int[$key]
                                ]);

                                $ids_grupos[] = $grupos_int[$key];
                            }

                            $id_func = DB::table('op_detalle_grupos_int')
                                ->where('estadositdetfunc', 1)
                                ->whereIn('grupos_dis_internos_idgrpdisint', DB::table('op_det_dist_docs_int')
                                    ->where('documentos_internos_iddocint', $id_doc_int)
                                    ->pluck('grupos_dis_internos_idgrpdisint'))
                                ->select('listado_funcionarios_idfunc')
                                ->distinct()
                                ->pluck('listado_funcionarios_idfunc');


                            foreach ($id_func as $key => $value) {

                                DB::table('op_lec_doc_int')->insert([
                                    'disdocintfunc' => 2,
                                    'recepfuncdocint' => 0,
                                    'lectfuncdocint' => 0,
                                    'estadolectdocint' => 1,
                                    'listado_funcionarios_idfunc' => $id_func[$key],
                                    'op_documentos_internos_iddocint' => $id_doc_int
                                ]);

                            }

                            $datos_correo = DB::table('op_documentos_internos')
                                ->where('iddocint', $id_doc_int)
                                ->first();

                            $data_correo = array(
                                'fecha' => $datos_correo->fechadocint,
                                'materia' => $datos_correo->matdocint,
                                'tipodoc' => 'RES. AFECTA',
                                'numdoc' => $datos_correo->foliocompdocint,
                                'referencia' => $datos_correo->refdocint
                            );

                            foreach ($ids_grupos as $key => $value) {
                                $id_temp = DB::table('op_detalle_grupos_int')
                                    ->join('listado_funcionarios', 'listado_funcionarios.idfunc', 'op_detalle_grupos_int.listado_funcionarios_idfunc')
                                    ->where([
                                        ['grupos_dis_internos_idgrpdisint', $ids_grupos[$key]],
                                        ['estadositdetfunc', 1]
                                    ])
                                    ->pluck('mailfunc');

                                Mail::to($id_temp)
                                    ->send(new AvisoDocumentoInterno($data_correo));
                            }

                        }
                    } elseif ($tipodoc == 3) {

                        $folio_existe = DB::table('op_documentos_internos')
                            ->where([
                                ['tipos_docs_internos_iddocsint', $tipodoc],
                                ['foliocompdocint', 'ORD_' . $request->foliodocint . '_' . $request->anniodocint]
                            ])
                            ->count();

                        if ($folio_existe >= 1) {

                            return back()->with('error', '¡EL FOLIO INGRESADO YA EXISTE REGISTRADO EN LA BASE DE DATOS!');

                        } else {

                            $tipo = 'ORD';
                            $annio = date("Y");
                            $file = $request->file('arcdocintcir');
                            $name = $annio . '-' . $tipo . '-' . time() . '-' . $file->getClientOriginalName();
                            $file->move(public_path() . '/StoragePartes/', $name);

                            // Documentos Internos //
                            $id_doc_int = DB::table('op_documentos_internos')->insertGetId([
                                'foliodocint' => $request->foliodocint,
                                'foliosimpledocint' => $request->foliodocint . '_' . $request->anniodocint,
                                'foliocompdocint' => 'ORD_' . $request->foliodocint . '_' . $request->anniodocint,
                                'matdocint' => $request->matbitdocint,
                                'adocintord' => $request->adocintord,
                                'fechadocint' => $request->fecdocint,
                                'urldocint' => $name,
                                'obsdocint' => $request->ingobsdocint,
                                'refdocint' => $request->ingrefdocint,
                                'feccgrdocint' => null,
                                'horacgrdocint' => null,
                                'segdocint' => $request->segdocint,
                                'estdocint' => 1,
                                'tipos_docs_internos_iddocsint' => $tipodoc,
                                'listado_funcionarios_idfunc' => null,
                                'users_id' => Auth::user()->id
                            ]);

                            //Bitácora //
                            DB::table('op_bitacora_docs_internos')->insert([
                                'accbitdocint' => 'Creación del Documento en Sistema',
                                'tipoaccbitdocint' => 1,
                                'fecbitdocint' => date('Y-m-d'),
                                'horabitdocint' => date('h:i:s'),
                                'forsoldocint' => null,
                                'documentos_internos_iddocint' => $id_doc_int,
                                'users_id' => Auth::user()->id
                            ]);

                            //Asignación de Distribución Interna //
                            $grupos_int = $request->idgrupintdocint;

                            foreach ($grupos_int as $key => $value) {

                                DB::table('op_det_dist_docs_int')->insert([
                                    'fecenlacedocfunc' => date('Y-m-d h:i:s'),
                                    'documentos_internos_iddocint' => $id_doc_int,
                                    'grupos_dis_internos_idgrpdisint' => $grupos_int[$key]
                                ]);

                                $ids_grupos[] = $grupos_int[$key];
                            }

                            $grupos_ext = $request->idgrupextdocint;

                            foreach ($grupos_ext as $key => $value) {

                                DB::table('op_det_dist_docs_ext')->insert([
                                    'fecenlacedocext' => date('Y-m-d h:i:s'),
                                    'documentos_internos_iddocint' => $id_doc_int,
                                    'grupos_dis_externos_idgrpdisext' => $grupos_ext[$key]
                                ]);
                            }

                            $id_func = DB::table('op_detalle_grupos_int')
                                ->where('estadositdetfunc', 1)
                                ->whereIn('grupos_dis_internos_idgrpdisint', DB::table('op_det_dist_docs_int')
                                    ->where('documentos_internos_iddocint', $id_doc_int)
                                    ->pluck('grupos_dis_internos_idgrpdisint'))
                                ->select('listado_funcionarios_idfunc')
                                ->distinct()
                                ->pluck('listado_funcionarios_idfunc');


                            foreach ($id_func as $key => $value) {

                                DB::table('op_lec_doc_int')->insert([
                                    'disdocintfunc' => 2,
                                    'recepfuncdocint' => 0,
                                    'lectfuncdocint' => 0,
                                    'estadolectdocint' => 1,
                                    'listado_funcionarios_idfunc' => $id_func[$key],
                                    'op_documentos_internos_iddocint' => $id_doc_int
                                ]);

                            }

                            $datos_correo = DB::table('op_documentos_internos')
                                ->where('iddocint', $id_doc_int)
                                ->first();

                            $data_correo = array(
                                'fecha' => $datos_correo->fechadocint,
                                'materia' => $datos_correo->matdocint,
                                'tipodoc' => 'ORDINARIO',
                                'numdoc' => $datos_correo->foliocompdocint,
                                'referencia' => $datos_correo->refdocint
                            );

                            foreach ($ids_grupos as $key => $value) {
                                $id_temp = DB::table('op_detalle_grupos_int')
                                    ->join('listado_funcionarios', 'listado_funcionarios.idfunc', 'op_detalle_grupos_int.listado_funcionarios_idfunc')
                                    ->where([
                                        ['grupos_dis_internos_idgrpdisint', $ids_grupos[$key]],
                                        ['estadositdetfunc', 1]
                                    ])
                                    ->pluck('mailfunc');

                                Mail::to($id_temp)
                                    ->send(new AvisoDocumentoInterno($data_correo));
                            }


                        }

                    }

                    return back()->with('status', '¡DOCUMENTO ALMACENADO CORRECTAMENTE Y DISTRIBUIDO!');

                } catch (Exception $e) {
                    report($e);
                    echo '2'; // ENVIA ERROR
                }
            } else {
                DB::table('sys_acc_denegado')->insert([
                    'fecregistro' => date('Y-m-d H:i:s'),
                    'ip' => \Request::ip(),
                    'tipo' => 'NIVEL',
                    'modulo' => 'GUARDA DOCUMENTO',
                    'sys_sistemas_idsistemasgore' => 1,
                    'users_id' => Auth::id()
                ]);
                return view('back_end.acc_denegado');
            }

        } else {
            DB::table('sys_acc_denegado')->insert([
                'fecregistro' => date('Y-m-d H:i:s'),
                'ip' => \Request::ip(),
                'tipo' => 'SISTEMA',
                'sys_sistemas_idsistemasgore' => 1,
                'users_id' => Auth::id()
            ]);
            return view('back_end.acc_denegado');
        }

    } // SEGURIDAD OK

    public
    function gestion_docs_int()
    {

        $accesos = DB::table('sys_acc_sistemas')
            ->where([
                ['users_id', Auth::user()->id]
            ])
            ->first();
        if ($accesos->sys_sistemas_idsistemasgore == 1 && $accesos->estadoacc == 1) {
            if ($accesos->nivelacc == 1 || $accesos->nivelacc == 2) {
                $grilla_res_ex = DB::table('op_documentos_internos')
                    ->join('listado_funcionarios', 'listado_funcionarios.idfunc', 'op_documentos_internos.listado_funcionarios_idfunc')
                    ->whereYear('fechadocint', date('Y'))
                    ->where('tipos_docs_internos_iddocsint', 1)
                    ->orderBy('foliodocint', 'desc')
                    ->get();

                $grilla_res_af = DB::table('op_documentos_internos')
                    ->whereYear('fechadocint', date('Y'))
                    ->where('tipos_docs_internos_iddocsint', 2)
                    ->orderBy('foliodocint', 'desc')
                    ->get();

                $grilla_ord = DB::table('op_documentos_internos')
                    ->whereYear('fechadocint', date('Y'))
                    ->where('tipos_docs_internos_iddocsint', 3)
                    ->orderBy('foliodocint', 'desc')
                    ->get();

                $grilla_total = DB::table('op_documentos_internos')
                    ->join('op_tipos_docs_internos', 'op_tipos_docs_internos.iddocsint', 'op_documentos_internos.tipos_docs_internos_iddocsint')
                    ->whereYear('fechadocint', date('Y'))
                    ->take(10)
                    ->orderby('foliodocint', 'desc')
                    ->get();

                return view('back_end.documentos_internos.gestion_docs_internos', [
                    'grilla_res_ex' => $grilla_res_ex,
                    'grilla_res_af' => $grilla_res_af,
                    'grilla_ord' => $grilla_ord,
                    'grilla_total' => $grilla_total
                ]);
            } else {
                DB::table('sys_acc_denegado')->insert([
                    'fecregistro' => date('Y-m-d H:i:s'),
                    'ip' => \Request::ip(),
                    'tipo' => 'NIVEL',
                    'modulo' => 'GESTION DOCUMENTO',
                    'sys_sistemas_idsistemasgore' => 1,
                    'users_id' => Auth::id()
                ]);
                return view('back_end.acc_denegado');
            }
        } else {
            DB::table('sys_acc_denegado')->insert([
                'fecregistro' => date('Y-m-d H:i:s'),
                'ip' => \Request::ip(),
                'tipo' => 'SISTEMA',
                'sys_sistemas_idsistemasgore' => 1,
                'users_id' => Auth::id()
            ]);
            return view('back_end.acc_denegado');
        }
    } // SEGURIDAD OK

    public
    function ficha_docs_interno(Request $request)
    {

        $id = $request->idficdocint;

        $funcionarios = DB::table('listado_funcionarios')
            ->OrderBy('paternofunc', 'ASC')
            ->get();

        $tipo_doc = DB::table('op_documentos_internos')
            ->select('tipos_docs_internos_iddocsint')
            ->where('iddocint', '=', $id)
            ->get();

        if ($tipo_doc[0]->tipos_docs_internos_iddocsint == 1) {
            $bitacora = DB::table('op_documentos_internos')
                ->join('op_bitacora_docs_internos', 'op_documentos_internos.iddocint', 'op_bitacora_docs_internos.documentos_internos_iddocint')
                ->join('op_tipos_docs_internos', 'op_tipos_docs_internos.iddocsint', 'op_documentos_internos.tipos_docs_internos_iddocsint')
                ->join('listado_funcionarios', 'listado_funcionarios.idfunc', 'op_documentos_internos.listado_funcionarios_idfunc')
                ->join('users', 'users.id', 'op_documentos_internos.users_id')
                ->where('iddocint', '=', $id)
                ->orderby('op_bitacora_docs_internos.idbitdocint', 'DESC')
                ->get();

        } elseif ($tipo_doc[0]->tipos_docs_internos_iddocsint == 2) {
            $bitacora = DB::table('op_documentos_internos')
                ->join('op_bitacora_docs_internos', 'op_documentos_internos.iddocint', 'op_bitacora_docs_internos.documentos_internos_iddocint')
                ->join('op_tipos_docs_internos', 'op_tipos_docs_internos.iddocsint', 'op_documentos_internos.tipos_docs_internos_iddocsint')
                ->join('users', 'users.id', 'op_documentos_internos.users_id')
                ->where('iddocint', '=', $id)
                ->orderby('op_bitacora_docs_internos.idbitdocint', 'DESC')
                ->get();
        } elseif ($tipo_doc[0]->tipos_docs_internos_iddocsint == 3) {
            $bitacora = DB::table('op_documentos_internos')
                ->join('op_bitacora_docs_internos', 'op_documentos_internos.iddocint', 'op_bitacora_docs_internos.documentos_internos_iddocint')
                ->join('op_tipos_docs_internos', 'op_tipos_docs_internos.iddocsint', 'op_documentos_internos.tipos_docs_internos_iddocsint')
                ->join('users', 'users.id', 'op_documentos_internos.users_id')
                ->where('iddocint', '=', $id)
                ->orderby('op_bitacora_docs_internos.idbitdocint', 'DESC')
                ->get();
        }

        $dist_interna = DB::table('op_det_dist_docs_int')
            ->join('op_grupos_dis_internos', 'op_grupos_dis_internos.idgrpdisint', 'op_det_dist_docs_int.grupos_dis_internos_idgrpdisint')
            ->select('nomgrpdisint')
            ->where('documentos_internos_iddocint', $id)
            ->get();

        $dist_externa = DB::table('op_det_dist_docs_ext')
            ->join('op_grupos_dis_externos', 'op_grupos_dis_externos.idgrpdisext', 'op_det_dist_docs_ext.grupos_dis_externos_idgrpdisext')
            ->where('documentos_internos_iddocint', $id)
            ->get();

        $pdf = DB::table('op_documentos_internos')
            ->where('iddocint', '=', $id)
            ->first();

        $entregas = DB::table('op_lec_doc_int')
            ->join('listado_funcionarios', 'listado_funcionarios.idfunc', 'op_lec_doc_int.listado_funcionarios_idfunc')
            ->where('op_documentos_internos_iddocint', '=', $id)
            ->orderby('idlecdocint')
            ->get();

        return view('back_end.documentos_internos.ficha_docs_interno', [
            'funcionarios' => $funcionarios,
            'bitacora' => $bitacora,
            'dis_int' => $dist_interna,
            'dis_ext' => $dist_externa,
            'pdf' => $pdf,
            'entregas' => $entregas
        ]);

    }

    public
    function guardar_envio_interno(Request $request)
    {

        //print_r($request->nomfucdocint);
        //die();
        $id_lectura = DB::table('op_lec_doc_int')->insertGetId([
            'disdocintfunc' => 3,
            'recepfuncdocint' => 0,
            'lectfuncdocint' => 0,
            'estadolectdocint' => 1,
            'listado_funcionarios_idfunc' => $request->nomfuncpdocint,
            'op_documentos_internos_iddocint' => $request->iddocint
        ]);

        $datos_correo = DB::table('op_lec_doc_int')
            ->join('listado_funcionarios', 'listado_funcionarios.idfunc', 'op_lec_doc_int.listado_funcionarios_idfunc')
            ->where('idlecdocint', $id_lectura)
            ->first();

        $datos_correo2 = DB::table('op_documentos_internos')
            ->where('iddocint', $request->iddocint)
            ->first();

        $data_correo = array(
            'fecha' => date('Y-m-d H:i:s'),
            'materia' => $datos_correo2->matdocint,
            'tipodoc' => 'REENVIO DOCUMENTO INTERNO',
            'numdoc' => $datos_correo2->foliocompdocint,
            'referencia' => $datos_correo2->refdocint
        );

        Mail::to($datos_correo->mailfunc)
            ->send(new AvisoReEnvioDocumentoInterno($data_correo));

        // Bitácora //
        DB::table('op_bitacora_docs_internos')->insert([
            'accbitdocint' => 'Distribuye Documento a Funcionario',
            'tipoaccbitdocint' => 2,
            'fecbitdocint' => date('Y-m-d'),
            'horabitdocint' => date('h:i:s'),
            'obsenvficdocint' => $request->obssolint,
            'forsoldocint' => $request->forsolint,
            'refsolenvdocint' => $request->refsolint,
            'cpbitdocint' => $request->nomfuncpdocint,
            'documentos_internos_iddocint' => $request->iddocint,
            'users_id' => 1,                                            //PENDIENTE AUTH !!!
        ]);

        echo '1';
    }

    public
    function guardar_obs_b_interno_cgr(Request $request)
    {

        // Bitácora //
        DB::table('op_bitacora_docs_internos')->insert([
            'accbitdocint' => 'Observaciones Anotadas a Posterior',
            'tipoaccbitdocint' => 5,
            'fecbitdocint' => date('Y-m-d'),
            'horabitdocint' => date('h:i:s'),
            'obsenvficdocint' => null,
            'forsoldocint' => null,
            'refsolenvdocint' => null,
            'obspostdocint' => $request->obsbitdocint,
            'segobspostint' => $request->segobsintdocint,
            'cpbitdocint' => null,
            'documentos_internos_iddocint' => $request->iddocint,
            'users_id' => 1,                                            //PENDIENTE AUTH !!!
        ]);

        echo '1';
    }

    public
    function guardar_envio_interno_cgr(Request $request)
    {

        //Actualiza Tabla de Documentos Internos

        $id = $request->iddocintresaf;

        DB::table('op_documentos_internos')
            ->where('iddocint', $id) // Cambiar por ID Formulario
            ->update([
                'feccgrdocint' => date('Y-m-d', strtotime($request->fechoraingcgr)),
                'horacgrdocint' => date('H:i:s', strtotime($request->fechoraingcgr))
            ]);

        //Bitácora //
        DB::table('op_bitacora_docs_internos')->insert([
            'accbitdocint' => 'Envío a Contraloría',
            'tipoaccbitdocint' => 3,
            'fecbitdocint' => date('Y-m-d'),
            'horabitdocint' => date('h:i:s'),
            'documentos_internos_iddocint' => $id,
            'users_id' => 1,                                            //PENDIENTE AUTH !!!
        ]);

        echo '1';
    }

    public
    function guardar_recep_interno_cgr(Request $request)
    {

        $id = $request->iddocintresaf;

        DB::table('op_documentos_internos')
            ->where('iddocint', $id) // Cambiar por ID Formulario
            ->update([
                'fecreccgrdocint' => date('Y-m-d', strtotime($request->reccgrdocint)),
                'horareccgrdocint' => date('H:i:s', strtotime($request->reccgrdocint)),
                'respcgrdocint' => $request->estcgrdocint
            ]);

        //Bitácora //
        DB::table('op_bitacora_docs_internos')->insert([
            'accbitdocint' => 'Recepción por parte de Contraloría',
            'tipoaccbitdocint' => 4,
            'fecbitdocint' => date('Y-m-d'),
            'horabitdocint' => date('h:i:s'),
            'documentos_internos_iddocint' => $id,
            'users_id' => 1,                                            //PENDIENTE AUTH !!!
        ]);

        echo '1';
    }

    public function gestion_mantenedores()
    {

        $accesos = DB::table('sys_acc_sistemas')
            ->where([
                ['users_id', Auth::user()->id]
            ])
            ->first();
        if ($accesos->sys_sistemas_idsistemasgore == 1 && $accesos->estadoacc == 1) {
            if ($accesos->nivelacc == 1) {
                $grupos_internos = DB::table('op_grupos_dis_internos')
                    ->where('nomgrpdisint', '<>', 'NO APLICA')
                    ->orderby('nomgrpdisint')
                    ->get();

                $grupos_externos = DB::table('op_grupos_dis_externos')
                    ->where('tiposervdisext', '<>', 'NO')
                    ->orderby('tiposervdisext')
                    ->orderby('nomgrpdisext')
                    ->get();

                $conta_gi = DB::table('op_grupos_dis_internos')->count();

                $conta_ge = DB::table('op_grupos_dis_externos')->count();

                $funcionarios = DB::table('listado_funcionarios')
                    ->orderby('paternofunc')
                    ->orderby('maternofunc')
                    ->get();

                $grupos_internos_grilla = DB::table('op_detalle_grupos_int')
                    ->join('op_grupos_dis_internos', 'op_grupos_dis_internos.idgrpdisint', 'op_detalle_grupos_int.grupos_dis_internos_idgrpdisint')
                    ->join('listado_funcionarios', 'listado_funcionarios.idfunc', 'op_detalle_grupos_int.listado_funcionarios_idfunc')
                    ->orderby('nomgrpdisint')
                    ->get();

                return view('back_end.documentos_internos.mantenedores', [
                    'grupos_internos' => $grupos_internos,
                    'grupos_externos' => $grupos_externos,
                    'funcionarios' => $funcionarios,
                    'grilla_gi' => $grupos_internos_grilla,
                    'conta_gi' => $conta_gi,
                    'conta_ge' => $conta_ge
                ]);
            } else {
                DB::table('sys_acc_denegado')->insert([
                    'fecregistro' => date('Y-m-d H:i:s'),
                    'ip' => \Request::ip(),
                    'tipo' => 'NIVEL',
                    'modulo' => 'MANTENEDORES',
                    'sys_sistemas_idsistemasgore' => 1,
                    'users_id' => Auth::id()
                ]);
                return view('back_end.acc_denegado');
            }
        } else {
            DB::table('sys_acc_denegado')->insert([
                'fecregistro' => date('Y-m-d H:i:s'),
                'ip' => \Request::ip(),
                'tipo' => 'SISTEMA',
                'sys_sistemas_idsistemasgore' => 1,
                'users_id' => Auth::id()
            ]);
            return view('back_end.acc_denegado');
        }

    } // SEGURIDAD OK

    public function guardar_grupo_dis_int(Request $request)
    {

        $func_array = $request->idfuncgrpdocint;

        foreach ($func_array as $key => $value) {

            $idcompunic = DB::table('op_detalle_grupos_int')
                ->where('idcompunic', '=', 'G' . $request->idgrupdocint . '-F' . $func_array[$key])
                ->count();

            if ($idcompunic == 0) {
                DB::table('op_detalle_grupos_int')->insert([
                    'idcompunic' => 'G' . $request->idgrupdocint . '-F' . $func_array[$key],
                    'fecingresofun' => date('Y-m-d H:i:s'),
                    'estadositdetfunc' => 1,
                    'listado_funcionarios_idfunc' => $func_array[$key],
                    'grupos_dis_internos_idgrpdisint' => $request->idgrupdocint,
                ]);
            } else {
                return e();
            }
        }
        echo '1';
    }

    public function hab_des_mante_fun_grp(Request $request)
    {

        $idregbd = $request->idfungrpdocint;
        $habdeshab = $request->hab;

        if ($habdeshab == 0) {
            DB::table('op_detalle_grupos_int')
                ->where('iddetallegrpint', $idregbd) // Cambiar por ID Formulario
                ->update([
                    'estadositdetfunc' => 0
                ]);

            return back();
        } elseif ($habdeshab == 1) {
            DB::table('op_detalle_grupos_int')
                ->where('iddetallegrpint', $idregbd) // Cambiar por ID Formulario
                ->update([
                    'estadositdetfunc' => 1
                ]);

            return back();
        }

    }

    public function guardar_grupo_int(Request $request)
    {

        DB::table('op_grupos_dis_internos')->insert([
            'nomgrpdisint' => $request->nomgrupdocint,
            'estgrpdisint' => 1
        ]);

        echo '1';

    }

    public function guardar_grupo_ext(Request $request)
    {
        DB::table('op_grupos_dis_externos')->insert([
            'tiposervdisext' => $request->tipoinstgrpext,
            'nomgrpdisext' => $request->nombreinstgrpext,
            'estgrpdisext' => 1
        ]);

        echo '1';
    }

    public function buscar_registros()
    {


        return view('back_end.documentos_internos.buscar');

    }

    public
    function acceso_denegado()
    {
        return view('back_end.acc_denegado');
    }

    public function bloquear_doc(Request $request)
    {

        $id_reg_hab = $request->id_reg_hab;
        $tipo_bloqueo = $request->tipo_bloqueo;

        if ($tipo_bloqueo == 1) {
            DB::table('op_lec_doc_int')
                ->where('idlecdocint', $id_reg_hab) // Cambiar por ID Formulario
                ->update([
                    'estadolectdocint' => 1
                ]);

            return back();

        } elseif ($tipo_bloqueo == 0) {
            DB::table('op_lec_doc_int')
                ->where('idlecdocint', $id_reg_hab) // Cambiar por ID Formulario
                ->update([
                    'estadolectdocint' => 0
                ]);

            return back();
        }

    }

    public function documentos_erroneos()
    {

        $grilla_pend = DB::table('op_error_docs_int')
            ->join('op_documentos_internos', 'op_documentos_internos.iddocint', 'op_error_docs_int.op_documentos_internos_iddocint')
            ->join('listado_funcionarios', 'listado_funcionarios.idfunc', 'op_error_docs_int.listado_funcionarios_idfunc')
            ->where('estadoerrdocint', 0) // No Corregido.
            ->get();

        $grilla_corre = DB::table('op_error_docs_int')
            ->join('op_documentos_internos', 'op_documentos_internos.iddocint', 'op_error_docs_int.op_documentos_internos_iddocint')
            ->join('listado_funcionarios', 'listado_funcionarios.idfunc', 'op_error_docs_int.listado_funcionarios_idfunc')
            ->join('users', 'users.id', 'op_error_docs_int.users_id')
            ->where('estadoerrdocint', 1) //Corregido.
            ->get();

        return view('back_end.documentos_internos.erroneos',
            [
                'grilla_pendientes' => $grilla_pend,
                'grilla_corregidos' => $grilla_corre
            ]);

    }

    public function ficha_error_docs(Request $request)
    {

        $id_doc_int = $request->id_doc_erroneo;
        $iderror = $request->id_error;

        $info_doc_int = DB::table('op_documentos_internos')
            ->join('op_tipos_docs_internos', 'op_tipos_docs_internos.iddocsint', 'op_documentos_internos.tipos_docs_internos_iddocsint')
            ->where('iddocint', $id_doc_int) // No Corregido.
            ->first();

        return view('back_end.documentos_internos.ficha_error', [
            'info' => $info_doc_int,
            'error' => $iderror
        ]);

    }

    public function guardar_doc_correg(Request $request)
    {

        $iddocerr = $request->iddocint;
        $nueva_mat = $request->matbitdocint;
        $tipo = 'CORRECCION';
        $annio = date("Y");
        $file = $request->file('arcdocint');
        $name = $annio . '-' . $tipo . '-' . time() . '-' . $file->getClientOriginalName();
        $file->move(public_path() . '/StoragePartes/', $name);

        DB::table('op_documentos_internos')
            ->where('iddocint', $iddocerr)
            ->update([
                'matdocint' => $nueva_mat,
                'urldocint' => $name,
                'obsdocint' => $request->ingobsdocint,
                'refdocint' => $request->ingrefdocint
            ]);

        $iderror = $request->idferror;

        DB::table('op_error_docs_int')
            ->where('iderrdocint', $iderror)
            ->update([
                'feccorrerrint' => date('Y-m-d h:i:s'),
                'estadoerrdocint' => 1,
                'users_id' => Auth::user()->id
            ]);

        // BITACORA

        DB::table('op_bitacora_docs_internos')->insert([
            'accbitdocint' => 'Notificación de Corrección al Documento',
            'tipoaccbitdocint' => 7,
            'fecbitdocint' => date('Y-m-d'),
            'horabitdocint' => date('h:i:s'),
            'forsoldocint' => null,
            'documentos_internos_iddocint' => $iddocerr,
            'users_id' => Auth::user()->id
        ]);

        //Notifica Reparacion del Documento
        //ENVIA CORREO ELECTRONICO AL USUARIO QUE REPORTA

        return $this->documentos_erroneos();

    }

    public
    function archivo2020()
    {

        $accesos = DB::table('sys_acc_sistemas')
            ->where([
                ['users_id', Auth::user()->id]
            ])
            ->first();
        if ($accesos->sys_sistemas_idsistemasgore == 1 && $accesos->estadoacc == 1) {
            if ($accesos->nivelacc == 1 || $accesos->nivelacc == 2) {
                $grilla_res_ex = DB::table('op_documentos_internos')
                    ->join('listado_funcionarios', 'listado_funcionarios.idfunc', 'op_documentos_internos.listado_funcionarios_idfunc')
                    ->whereYear('fechadocint', '2020')
                    ->where('tipos_docs_internos_iddocsint', 1)
                    ->orderBy('foliodocint', 'desc')
                    ->get();

                $grilla_res_af = DB::table('op_documentos_internos')
                    ->whereYear('fechadocint', '2020')
                    ->where('tipos_docs_internos_iddocsint', 2)
                    ->orderBy('foliodocint', 'desc')
                    ->get();

                $grilla_ord = DB::table('op_documentos_internos')
                    ->whereYear('fechadocint', '2020')
                    ->where('tipos_docs_internos_iddocsint', 3)
                    ->orderBy('foliodocint', 'desc')
                    ->get();

                $grilla_total = DB::table('op_documentos_internos')
                    ->join('op_tipos_docs_internos', 'op_tipos_docs_internos.iddocsint', 'op_documentos_internos.tipos_docs_internos_iddocsint')
                    ->whereYear('fechadocint', '2020')
                    ->take(10)
                    ->orderby('foliodocint', 'desc')
                    ->get();

                return view('back_end.documentos_internos.archivo2020', [
                    'grilla_res_ex' => $grilla_res_ex,
                    'grilla_res_af' => $grilla_res_af,
                    'grilla_ord' => $grilla_ord,
                    'grilla_total' => $grilla_total
                ]);
            } else {
                DB::table('sys_acc_denegado')->insert([
                    'fecregistro' => date('Y-m-d H:i:s'),
                    'ip' => \Request::ip(),
                    'tipo' => 'NIVEL',
                    'modulo' => 'GESTION DOCUMENTO',
                    'sys_sistemas_idsistemasgore' => 1,
                    'users_id' => Auth::id()
                ]);
                return view('back_end.acc_denegado');
            }
        } else {
            DB::table('sys_acc_denegado')->insert([
                'fecregistro' => date('Y-m-d H:i:s'),
                'ip' => \Request::ip(),
                'tipo' => 'SISTEMA',
                'sys_sistemas_idsistemasgore' => 1,
                'users_id' => Auth::id()
            ]);
            return view('back_end.acc_denegado');
        }
    }
}

