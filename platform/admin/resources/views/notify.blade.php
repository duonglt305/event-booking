@extends('admin::layouts.master')
@section('content')
    <div class="d-flex flex-lg-row flex-column justify-content-between align-items-center pb-4">
        <h4 class="title mb-lg-0 mb-2">Notifications</h4>
    </div>
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">
                    <h5 class="card-title text-center text-lg-left mb-2 mb-lg-0">Notify</h5>
                    <div>
                        <div class="btn-group">
                            <button class="btn btn-info" data-url="{{ route('organizer.mask_as_read_notifications') }}" id="mask-as-read">
                                Mark all as read
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="notify_datatable" data-url="{{ route('organizer.notify_datatable') }}" class="table-hover table-bordered table-striped w-100"></table>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
    <script type="application/javascript" src="{{ asset('js/notification.js') }}"></script>
@endpush
