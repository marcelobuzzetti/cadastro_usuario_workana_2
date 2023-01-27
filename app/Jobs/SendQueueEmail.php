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
    protected $details;
    public $timeout = 7200; // 2 hours

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /* $data = Registro::all(); */
        $data = [
            [
                'email' => 'marcelobuzzetti@gmail.com',
                'nome' => 'Marcelo'
            ],
            [
                'email' => 'ferreira.marcelo@eb.mil.br',
                'nome' => 'Marcelo'
            ]
        ];
        $mensagem = "Teste";
        $input['subject'] = $this->details['subject'];

        foreach ($data as $value) {
            $email = $value['email'];
            $name = $value['nome'];
            Mail::to($email, $name)->send(new FaltaDeAcesso($mensagem, $input['subject']));
        }
    }
}
