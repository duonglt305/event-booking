<div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdown_menu_bulk_actions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ trans('table::tables.bulk-actions')  }}
    </button>
    <div class="dropdown-menu" id="menu_bulk_actions" aria-labelledby="dropdown_menu_bulk_actions" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 34px, 0px);">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#model_bulk_change_name"><i class="fa fa-edit mr-2"></i>Bulk changes name</a>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#model_bulk_change_cost"><i class="fa fa-edit mr-2"></i>Bulk changes cost
        <a class="dropdown-item" id="session_type_bulk_delete" href="{{ route('session-types.bulk_delete',['event'=> $event]) }}"><i class="fa fa-times mr-3"></i>Bulk delete</a>
    </div>
</div>
