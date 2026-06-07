<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;


class Campexe
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }
        $user=Auth::user();
        if($user->role==5){
            return $next($request);
        }
        if($user->role==1){
            return redirect()->route('admin');
        }
        if($user->role==2){
            return redirect()->route('projectleader');
        }
    }
}
