@extends('admin::layouts.master')

@section('content')
    <div class="d-flex flex-lg-row flex-column justify-content-between align-items-center pb-4">
        <h4 class="title mb-lg-0 mb-2">Update Events</h4>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Update event</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('events.update',$event->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name"
                                   class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                                   value="{{ old('name') ?? $event->name }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="slug">Slug <span class="text-danger">*</span></label>
                            <input type="text" name="slug" id="slug"
                                   class="form-control @error('slug') is-invalid @enderror" pattern="^[a-z0-9-]+(?:[a-z0-9]+)*$" placeholder="Slug"
                                   value="{{ old('slug') ?? $event->slug }}">
                            @error('slug')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="date">Datetime <span class="text-danger">*</span></label>
                            <input type="text" name="date" id="date"
                                   class="form-control datepicker @error('date') is-invalid @enderror"
                                   data-inputmask="'alias': 'datetime','placeholder': 'dd/mm/yyyy hh:ii'"
                                   placeholder="dd/mm/yyyy hh:ii" value="{{ old('date') ?? date('d/m/Y H:i',strtotime($event->date)) }}">
                            @error('date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="address">Address <span class="text-danger">*</span></label>
                            <textarea name="address" id="address"
                                      class="form-control @error('address') is-invalid @enderror"
                                      placeholder="Address">{{ old('address') ?? $event->address }}</textarea>
                            @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="thumbnail">Thumbnail <span class="text-danger">*</span></label>
                            <input type="file" name="thumbnail" id="thumbnail" data-default-file="{{ asset($event->thumbnail) }}"
                                   class="form-control dropify @error('thumbnail') is-invalid @enderror">
                            @error('thumbnail')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Description">{{ old('description') ?? $event->description }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-primary">Save event</button>
                            <a href="{{ route('events.show',['event' => $event->id]) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
    <script src="{{ asset('/admin/vendors/ckeditor/ckeditor.js') }}" type="application/javascript"></script>
    <script src="{{ asset('/js/event-create-update.js') }}" type="text/javascript"></script>
@endpush
