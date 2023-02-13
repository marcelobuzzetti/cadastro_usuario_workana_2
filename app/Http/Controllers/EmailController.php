<?php

namespace App\Http\Controllers;

use App\Mail\FaltaDeAcesso;
use App\Models\Registro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index(){
        $registros = Registro::whereNotNull('Email')->where('Email', '!=', ' ')->distinct()->get(['Email']);
        return view('emails.index')->with('registros', $registros);
    }

    public function store(Request $request){

        /*$job = (new \App\Jobs\SendQueueEmail($request->assunto, $request->emails, $request->mensagem))
            	->delay(now()->addSeconds(2));

        dispatch($job);*/

        foreach($request->emails as $email){
            Mail::to($email)->send(new FaltaDeAcesso($request->mensagem, $request->assunto));
        }

        return redirect()->route('emailMarketing.index')->with('success', 'Emails enviados!');
    }

    public function emailMarketing(Request $request)
    {
        /* $details = [
    		'subject' => 'Test Notification'
    	];

        $job = (new \App\Jobs\SendQueueEmail($details, $emails, $mensagem))
            	->delay(now()->addSeconds(2));

        dispatch($job);
        echo "Mail send successfully !!"; */
    }
}
