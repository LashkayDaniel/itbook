<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RestrictRegistrationToOneAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = DB::table('users')->where('role_id', 1)->first();
        if ($user) {
            // редиректим на главную страницу, если у нас уже есть пользователь с такой ролью
            return response()->json(["admin not be created// redirect"]);//redirect("/");
        }
        return $next($request);
    }
}
