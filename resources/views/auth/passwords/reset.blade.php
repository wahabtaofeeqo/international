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
                                    <h1 class="h4 text-gray-900 mb-2">Reset Password</h1>
                                </div>
                                <form class="user" method="POST" action="{{ route('password.update') }}">
                                    @csrf

                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" aria-describedby="emailHelp" placeholder="Enter Email Address..." name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" aria-describedby="passwordHelp" placeholder="Enter a new password" name="password" required autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" aria-describedby="passwordConfirmHelp" placeholder="Confirm password" name="password_confirmation" required autocomplete="new-password">
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Reset Password
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
