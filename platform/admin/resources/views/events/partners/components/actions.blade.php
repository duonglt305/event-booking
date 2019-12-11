<div>
    <a href="{{ route('partners.edit',['event' => $event->id,'partner' => $partner->id]) }}"
       data-toggle="modal"
       data-target="#partner_modal_edit"
       class="text-small">Edit</a>
    <a href="{{ route('partners.destroy',['event' => $event->id,'partner'=> $partner->id]) }}" class="partner_delete text-danger text-small">Delete</a>
</div>
