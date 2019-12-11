<div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
    <div class="card">
        <div class="card-header text-right py-1">
            <a class="text-small"
               data-name="{{ $channel->name }}"
               href="{{ route('channels.update', [
                        $event->id,
                        $channel->id
                    ]) }}"
               data-toggle="modal"
               data-target="#channel_modal_edit">
                Edit
            </a>
            <a class="text-small text-danger channel_delete"
               href="{{ route('channels.destroy', [$event->id, $channel->id]) }}">
                Delete
            </a>
        </div>
        <div class="card-body">
            <h5 class="card-title mb-0">{{ $channel->name }}</h5>
        </div>
        <div class="card-footer text-right bg-white py-2">
            <span class="mb-0 text-small">{{ $channel->rooms->count() }} rooms,</span>
            <span class="mb-0 text-small">{{ $channel->sessions->count() }} sessions</span>
        </div>
    </div>
</div>
