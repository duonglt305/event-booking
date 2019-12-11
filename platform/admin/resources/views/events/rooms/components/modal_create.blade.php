<div class="modal fade" id="room_modal_create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="room_form_create" action="{{ route('rooms.store') }}">
                <div class="modal-header py-2">
                    <h5 class="modal-title">Create new room</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="room_channel_id">Channel <span class="text-danger">*</span></label>
                        <select name="channel_id" id="room_channel_id" class="form-control">
                            @foreach($event->channels as $channel)
                                <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="room_name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="room_name" class="form-control" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="capacity">Capacity <span class="text-danger">*</span></label>
                        <input type="number" name="capacity" id="room_capacity" class="form-control" placeholder="Capacity">
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="submit" class="btn btn-success">Save room</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
