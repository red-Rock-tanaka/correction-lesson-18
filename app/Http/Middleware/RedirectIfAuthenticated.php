<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // 認証済みのユーザーがログインページにアクセスした場合はリダイレクトしない
                if ($request->is('login')) {
                    return $next($request); // リダイレクトを行わず、リクエストを続行
                }
                // それ以外の場合は、適切なページにリダイレクト
                return redirect('/login'); // ここを適切なページに変更
            }
        }

        return $next($request);
    }
}
