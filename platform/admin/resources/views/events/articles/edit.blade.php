@extends('admin::layouts.master')

@section('content')
    <div class="pb-4">
        <h3 class="title mb-lg-0 mb-2">{{ $event->name }}</h3>
        <p class="text-muted">{{ $event->date_formatted }}</p>
    </div>
    <form id="form_article" action="{{ route('articles.update',['event' => $event->id,'article' => $article->id]) }}" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Update article</h5>
                    </div>
                    <div class="card-body">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Name" value="{{ $article->title }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Description <span class="text-danger">*</span></label>
                            <textarea type="text" rows="5" name="description" id="description" class="form-control" placeholder="Short description">{{ $article->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="body">Content <span class="text-danger">*</span></label>
                            <textarea type="text" name="body" id="body" class="form-control">{{ $article->body }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="thumbnail">Thumbnail <span class="text-danger">*</span></label>
                            <input type="file" name="thumbnail" id="thumbnail" data-default-file="{{ asset($article->thumbnail) }}" class="form-control">
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-primary" type="submit">Save change</button>
                            <a href="{{ route('events.show',['event' => $event->id]) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@push('js')
    <script src="{{ asset('/admin/vendors/ckeditor/ckeditor.js') }}" type="application/javascript"></script>
    <script src="{{ asset('js/articles.create-update.js') }}" type="application/javascript"></script>
@endpush
