<style>
    .select2-container{
        width: 100%!important;
    }
</style>
<div class="modal fade" id="session_modal_edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="session_form_edit" action="{{ route('sessions.update',[$event->id, 0]) }}">
                <div class="modal-header py-2">
                    <h5 class="modal-title">Edit session</h5>
                </div>
                <div class="modal-body">
                    @csrf
                    @method('PATCH')
                    <div class="form-group" style="width: 100%">
                        <label for="session_title">Title <span class="text-danger">*</span></label>
                        <input type="text" name="session_title" id="session_title" class="form-control" placeholder="Title">
                    </div>
                    <div class="form-group" style="width: 100%">
                        <label for="session_session_type_id" class="col-12">Session type <span class="text-danger">*</span></label>
                        <select name="session_session_type_id" data-action="{{ route('session-types.select2', $event->id) }}" id="session_session_type_id" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <label for="session_speaker_id">Speaker <span class="text-danger">*</span></label>
                        <select name="session_speaker_id" id="session_speaker_id" data-url="{{ route('speakers.select2',['event' => $event->id]) }}" class="form-control"></select>
                    </div>
                    <div class="form-group">
                        <label for="session_room_id">Room <span class="text-danger">*</span></label>
                        <select name="session_room_id" id="session_room_id" data-url="{{ route('rooms.select2',['event' => $event->id]) }}" class="form-control"></select>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="session_start_time">Start time</label>
                                <input type="text" name="session_start_time" id="session_start_time" class="form-control" data-inputmask="'alias': 'datetime','placeholder': 'dd/mm/yyyy hh:ii'" placeholder="Start time">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="session_end_time">End time</label>
                                <input type="text" name="session_end_time" id="session_end_time" class="form-control" data-inputmask="'alias': 'datetime','placeholder': 'dd/mm/yyyy hh:ii'" placeholder="End time">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="session_description">Description</label>
                        <textarea name="session_description" id="session_description" class="form-control" placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="submit" class="btn btn-primary">Save session</button>
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
