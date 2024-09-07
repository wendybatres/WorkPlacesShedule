<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectToCorrectPath
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('dashboard');
        }

        if (auth()->user()->isCustomer()) {
            return redirect()->route('customer');
        }

        return $next($request);
    }
}
