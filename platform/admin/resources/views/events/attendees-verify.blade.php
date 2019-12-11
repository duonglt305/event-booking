@extends('admin::layouts.master')

@section('content')
    <div class="d-flex flex-lg-row flex-column justify-content-between align-items-center pb-4">
        <div>
            <h3 class="title mb-lg-0 mb-2" id="event-name" data-event="{{ $event->id }}">{{ $event->name }}</h3>
            <p class="text-muted">{{ $event->dateFormatted }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card card-statistics">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-4">
                            <video id="scanner" style="width: 100%;background-color: #0a6ebd"></video>
                        </div>
                        <div class="col-xs-12 col-md-8">
                            <label for="">Session filter</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select data-url="{{ route('rooms.select2',['event' => $event->id]) }}" id="room-filter" class="form-control"></select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select id="channel-filter" data-url="{{ route('channels.select2',['event' => $event->id]) }}" class="form-control"></select>
                                    </div>
                                </div>
                            </div>
                            <label for="">Session select</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select data-url="{{ route('events.session_select', ['event' => $event->id]) }}" id="session-select" class="form-control"></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    QR code: <strong id="code-show"></strong>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-success" id="btn-check" data-url="{{ route('events.attendees_verify',['event' => $event->id]) }}">Check</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="model-verify" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-3" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel-3">Verify ìnomation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="card-title">Attendee information</h5>
                                    <table class="table table-bordered" id="attendee-info-table">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <h5 class="card-title">Ticket information</h5>
                                    <table class="table table-bordered" id="ticket-info-table">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="card-title">Session information</h5>
                            <table class="table table-bordered" id="session-info-table">
                                <thead>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="verify-update-btn" data-url="{{ route('event.attendees_verify.update',['event' => $event->id]) }}">Verify attendee to this session</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
    <script src="{{ asset('js/attendees-verify.js') }}"></script>
@endpush


