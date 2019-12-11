<div class="modal fade" id="channel_modal_edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="channel_form_edit">
                @csrf
                @method('PUT')
                <div class="modal-header py-2">
                    <h5 class="modal-title" id="exampleModalLabel-3">Edit channel</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="channel_name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_channel_name" class="form-control" placeholder="Name">
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="submit" class="btn btn-primary">Save channel</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
