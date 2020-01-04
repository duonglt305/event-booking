@extends('admin::layouts.master')
@section('content')
    <div class="d-flex flex-lg-row flex-column justify-content-between align-items-center pb-4">
        <h4 class="title mb-lg-0 mb-2">Attendee registration</h4>
    </div>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">
                    <h5 class="card-title text-center text-lg-left mb-2 mb-lg-0">Attendee registration</h5>
                    <div class="dropdown ml-auto">
                        <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Paid </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 32px, 0px);">
                            <a class="dropdown-item" href="#" data-status="paid" id="dropdown-paid">Paid</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-status="pending" id="dropdown-pending">Pending</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="registration_table" data-url="{{ route('events.datatable_registrations',['event' => $event->id]) }}" class="table-hover table-bordered table-striped w-100"></table>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
    <script type="application/javascript" src="{{ asset('js/registration.js') }}"></script>
@endpush
