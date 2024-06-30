<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            return $next($request);
        }

        // ログインしていない場合はログインページにリダイレクト
        return redirect()->route('login')->with('error', 'このページにアクセスするにはログインが必要です。');
    }
}
