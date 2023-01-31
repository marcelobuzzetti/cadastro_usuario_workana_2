<?php

namespace App\Jobs;

use App\Mail\FaltaDeAcesso;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class CadastroOnlineQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $assunto;
    protected $email;
    protected $mensagem;
    protected $nome;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($assunto, $email, $mensagem, $nome)
    {
        $this->assunto = $assunto;
        $this->email = $email;
        $this->mensagem = $mensagem;
        $this->nome = $nome;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email, $this->nome)->send(new FaltaDeAcesso($this->mensagem, $this->assunto));
    }
}
