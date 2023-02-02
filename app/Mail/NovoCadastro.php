<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NovoCadastro extends Mailable
{
    use Queueable, SerializesModels;

    public $assunto;
    public $cadastro;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cadastro, $assunto)
    {
        $this->assunto = $assunto;
        $this->cadastro = $cadastro;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.novocadastro')
        ->text( 'emails.novocadastro_text' )
        ->subject($this->assunto)
        ->with([
            'cadastro' => $this->cadastro
        ]);
    }
}
