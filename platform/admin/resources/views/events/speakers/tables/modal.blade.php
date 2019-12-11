<!--model_create_speaker-->
<div class="modal fade" id="model_create_speaker" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="speaker_form_create" action="{{ route('speakers.store', $event) }}">
                <div class="modal-header py-2">
                    <h5 class="modal-title">Create new speaker</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="firstname">Firstname <span class="text-danger">*</span></label>
                                <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Firstname">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="lastname">Lastname <span class="text-danger">*</span></label>
                                <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Lastname">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="company">Company <span class="text-danger">*</span></label>
                        <input type="text" name="company" id="company" class="form-control" placeholder="Company">
                    </div>
                    <div class="form-group">
                        <label for="position">Position <span class="text-danger">*</span></label>
                        <input type="text" name="position" id="position" class="form-control" placeholder="Position">
                    </div>

                    <div class="form-group">
                        <label for="photo">Photo <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="photo" id="photo" accept="image/jpeg,image/png,image/jpg">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Description"></textarea>
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
<!--model_update_speaker-->
<div class="modal fade" id="model_update_speaker" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="speaker_form_update" method="POST" action="{{ route('speakers.update', ['event' => $event, 'speaker' => 0] ) }}" enctype="multipart/form-data">
                <div class="modal-header py-2">
                    <h5 class="modal-title">Update speaker</h5>
                </div>
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="update_firstname">Firstname <span class="text-danger">*</span></label>
                                <input type="text" name="update_firstname" id="update_firstname" class="form-control" placeholder="Firstname">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="update_lastname">Lastname <span class="text-danger">*</span></label>
                                <input type="text" name="update_lastname" id="update_lastname" class="form-control" placeholder="Lastname">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="update_company">Company <span class="text-danger">*</span></label>
                        <input type="text" name="update_company" id="update_company" class="form-control" placeholder="Company">
                    </div>
                    <div class="form-group">
                        <label for="update_position">Position <span class="text-danger">*</span></label>
                        <input type="text" name="update_position" id="update_position" class="form-control" placeholder="Position">
                    </div>

                    <div class="form-group">
                        <label for="update_photo">Photo <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="update_photo" id="update_photo" accept="image/jpeg,image/png,image/jpg">
                    </div>
                    <div class="form-group">
                        <label for="update_description">Description</label>
                        <textarea name="update_description" id="update_description" class="form-control" placeholder="Description"></textarea>
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
<!--model_bulk_changes_company-->
<div class="modal fade" id="model_bulk_changes_company" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="form_bulk_changes_company" method="POST" action="{{ route('speakers.bulk_changes_company', ['event' => $event] ) }}">
                <div class="modal-header py-2">
                    <h5 class="modal-title">Bulk changes company</h5>
                </div>
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bulk_changes_company">Company <span class="text-danger">*</span></label>
                        <input type="text" name="bulk_changes_company" id="bulk_changes_company" class="form-control" placeholder="Company">
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
<!--model_bulk_changes_position-->
<div class="modal fade" id="model_bulk_changes_position" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="form_bulk_changes_position" method="POST" action="{{ route('speakers.bulk_changes_position', ['event' => $event] ) }}">
                <div class="modal-header py-2">
                    <h5 class="modal-title">Bulk changes position</h5>
                </div>
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bulk_changes_position">Position <span class="text-danger">*</span></label>
                        <input type="text" name="bulk_changes_position" id="bulk_changes_position" class="form-control" placeholder="Position">
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
<!--model_bulk_changes_description-->
<div class="modal fade" id="model_bulk_changes_description" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="form_bulk_changes_description" method="POST" action="{{ route('speakers.bulk_changes_description', ['event' => $event] ) }}">
                <div class="modal-header py-2">
                    <h5 class="modal-title">Bulk changes description</h5>
                </div>
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="bulk_changes_description">Description <span class="text-danger">*</span></label>
                        <textarea type="text" name="bulk_changes_description" id="bulk_changes_description" class="form-control" placeholder="Description"></textarea>
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
