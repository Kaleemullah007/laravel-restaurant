<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd(Session::get("localization"));
        if (Session::get('localization') != null) {
            App::setLocale(Session::get('localization'));
        } else {
            Session::put('localization', 'en');
            App::setLocale(Session::get('localization'));
        }

        return $next($request);
    }
}
