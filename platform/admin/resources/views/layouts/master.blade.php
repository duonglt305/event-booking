@extends('admin::layouts.base')
@section('page')
    @include('admin::layouts.components.navbar')

    <div class="container-fluid page-body-wrapper">
        @include('admin::layouts.components.sidebar')

        <div class="main-panel">
            <div class="content-wrapper">
                @yield('content')
                @include('admin::layouts.components.footer')
            </div>
        </div>
    </div>
@stop

@push('plugin-js')
    <script src="{{ asset('admin/js/pusher.min.js') }}"></script>
@endpush
@push('js')
    <script src="{{ asset('js/notify.js') }}"></script>
@endpush
