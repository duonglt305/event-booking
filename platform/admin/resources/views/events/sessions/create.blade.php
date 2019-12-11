@extends('admin::layouts.master')
@section('content')
    <div class="pb-4">
        <h3 class="title mb-lg-0 mb-2">{{ $event->name }}</h3>
        <p class="text-muted">{{ $event->date_formatted }}</p>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8 col-12">
            <div class="card">
                <div class="card-header d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">
                    <h5 class="card-title text-center text-lg-left mb-2 mb-lg-0">Create new session</h5>
                    <div>
                        <div class="btn-group">
                            <button class="btn btn-info" data-toggle="modal" data-target="#session_type_modal_create">
                                Create new session type
                            </button>
                            <a href="{{ route('session-types.index',['event' => $event->id]) }}" class="btn btn-primary">
                                Manage session type
                            </a>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-info" data-toggle="modal" data-target="#speaker_modal_create">
                                Create new speaker
                            </button>
                            <a href="{{ route('speakers.index',['event' => $event->id]) }}" class="btn btn-primary">
                                Manage speakers
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('sessions.store', $event->id) }}" id="session_form_create">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                        </div>

                        <div class="form-group">
                            <label for="session_type_id">Session type <span class="text-danger">*</span></label>
                            <select name="session_type_id" data-action="{{ route('session-types.select2', $event->id) }}" id="session_type_id" class="form-control"></select>
                        </div>
                        <div class="form-group">
                            <label for="speaker_id">Speaker <span class="text-danger">*</span></label>
                            <select name="speaker_id" id="speaker_id" data-url="{{ route('speakers.select2',['event' => $event->id]) }}" class="form-control"></select>
                        </div>
                        <div class="form-group">
                            <label for="room_id">Room <span class="text-danger">*</span></label>
                            <select name="room_id" id="room_id" data-url="{{ route('rooms.select2',['event' => $event->id]) }}" class="form-control"></select>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="start_time">Start time</label>
                                    <input type="text" name="start_time" id="start_time" class="form-control" data-inputmask="'alias': 'datetime','placeholder': 'dd/mm/yyyy hh:ii'" placeholder="Start time">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="end_time">End time</label>
                                    <input type="text" name="end_time" id="end_time" class="form-control" data-inputmask="'alias': 'datetime','placeholder': 'dd/mm/yyyy hh:ii'" placeholder="End time">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description"
                                      class="form-control"
                                      placeholder="Description"></textarea>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-success">Save session</button>
                            <a href="{{ route('events.show', $event->id) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('admin::events.sessions.components.modal_create_speaker')
    @include('admin::events.sessions.components.modal_create_session_type')
@stop
@push('js')
    <script src="{{ asset('js/session.create.js') }}"></script>
@endpush
