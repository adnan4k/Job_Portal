<?php

namespace App\Http\Middleware;

use Closure;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class donotAllowUserToMakePayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user()->billing_ends > date('Y-m-d')){
            return redirect()->route('dashboard')->with('error','already paid member');
        }
        return $next($request);
    }
}
