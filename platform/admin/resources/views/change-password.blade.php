@extends('admin::layouts.master')
@section('content')
    <div class="d-flex flex-lg-row flex-column justify-content-between align-items-center pb-4">
        <h4 class="title mb-lg-0 mb-2">Change Password</h4>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('organizer.change_password') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="password_old">Current password <span class="text-danger">*</span></label>
                            <input type="password" name="password_old" id="password_old"
                                   class="form-control @error('password_old') is-invalid @enderror" placeholder="Current password"
                                   value="{{ old('password_old') ?? '' }}">
                            @error('password_old')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_new">New password <span class="text-danger">*</span></label>
                            <input type="password" name="password_new" id="password_new"
                                   class="form-control @error('password_new') is-invalid @enderror" pattern="^[a-z0-9-]+(?:[a-z0-9]+)*$" placeholder="New password"
                                   value="{{ old('password_new') }}">
                            @error('password_new')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_new_confirmation">Confirm password <span class="text-danger">*</span></label>
                            <input type="password" name="password_new_confirmation" id="password_new_confirmation"
                                   class="form-control @error('slug') is-invalid @enderror" pattern="^[a-z0-9-]+(?:[a-z0-9]+)*$" placeholder="Confirm password"
                                   value="{{ old('password_new_confirmation') }}">
                            @error('password_new_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-primary">Save change</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
    <script type="application/javascript">
        @if(session()->has('success'))
        $.toast({
            heading: 'Notification',
            text: '{{ session()->get('success')['message']  }}',
            showHideTransition: 'slide',
            icon: 'success',
            loaderBg: '#f2a654',
            position: 'top-right',
            hideAfter: 5000,
        });
        @elseif(session()->has('failed'))
        $.toast({
            heading: 'Notification',
            text: '{{ session()->get('failed')['message']  }}',
            showHideTransition: 'slide',
            icon: 'success',
            loaderBg: '#f2a654',
            position: 'top-right',
            hideAfter: 5000,
        });
        @endif
    </script>
@endpush
