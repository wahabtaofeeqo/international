<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
    	return $this->middleware('auth');
    }

    public function index()
    {
    	if (!Auth::user()->city) {
            return redirect('register/complete');
        }

    	return view('home');
    }
}
