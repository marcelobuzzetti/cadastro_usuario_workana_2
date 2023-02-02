<?php

namespace App\Jobs;

use App\Mail\Ativacao;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class AtivacaoQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $assunto;
    protected $email;
    protected $registro;
    protected $nome;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($assunto, $email, $registro, $nome)
    {
        $this->assunto = $assunto;
        $this->email = $email;
        $this->registro = $registro;
        $this->nome = $nome;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email, $this->nome)->send(new Ativacao($this->registro, $this->assunto));
    }
}
