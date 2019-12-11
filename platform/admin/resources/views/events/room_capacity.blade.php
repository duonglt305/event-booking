@extends('admin::layouts.master')
@push('plugin-css')
    <link rel="stylesheet" href="{{ asset('admin/vendors/chartjs/Chart.min.css') }}">
@endpush
@section('content')
    <div class="d-flex flex-lg-row flex-column justify-content-between align-items-center pb-4">
        <div>
            <h3 class="title mb-lg-0 mb-2">{{ $event->name }}</h3>
            <p class="text-muted">{{ $event->dateFormatted }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12"><div class="card card-statistics">
                <div class="card-body">
                    <canvas id="event_room_capacity" data-url="{{ route('events.room_capacity', $event->id) }}"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop
@push('plugin-js')
    <script src="{{ asset('admin/vendors/chartjs/Chart.min.js') }}"></script>
@endpush
@push('js')
    <script src="{{ asset('js/room_capacity.js') }}"></script>
@endpush
