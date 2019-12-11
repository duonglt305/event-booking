<div class="modal fade" id="speaker_modal_create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="speaker_form_create" method="post" action="{{ route('speakers.store', $event->id) }}" enctype="multipart/form-data">
                <div class="modal-header py-2">
                    <h5 class="modal-title">Create new speaker</h5>
                </div>
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="firstname">Firstname <span class="text-danger">*</span></label>
                                <input type="text" name="firstname" id="firstname" class="form-control"
                                       placeholder="Firstname">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="lastname">Lastname <span class="text-danger">*</span></label>
                                <input type="text" name="lastname" id="lastname" class="form-control"
                                       placeholder="Lastname">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="company">Company <span class="text-danger">*</span></label>
                        <input type="text" name="company" id="company" class="form-control"
                               placeholder="Company">
                    </div>
                    <div class="form-group">
                        <label for="position">Position <span class="text-danger">*</span></label>
                        <input type="text" name="position" id="position" class="form-control"
                               placeholder="Position">
                    </div>

                    <div class="form-group">
                        <label for="photo">Photo <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="photo" id="photo">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control"
                                  placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="submit" class="btn btn-success">Save speaker</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
