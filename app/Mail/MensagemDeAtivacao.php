<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MensagemDeAtivacao extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.mensagemdeativacao')
        ->text( 'emails.mensagemdeativacao_text' )
        ->subject('Ativação de Conta')
        ->with([
            'mensagem' => 'Sua conta foi ativada'
        ]);
    }
}
