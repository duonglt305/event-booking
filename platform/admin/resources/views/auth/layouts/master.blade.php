@extends('admin::layouts.base')
@section('page')
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper auth p-0 theme-two">
            <div class="row d-flex align-items-stretch">
                @yield('content')
            </div>
        </div>
    </div>
@stop

