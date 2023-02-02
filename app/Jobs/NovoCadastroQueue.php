<?php

namespace App\Jobs;

use App\Mail\NovoCadastro;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NovoCadastroQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $assunto;
    protected $email;
    protected $cadastro;
    protected $nome;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($assunto, $email, $cadastro, $nome)
    {
        $this->assunto = $assunto;
        $this->email = $email;
        $this->cadastro = $cadastro;
        $this->nome = $nome;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email, $this->nome)->send(new NovoCadastro($this->cadastro, $this->assunto));
    }
}
