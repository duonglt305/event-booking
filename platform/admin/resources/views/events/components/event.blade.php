<div class="col-lg-3 col-md-6 col-12 mb-4">
    <div class="card">
        <img src="{{ asset($event->thumbnail) }}" class="card-img" alt="">
        <div class="card-body">
            <a href="{{ route('events.show', $event->id) }}">
                <h4>{{ $event->name }}</h4>
            </a>
            <div class="border-top d-flex justify-content-between py-2">
                <small class="text-muted">{{ number_format($event->registrations->count()) }} registrations</small>
                <small class="text-muted">{{ number_format($event->channels->count()) }} channels
                    | {{ number_format($event->rooms->count()) }} rooms</small>
            </div>
        </div>
    </div>
</div>
