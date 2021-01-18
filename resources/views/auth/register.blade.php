@extends('layouts.register')

@section('title', 'Account Registration')
@section('description', 'Join ILA')
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
                                <!-- Embed Vue component for registration form -->
                                <register></register>

                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
