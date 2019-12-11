<div class="modal fade" id="channel_modal_create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="channel_form_create" action="{{ route('channels.store', $event->id) }}">
                <div class="modal-header py-2">
                    <h5 class="modal-title" id="exampleModalLabel-3">Create new channel</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="channel_name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="channel_name" class="form-control" placeholder="Name">
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="submit" class="btn btn-success">Save channel</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
