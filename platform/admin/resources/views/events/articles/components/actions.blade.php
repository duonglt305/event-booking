<div>
    @if(intval($article->is_feature) == 0)<a href="{{ route('articles.set_feature',['event' => $event->id]) }}" data-id={{ $article->id }} class="text-info text-small set-feature">Feature</a>@endif
    <a href="{{ route('articles.edit',['event' => $event->id,'article' => $article->id]) }}" class="text-small">Edit</a>
    <a href="{{ route('articles.update_status',['event' => $event->id,'article' => $article->id]) }}" class="text-small text-warning update_status">{{ $updateStatus }}</a>
    <a href="{{ route('articles.destroy',['event' => $event->id,'article' => $article->id]) }}" class="article_delete text-danger text-small">Delete</a>
</div>
