@extends('admin::layouts.master')
@section('content')
    <div class="d-flex flex-lg-row flex-column justify-content-between align-items-center pb-4">
        <div>
            <h3 class="title mb-lg-0 mb-2">{{ $event->name }}</h3>
            <p class="text-muted mb-lg-0 mb-2">{{ $event->dateFormatted }} - {{ $event->status == \DG\Dissertation\Admin\Supports\ConstantDefine::EVENT_STATUS_ACTIVE ? 'Active' : 'Pending'}}</p>
        </div>
        <div>
            <a href="{{ route('events.update_status_event', $event->id) }}" id="update-event-status" class="btn btn-outline-{{ $event->status == \DG\Dissertation\Admin\Supports\ConstantDefine::EVENT_STATUS_PENDING ? 'success' : 'info' }}">{{ $event->status == \DG\Dissertation\Admin\Supports\ConstantDefine::EVENT_STATUS_PENDING ? 'Active this event' : 'Pending this event' }}</a>
            <a href="{{ route('events.edit', $event->id) }}" class="btn btn-outline-warning">Edit event</a>
        </div>
    </div>
    @include('admin::events.tickets.index', $event)
    @include('admin::events.channels.index', $event)
    @include('admin::events.rooms.index', $event)
    @include('admin::events.sessions.index', $event)
    @include('admin::events.articles.index', $event)
    @include('admin::events.partners.index', $event)
@stop


@push('js')
    <script src="{{ asset('js/detail.js') }}"></script>
@endpush
