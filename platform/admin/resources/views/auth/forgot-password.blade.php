@extends('admin::auth.layouts.master')

@section('content')
    <div class="col-md-4 banner-section d-none d-md-flex align-items-stretch justify-content-center">
        <div class="slide-content bg-1"> </div>
    </div>
    <div class="col-12 col-md-8 h-100 bg-white">
        <div class="auto-form-wrapper d-flex align-items-center justify-content-center flex-column">
            <div class="nav-get-started">
                <a class="btn get-started-btn" href="{{ route('login') }}">Login</a>
            </div>
            <form action="{{ route('forgot_password') }}" method="post">
                <h3 class="mr-auto text-uppercase">Forgot Password</h3>
                @csrf
                <div class="form-group">
                    <label for="email" class="sr-only">Email</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') ?? '' }}" autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <p class="text-success text-small">{{ session()->get('message') }}</p>
                </div>
                <div class="form-group text-right">
                    <button class="btn btn-primary submit-btn text-uppercase">Send link</button>
                </div>
                <div class="wrapper mt-5 text-gray">
                    <p class="footer-text">Copyright © 2019 DGD Team. All rights reserved.</p>
                </div>
            </form>
        </div>
    </div>
@stop
