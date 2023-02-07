<?php

namespace App\Http\Middleware;

use App\Models\Config;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailAtivacao
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $config = Config::latest()->first();
        if ($config && (Auth::check() && Auth::user()->perfil_id == 1)){
            return $next($request);
        } elseif(!$config && (Auth::check() && Auth::user()->perfil_id == 1)) {
            return response()->view('config.create', ['error' => 'Você precisa cadastrar o Email de Ativação!!!']);
        } else {
            return $next($request);
        }

    }
}
