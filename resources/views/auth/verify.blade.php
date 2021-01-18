@extends('layouts.register')

@section('title', 'Account Verification')
@section('description', 'Verify your account')
@section('page-background', 'bg-gradient-primary')

@section('content')
    <section class="auth-panel">
        <div class="container">
            <div class="text-center">
                <a href="{{ route('index') }}" class="text-white">
                    Return Home
                </a>
            </div>
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>

                        <div class="col-lg-7">
                            <div class="p-5">
                                <a href="/" style="position: absolute; top: 0; left: 0" class="btn btn-return">Return Home</a>

                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Verify your account!</h1>
                                </div>
                                @if (session('resent'))
                                    <div class="alert alert-success" role="alert">
                                        {{ __('A fresh verification link has been sent to your email address.') }}
                                    </div>
                                @endif

                                {{ __('Before proceeding, please check your email for a verification link.') }}
                                {{ __('If you did not receive the email') }},
                                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                    @csrf
                                    
                                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
