<div class="row">
    <div class="col-12">
        <div class="d-flex flex-lg-row flex-column justify-content-between align-items-center pb-4">
            <div>
                <h4 class="title">Sessions</h4>
            </div>
            <div>
                <a href="{{ route('sessions.create', $event->id) }}" class="btn btn-success">Create new session</a>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <table id="session_datatable" data-url="{{ route('sessions.datatable', $event->id) }}" class="table-hover table-bordered table-striped w-100"></table>
            </div>
        </div>
    </div>
</div>
@include('admin::events.sessions.components.modal_update_session',[
    'event' => $event
])
