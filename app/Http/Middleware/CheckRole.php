<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,... $roles): Response
    {
        $user = auth()->user()->usertype;
            if ($user == 2) {
                return $next($request);
            }
        return abort(403);

        // if (!auth()->check() || !auth()->user()->hasRole($usertype)) {
        //     return response()->json(['error' => 'Unauthorized'], 403);
        // }
        // return $next($request); 
    }
}
