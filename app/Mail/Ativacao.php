<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Ativacao extends Mailable
{
    use Queueable, SerializesModels;

    public $assunto;
    public $registro;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($registro, $assunto)
    {
        $this->assunto = $assunto;
        $this->registro = $registro;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.ativacao')
        ->text( 'emails.ativacao_text' )
        ->subject($this->assunto)
        ->with([
            'registro' => $this->registro
        ]);
    }
}
