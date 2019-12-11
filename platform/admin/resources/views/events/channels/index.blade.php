<div class="row">
    <div class="col-12">
        <div class="d-flex flex-lg-row flex-column justify-content-between align-items-center pb-4">
            <div>
                <h4 class="title">Channels</h4>
            </div>
            <div>
                <button type="button" data-target="#channel_modal_create" data-toggle="modal" class="btn btn-success">
                    Create new channels
                </button>
            </div>
        </div>
        <div class="row">
            @forelse($event->channels as $channel)
                @include('admin::events.channels.components.channel')
            @empty
                <div class="text-center col-12 text-muted">Click " Create new channels" to create new one</div>
            @endforelse
        </div>
        @include('admin::events.channels.components.modal_create')
        @include('admin::events.channels.components.modal_edit')
    </div>
</div>
