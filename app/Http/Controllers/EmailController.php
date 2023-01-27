<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function emailMarketing(Request $request)
    {
        $details = [
    		'subject' => 'Test Notification'
    	];

        $job = (new \App\Jobs\SendQueueEmail($details))
            	->delay(now()->addSeconds(2));

        dispatch($job);
        echo "Mail send successfully !!";
    }
}
