<div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
    <div class="card card-statistics bg-green-gradient">
        <div class="card-header text-right py-1">
            <a class="text-small" href="{{ route('tickets.edit', [
                        $event->id,
                        $ticket->id
                    ]) }}">
                Edit
            </a>
            @if($ticket->registrations->count() === 0)
                <a class="text-small text-danger ticket_delete"
                   href="{{ route('tickets.destroy', [$event->id, $ticket->id]) }}">
                    Delete
                </a>
            @endif
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <i class="mdi mdi-receipt"></i>
                    {{ $ticket->name }}
                </div>
                <div>
                    <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0">{{ $ticket->cost_formatted }}</h3>
                    </div>
                </div>
            </div>
            <p class="text-white text-small mt-3  mb-0" style="min-height: 34.55px">{!! $ticket->special_validity_formatted !!}
            </p>
        </div>
    </div>


</div>


