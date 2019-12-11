<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ get_page_title() }}</title>

    <link rel="stylesheet" href="{{ asset('admin/vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/iconfonts/font-awesome/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/iconfonts/puse-icons-feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendors/css/vendor.bundle.addons.css') }}">
    @stack('plugin-css')
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/layouts.css') }}">
    {!! \Assets::renderHeader() !!}
    <style>
        .sidebar-icon-only  .event-title{
            display: none;
        }
    </style>
    @stack('css')
    <link rel="shortcut icon" href="{{ asset(config('core.app-favicon')) }}"/>
</head>
<body class="sidebar-fixed">
<div class="container-scroller">
    @yield('page')
    @yield('model')
</div>
<script src="{{ asset('admin/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('admin/vendors/js/vendor.bundle.addons.js') }}"></script>
@stack('plugin-js')
<script src="{{ asset('admin/js/off-canvas.js') }}"></script>
<script src="{{ asset('admin/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('admin/js/misc.js') }}"></script>
{!! \Assets::renderFooter() !!}
@stack('js')
</body>
</html>
