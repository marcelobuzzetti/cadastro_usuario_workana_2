<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CadastroOnline extends Mailable
{
    use Queueable, SerializesModels;

    public $mensagem;
    public $assunto;
    /**
     * Create a new message instance.
     *
     * @return void
     */
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
        return $this->view('emails.cadastroonline')
        ->text( 'emails.cadastroonline_text' )
        ->subject($this->assunto)
        ->with([
            'mensagem' => $this->mensagem
        ]);
    }
}
