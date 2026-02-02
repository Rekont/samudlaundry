<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnlyCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    // Jika user login tapi rolenya adalah 'admin', arahkan ke dashboard admin
    if (auth()->check() && auth()->user()->role === 'admin') {
        return redirect('/admin'); 
    }

    return $next($request);
}
}
