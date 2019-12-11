@extends('admin::auth.layouts.master')

@section('content')
    <div class="col-md-4 banner-section d-none d-md-flex align-items-stretch justify-content-center">
        <div class="slide-content bg-1"> </div>
    </div>
    <div class="col-12 col-md-8 h-100 bg-white">
        <div class="auto-form-wrapper d-flex align-items-center justify-content-center flex-column">
            <div class="nav-get-started">
                <a class="btn get-started-btn" href="{{ route('login') }}">Sign in</a>
                <a class="btn get-started-btn" href="{{ route('register') }}">Sign up</a>
            </div>
            <form action="{{ route('reset_password') }}" method="post">
                <h3 class="mr-auto text-uppercase">Reset Password</h3>
                @if($success)
                    <div class="form-group">
                        Reset password successful. Go to <a href="{{ route('login') }}">login</a>
                    </div>
                @elseif(empty($passwordReset))
                    <div class="form-group">
                        Token is invalid please to <a href="{{ route('forgot_password') }}">there</a> and resend email to reset password
                    </div>
                @elseif(!$isPass)
                    @csrf
                    <div class="form-group">
                        <label for="password" class="sr-only">Password</label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" value="{{ old('password') ?? '' }}" autofocus>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="sr-only">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Password Confirmation" value="" autofocus>
                        @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <p class="text-success text-small">{{ session()->get('message') }}</p>
                    </div>
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group text-right">
                        <button class="btn btn-primary submit-btn text-uppercase">Reset password</button>
                    </div>
                @else
                    <div class="form-group">
                        Token is invalid please to <a href="{{ route('forgot_password') }}">there</a> and resend email to reset password
                    </div>
                @endif
                <div class="wrapper mt-5 text-gray">
                    <p class="footer-text">Copyright © 2019 DGD Team. All rights reserved.</p>
                </div>
            </form>
        </div>
    </div>
@stop
