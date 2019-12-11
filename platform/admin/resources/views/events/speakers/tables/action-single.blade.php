<div>
    <a href="{{ route('speakers.edit',['event' => $event, 'speaker' => $model->id]) }}" data-toggle="modal" data-target="#model_update_speaker" class="text-small">Edit</a>
    <a href="{{ route('speakers.destroy',['event' => $event,'speaker' =>$model->id]) }}" class="speaker_delete text-danger text-small">Delete</a>
</div>

