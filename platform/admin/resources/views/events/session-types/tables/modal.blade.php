<!--model_update_session_type-->
<div class="modal fade" id="model_update_session_type" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="session_type_form_update" action="{{ route('session-types.update',[$event,0]) }}">
                <div class="modal-header py-2">
                    <h5 class="modal-title">Update session type</h5>
                </div>
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="session_type_name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="session_type_cost" id="session_type_name" class="form-control" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="session_type_cost">Cost</label>
                        <input type="number" name="session_type_cost" id="session_type_cost" class="form-control" placeholder="Cost">
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
<!--model_create_session_type-->
<div class="modal fade" id="model_create_session_type" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="session_type_form_create" action="{{ route('session-types.store',['event' => $event]) }}">
                <div class="modal-header py-2">
                    <h5 class="modal-title">Create new session type</h5>
                </div>
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="session_type_cost">Cost</label>
                        <input type="number" name="cost" id="cost" class="form-control" placeholder="Cost">
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
<!--model_bulk_change_cost-->
<div class="modal fade" id="model_bulk_change_cost" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="form_bulk_change_cost" method="POST" action="{{ route('session-types.bulk_changes_cost',['event' => $event]) }}">
                <div class="modal-header py-2">
                    <h5 class="modal-title">Bulk change cost</h5>
                </div>
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bulk_change_cost">Cost</label>
                        <input type="number" name="bulk_change_cost" id="bulk_change_cost" class="form-control" placeholder="Cost">
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="submit" class="btn btn-success">Change</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--model_bulk_change_name-->
<div class="modal fade" id="model_bulk_change_name" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="form_bulk_change_name" method="post" action="{{ route('session-types.bulk_changes_name',['event' => $event]) }}">
                <div class="modal-header py-2">
                    <h5 class="modal-title">Bulk change mame</h5>
                </div>
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bulk_change_name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="bulk_change_name" id="bulk_change_name" class="form-control" placeholder="Name">
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="submit" class="btn btn-success">Change</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
