<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AvisoDocumentoInterno extends Mailable
{
    use Queueable, SerializesModels;
    protected $mailData;

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    public function build()
    {
        $mailData = array(
            'fechaBitDist' => $this->mailData['fecha'],
            'materia' => $this->mailData['materia'],
            'tipodoc' => $this->mailData['tipodoc'],
            'numdoc' => $this->mailData['numdoc'],
            'referencia' => $this->mailData['referencia']
        );

        return $this->view('correos.avisodocint')
            ->with([
                'data' => $mailData
            ]);
    }
}
