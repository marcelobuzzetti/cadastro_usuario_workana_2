<?php

namespace App\Jobs;

use App\Mail\FaltaDeAcesso;
use App\Models\Registro;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $assunto;
    protected $emails;
    protected $mensagem;
    public $timeout = 7200; // 2 hours

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($assunto, $emails, $mensagem)
    {
        $this->assunto = $assunto;
        $this->emails = $emails;
        $this->mensagem = $mensagem;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
            Mail::to($this->emails)->send(new FaltaDeAcesso($this->mensagem, $this->assunto));
    }
}
