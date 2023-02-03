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
    public $mensagem;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mensagem, $assunto)
    {
        $this->assunto = $assunto;
        $this->mensagem = $mensagem;
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
            'mensagem' => $this->mensagem
        ]);
    }
}
