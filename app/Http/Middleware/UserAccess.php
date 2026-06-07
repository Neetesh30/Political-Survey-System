<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        $user = Auth::user();

        if ($user && $user->role == $role) {
            return $next($request);
        }

        return response()->json(['message' => 'You do not have permission to access this page.'], 403);
    }
}
