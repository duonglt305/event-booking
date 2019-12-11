@extends('admin::layouts.master')

@section('content')
    <div class="row">
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <i class="mdi mdi-eventbrite text-danger icon-lg"></i>
                        </div>
                        <div class="float-right">
                            <p class="mb-0 text-right">Total Events</p>
                            <div class="fluid-container">
                                <h3 class="font-weight-medium text-right mb-0" id="total-events">0</h3>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mt-3 mb-0">
                        <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> <span id="total-event-info-un-complete"></span>
                    </p>
                    <p class="text-muted mt-3 mb-0">
                        <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> <span id="total-event-info-active-pending">Active / Pending</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <i class="mdi mdi-update text-warning icon-lg"></i>
                        </div>
                        <div class="float-right">
                            <p class="mb-0 text-right">Total ongoing events</p>
                            <div class="fluid-container">
                                <h3 class="font-weight-medium text-right mb-0" id="total-ongoing-events">0</h3>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mt-3 mb-0">
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <i class="mdi mdi-led-on text-success icon-lg"></i>
                        </div>
                        <div class="float-right">
                            <p class="mb-0 text-right">Total upcoming events</p>
                            <div class="fluid-container">
                                <h3 class="font-weight-medium text-right mb-0" id="total-upcoming-event">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <i class="mdi mdi-heart-half text-info icon-lg"></i>
                        </div>
                        <div class="float-right">
                            <p class="mb-0 text-right">Total took place events</p>
                            <div class="fluid-container">
                                <h3 class="font-weight-medium text-right mb-0" id="total-took-place-events">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header header-sm d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Most ratting events</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="most-event-rating-table">
                            <thead>
                            <tr class="bg-light rounded">
                                <th>Events</th>
                                <th class="text-center">Rating process</th>
                                <th class="text-center">Total rating</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-header header-sm">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title mb-0">Upcoming Event registration report</h4>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="event-registration-detail" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
    <script src="{{ asset('js/dashboard.js') }}"></script>
@endpush
