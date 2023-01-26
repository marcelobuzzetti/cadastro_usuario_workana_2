<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FaltaDeAcesso extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $mensagem;
    public $assunto;

    public function __construct($mensagem, $assunto)
    {
        $this->mensagem = $mensagem;
        $this->assunto = $assunto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.faltaacesso')
        ->text( 'emails.faltaacesso_text' )
        ->subject($this->assunto)
        ->with([
            'mensagem' => $this->mensagem
        ]);
    }
}
