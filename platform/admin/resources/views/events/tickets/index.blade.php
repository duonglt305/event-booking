<div class="row">
    <div class="col-12">
        <div class="d-flex flex-lg-row flex-column justify-content-between align-items-center pb-4">
            <div>
                <h4 class="title">Tickets</h4>
            </div>
            <div>
                <a href="{{ route('tickets.create', $event->id) }}" class="btn btn-success">Create new ticket</a>
            </div>
        </div>
        <div class="row">
            @forelse($event->tickets as $ticket)
                @include('admin::events.tickets.components.ticket', $ticket)
            @empty
                <div class="text-center col-12 text-muted">Click "Create new ticket" to create new one</div>
            @endforelse
        </div>
    </div>
</div>
