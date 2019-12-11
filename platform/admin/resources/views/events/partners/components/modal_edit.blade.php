<div class="modal fade" id="partner_modal_edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="partner_form_edit" action="{{ route('partners.update',[$event->id,0]) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header py-2">
                    <h5 class="modal-title">Edit partner</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="update_partner_name">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="update_partner_name" class="form-control" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="update_partner_logo">Capacity <span class="text-danger">*</span></label>
                        <input type="file" name="logo" id="update_partner_logo" class="form-control" placeholder="Logo">
                    </div>
                    <div class="form-group">
                        <label for="update_partner_description">Capacity <span class="text-danger">*</span></label>
                        <textarea name="description" id="update_partner_description" class="form-control"
                                  placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="submit" class="btn btn-primary">Save room</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
