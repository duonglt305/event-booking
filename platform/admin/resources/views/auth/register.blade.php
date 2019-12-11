@extends('admin::auth.layouts.master')

@section('content')
    <div class="col-md-4 banner-section d-none d-md-flex align-items-stretch justify-content-center">
        <div class="slide-content bg-2"> </div>
    </div>
    <div class="col-12 col-md-8 h-100 bg-white">
        <div class="auto-form-wrapper d-flex align-items-center justify-content-center flex-column">
            <div class="nav-get-started">
                <p>Already have an account?</p>
                <a class="btn get-started-btn" href="{{ route('login') }}">SIGN IN</a>
            </div>
            <form action="{{ route('register') }}" method="post">
                <h3 class="mr-auto">Register</h3>
                <p class="mb-5 mr-auto">Enter your details below.</p>
                @csrf
                <div class="form-group">
                    <label for="name" class="sr-only">Organizer name</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                           placeholder="Organizer name" value="{{ old('name') ?? '' }}" autofocus>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="phone" class="sr-only">Organizer phone</label>
                            <input type="tel" name="phone" id="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   placeholder="Organizer phone" value="{{ old('phone') ?? '' }}">
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="website" class="sr-only">Organizer website</label>
                            <input type="url" name="website" id="website"
                                   class="form-control @error('website') is-invalid @enderror"
                                   placeholder="Organizer website" value="{{ old('website') ?? '' }}">
                            @error('website')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="email" class="sr-only">Organizer email</label>
                    <input type="email" name="email" id="email"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Organizer email" value="{{ old('email') ?? '' }}">
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="password"
                                   class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="form-group">
                            <label for="password_confirmation" class="sr-only">Password confirm</label>
                            <input type="password" name="password_confirmation" id="password_confirmation "
                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                   placeholder="Password confirm">
                            @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="address" class="sr-only">Organizer address</label>
                    <textarea name="address" id="address" rows="3" class="form-control"
                              placeholder="Organizer address">{{ old('address') ?? '' }}</textarea>
                    @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description" class="sr-only">Description</label>
                    <textarea name="description" id="description" rows="3" class="form-control"
                              placeholder="Description">{{ old('description') ?? '' }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group text-right">
                    <button class="btn btn-primary submit-btn text-uppercase">Sign Up</button>
                </div>
                <div class="wrapper mt-5 text-gray">
                    <p class="footer-text">Copyright © 2019 DGD Team. All rights reserved.</p>
                </div>
            </form>
        </div>
    </div>
@stop
