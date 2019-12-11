@extends('admin::layouts.master')

@section('content')
    <div class="d-flex flex-lg-row flex-column justify-content-between align-items-center pb-4">
        <div>
            <h3 class="title mb-lg-0 mb-2" id="event-name" data-event="{{ $event->id }}">{{ $event->name }}</h3>
            <p class="text-muted">{{ $event->dateFormatted }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <i class="mdi mdi-account text-danger icon-lg"></i>
                        </div>
                        <div class="float-right">
                            <p class="mb-0 text-right">Total registrations</p>
                            <div class="fluid-container">
                                <h3 class="font-weight-medium text-right mb-0" id="total-attendees">0</h3>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mt-3 mb-0">
                        <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> <span id="attendees-cost-percent"></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <i class="mdi mdi-speaker text-warning icon-lg"></i>
                        </div>
                        <div class="float-right">
                            <p class="mb-0 text-right">Total sessions</p>
                            <div class="fluid-container">
                                <h3 class="font-weight-medium text-right mb-0" id="total-sessions">0</h3>
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
                            <i class="mdi mdi-book text-success icon-lg"></i>
                        </div>
                        <div class="float-right">
                            <p class="mb-0 text-right">Total articles</p>
                            <div class="fluid-container">
                                <h3 class="font-weight-medium text-right mb-0" id="total-articles">0</h3>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted mt-3 mb-0">
                        <i class="mdi mdi-dots-horizontal-circle mr-1" aria-hidden="true"></i>
                        <span id="total-articles-detail">0 published, 0 draft, 0 hidden</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
            <div class="card card-statistics">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <i class="mdi mdi-hand-pointing-right text-info icon-lg"></i>
                        </div>
                        <div class="float-right">
                            <p class="mb-0 text-right">Total partners</p>
                            <div class="fluid-container">
                                <h3 class="font-weight-medium text-right mb-0" id="total-partners">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-5 col-lg-5 grid-margin stretch-card">
            <div class="card card-statistics">
                <div class="card">
                    <div class="card-header header-sm d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Tickets Overview</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="tickets-table">
                                <thead>
                                <tr class="bg-light rounded">
                                    <th>Ticket</th>
                                    <th>Progress</th>
                                    <th>Booked</th>
                                    <th>Amount</th>
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
        <div class="col-sm-12 col-md-7 col-lg-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-header header-sm d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Rooms Overview</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 d-flex align-items-end mt-4 mt-md-0">
                            <canvas id="room-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-header header-sm d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Session registrations Overview</h4>
                </div>
                <div class="card-body">
                    <canvas id="session-detail" height="230" data-url="{{ route('events.room_capacity', $event->id) }}"></canvas>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-header header-sm d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Channels Overview</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 d-flex align-items-end mt-4 mt-md-0">
                            <canvas id="channel-chart" height="230"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 grid-margin stretch-card">
            <div class="card card-statistics">
                <div class="card">
                    <div class="card-header header-sm d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Session rating</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="session-rating-table">
                                <thead>
                                <tr class="bg-light rounded">
                                    <th>Session</th>
                                    <th class="text-center">Progress</th>
                                    <th class="text-center">Total ratings</th>
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
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-header header-sm">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title mb-0">Atendee registration report</h4>
                        <div class="dropdown ml-auto">
                            <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Today </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 32px, 0px);">
                                <a class="dropdown-item" href="#" data-from="{{ $today['from'] }}" data-to="{{ $today['to'] }}" id="dropdown-today">Today</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-from="{{ $lastTenDay['from'] }}" data-to="{{ $lastTenDay['to'] }}" id="dropdown-last-ten-day">Last 10 Days</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="attendee-registration-detail" height="100" data-url="{{ route('events.attendee_registration_report',['event' => $event->id]) }}"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop
@push('plugin-js')
    <script src="{{ asset('admin/vendors/chartjs/Chart.min.js') }}"></script>
@endpush
@push('js')
    <script src="{{ asset('js/event.report.js') }}"></script>
@endpush
