<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuMultiActions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ trans('table::tables.bulk-actions')  }}
    </button>
    <div class="dropdown-menu" id="speakers-table-multi-action" aria-labelledby="dropdownMenuMultiActions" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 34px, 0px);">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#model_bulk_changes_company"><i class="fa fa-edit mr-2"></i>Bulk changes company</a>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#model_bulk_changes_position"><i class="fa fa-edit mr-2"></i>Bulk changes position</a>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#model_bulk_changes_description"><i class="fa fa-edit mr-2"></i>Bulk changes description</a>
        <a class="dropdown-item" id="speaker_bulk_delete" href="#" data-url="{{ route('speakers.bulk_delete',['event'=> $event]) }}"><i class="fa fa-times mr-3"></i>Bulk delete</a>
    </div>
</div>
