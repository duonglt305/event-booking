<div class="row">
    <div class="col-12">
        <div class="d-flex flex-lg-row flex-column justify-content-between align-items-center pb-4">
            <div>
                <h4 class="title">Partner</h4>
            </div>
            <div>
                <button type="button" data-toggle="modal" data-target="#partner_modal_create" class="btn btn-success">
                    Create new partner
                </button>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <table id="partner_datatable" data-url="{{ route('partner.datatable', $event->id) }}" class="table-hover table-bordered table-striped w-100"></table>
            </div>
        </div>
        @include('admin::events.partners.components.modal_create')
        @include('admin::events.partners.components.modal_edit')
    </div>
</div>
