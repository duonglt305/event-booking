<div>
    <a href="{{ route('rooms.update', $room->id) }}"
       data-toggle="modal"
       data-target="#room_modal_edit"
       data-name="{{ $room->name }}"
       data-capacity="{{ $room->capacity }}"
       data-channel="{{ $room->channel_id }}"
       class="text-small">Edit</a>
    <a href="{{route('rooms.destroy', $room->id)}}"
       class="room_delete text-danger text-small">Delete</a>
</div>
