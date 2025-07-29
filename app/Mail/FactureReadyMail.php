<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class FactureReadyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $facture;
    public $commande;
    public $paniers;

    public function __construct($facture, $commande, $paniers)
    {
        $this->facture = $facture;
        $this->commande = $commande;
        $this->paniers = $paniers;
    }

    public function build()
    {
        $pdf = Pdf::loadView('facture.pdf', [
            'facture' => $this->facture,
            'commande' => $this->commande,
            'paniers' => $this->paniers
        ]);

        return $this->subject('Votre commande est prête')
                    ->markdown('emails.facture_ready')
                    ->attachData($pdf->output(), 'facture_'.$this->facture->id.'.pdf');
    }
}
