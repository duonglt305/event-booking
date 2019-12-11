<div>
    <a href="{{ route('session-types.edit',['event' => $event, 'session_type' => $model->id]) }}" data-toggle="modal" data-target="#model_update_session_type" class="text-small">Edit</a>
    <a href="{{ route('session-types.destroy',['event' => $event,'session_type' =>$model->id]) }}" class="session_type_delete text-danger text-small">Delete</a>
</div>
