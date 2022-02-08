<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ControleAcesso
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        if (Auth::check() && (Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 3)) {
            return $next($request);
        }

        return redirect('/registros');
    }
}
