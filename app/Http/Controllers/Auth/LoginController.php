<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $maxAttempts = 3; // Default is 5

    protected $decayMinutes = 1; // Default is 1

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware(['guest', 'avoid-back-history'])->except('logout');
    }

    //  /**
    //  * The user has been authenticated.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  mixed  $user
    //  * @return mixed
    //  */
    protected function authenticated(Request $request, $user)
    {

        if (is_null($user->email_verified_at) || $user->status == 0) {
            Auth::logout(); // Log out the user

            return redirect()->route('login')->withErrors([
                'email' => 'Your email is not verified or your account is inactive.',
            ]);
        }
        if ($user->user_type == 'customer' || $user->user_type == 'vendor') {
            Auth::logout(); // Log out the user

            return redirect()->route('login')->withErrors([
                'email' => 'You are not allowed to login in this system',
            ]);
        }

        if (! is_null($user->end_date) && ($user->end_date < date('d-m-Y')) && $user->user_type != 'superadmin') {
            $user->status = 0;
            $user->save();
            Auth::logout(); // Log out the user

            return redirect()->route('login')->withErrors([
                'email' => 'Your Account is expired.',
            ]);
        }

        // Set the session variable after successful login
        $locale = $user->preferred_language ?? 'en'; // Example: Assume 'preferred_language' is a user field
        if (! session()->has('localization')) {
            session()->put('localization', $locale);
        } else {
            $locale = session()->get('localization');
        }

        // Optionally, you could also set the application locale
        app()->setLocale($locale);
    }
}
