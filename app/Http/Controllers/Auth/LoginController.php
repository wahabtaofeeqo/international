<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /*
     * Set authenticated user's last_seen attribute before logout
    */
    public function logout(Request $request)
    {
        $request->user()->last_seen = now();
        $request->user()->save();

        $this->guard()->logout();

        return redirect()->route('index');
    }

    /*
     * Redirect users based on their role
    */
    // protected function redirectTo() 
    // {
    //     return app(\App\Http\Controllers\HomeController::class)->redirectAuthenticatedUserTo();
    // }
}
