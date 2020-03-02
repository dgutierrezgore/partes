<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class PruebasController extends Controller
{

    public function pruebas()
    {

        $accesos = DB::table('sys_acc_sistemas')
            ->where([
                ['users_id', Auth::user()->id]
            ])
            ->first();
        if ($accesos->sys_sistemas_idsistemasgore == 1 && $accesos->estadoacc == 1) {
            if ($accesos->nivelacc == 1 || $accesos->nivelacc == 2) {
                echo '1 y 2';
            } else {
                echo 'NO AUTORIZADO';
            }

        } else {
            echo 'NO AUTORIZADO';
        }

    }

}
