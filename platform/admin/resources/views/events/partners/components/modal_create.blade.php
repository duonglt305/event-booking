<div class="modal fade" id="partner_modal_create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="partner_form_create" action="{{ route('partners.store',['event' => $event->id]) }}" enctype="multipart/form-data">
                <div class="modal-header py-2">
                    <h5 class="modal-title">Create new partner</h5>
                </div>
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="partner_name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="partner_name" class="form-control" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="partner_logo">Logo <span class="text-danger">*</span></label>
                        <input type="file" name="logo" id="partner_logo" class="form-control" placeholder="Logo">
                    </div>
                    <div class="form-group">
                        <label for="partner_description">Description</label>
                        <textarea type="number" name="description" id="partner_description" class="form-control" placeholder="Description"></textarea>
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
