<div class="row">
    <div class="col-12">
        <div class="d-flex flex-lg-row flex-column justify-content-between align-items-center pb-4">
            <div>
                <h4 class="title">Rooms</h4>
            </div>
            <div>
                <button type="button" data-toggle="modal" data-target="#room_modal_create" class="btn btn-success">
                    Create new room
                </button>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <table id="room_datatable" data-url="{{ route('rooms.datatable', $event->id) }}"
                       class="table-hover table-bordered table-striped w-100"></table>
            </div>
        </div>
        @include('admin::events.rooms.components.modal_create')
        @include('admin::events.rooms.components.modal_edit')
    </div>
</div>
