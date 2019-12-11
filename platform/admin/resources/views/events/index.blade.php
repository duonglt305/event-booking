@extends('admin::layouts.master')
@section('content')
    <div class="d-flex flex-lg-row flex-column justify-content-between align-items-center pb-4">
        <h4 class="title mb-lg-0 mb-2">Manage Events</h4>
        <div>
            <a href="{{ route('events.create') }}" class="btn btn-success">Create new event</a>
        </div>
    </div>
    <div class="row">
        @foreach($events as $event)
            @include('admin::events.components.event', $event)
        @endforeach
    </div>
    <div class="d-flex justify-content-end">
        {!! $events->links() !!}
    </div>
@stop
