<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!Auth::user()->city) {
            return redirect('register/complete');
        }

        return $this->redirectAuthenticatedUserTo();
    }

    public function redirectAuthenticatedUserTo() 
    {
        $role = Auth::user()->role->name;

        switch ($role) {
            case 'super':
                return redirect()->route('super');
                break;

            case 'admin':
                return redirect()->route('admin');
                break;

            case 'editor':
                return redirect()->route('editor');
                break;

            case 'user':
                return redirect()->route('user');
                break;
            
            default:
                return redirect()->route('login');
                break;
        }
    }
}
