<div>
    <a href="{{ route('sessions.edit', ['event'=> $event->id,'session'=> $session->id]) }}"
       data-toggle="modal"
       data-target="#session_modal_edit"
       class="text-small">Edit</a>
    <a href="{{route('sessions.destroy', ['event'=> $event->id, 'session' => $session->id])}}"
       class="session_delete text-danger text-small">Delete</a>
</div>
