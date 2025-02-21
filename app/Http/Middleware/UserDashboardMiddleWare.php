<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserDashboardMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {

    //     $creator=Auth::user();

    //     if($creator){
    //         if($creator->user_type =='admin'){
    //             return $next($request);
    //         }
    //         if($creator->user_type =='employee'){
    //             return redirect()->route('pos');
    //         }

    //     }
    //     return redirect()->route('login');

    // }

    public function handle($request, Closure $next)
    {
        // Get the currently authenticated user
        $creator = Auth::user();

        // // If the user is authenticated
        // if ($creator) {
        //     // Check the user_type

        if ($creator->user_type === 'admin' || $creator->user_type === 'superadmin') {
            // Allow admin to proceed with the request
            return $next($request);
        } elseif ($creator->user_type === 'employee') {
            return to_route('pos');
        }
        // Allow admin to proceed with the request

        return abort(403);

    }
}
