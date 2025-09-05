<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $formattedCode;

    public function __construct($code)
    {
        $this->code = $code;
        // Format le code avec des espaces pour une meilleure lisibilité
        $this->formattedCode = implode(' ', str_split($code, 2));
    }

    public function build()
    {
        return $this->subject("Votre code de vérification")
                    ->view('emails.register-code')
                    ->with([
                        'code' => $this->code,
                        'formattedCode' => $this->formattedCode
                    ]);
    }
}