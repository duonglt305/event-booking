<div class="modal fade" id="session_type_modal_create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="session_type_form_create" action="{{ route('session-types.store', $event->id) }}">
                <div class="modal-header py-2">
                    <h5 class="modal-title">Create new session type</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="session_type_name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="session_type_name" class="form-control" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="session_type_cost">Cost</label>
                        <input type="number" name="cost" id="session_type_cost" class="form-control" placeholder="Cost">
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="submit" class="btn btn-success">Save session type</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
