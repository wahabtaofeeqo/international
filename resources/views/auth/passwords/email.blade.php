@extends('layouts.register')

@section('title', 'Reset your Password')
@section('description', 'Reset your Password')
@section('page-background', 'bg-gradient-primary')

@section('content')
    <section class="auth-panel">
        <div class="container">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>

                        <div class="col-lg-7">
                            <div class="p-4">
                                <div class="text-center mb-3">
                                    <a href="/" class="btn btn-default">Return Home</a>
                                </div>

                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                    <p class="mb-4">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</p>
                                </div>

                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                
                                <form class="user" method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Send Password Reset Link
                                    </button>
                                </form>

                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route('register') }}">Create an Account</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="{{ route('login') }}">Login!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
