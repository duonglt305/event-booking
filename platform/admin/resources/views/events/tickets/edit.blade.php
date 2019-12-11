@extends('admin::layouts.master')
@section('content')
    <div class="pb-4">
        <h3 class="title mb-lg-0 mb-2">{{ $event->name }}</h3>
        <p class="text-muted">{{ $event->date_formatted }}</p>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Edit ticket</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('tickets.update',[$event->id, $ticket->id]) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name"
                                   class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                                   value="{{ old('name') ?? $ticket->name }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="cost">Cost <span class="text-danger">*</span></label>
                                    <input type="number" name="cost" id="cost"
                                           class="form-control @error('cost') is-invalid @enderror" placeholder="Cost"
                                           value="{{ old('cost') ?? $ticket->cost }}">
                                    @error('cost')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="special_validity">Special validity <span
                                            class="text-danger">*</span></label>
                                    <select name="special_validity" id="special_validity"
                                            class="form-control @error('special_validity') is-invalid @enderror">
                                        <option value="">None</option>
                                        <option value="amount"
                                                @if((old('special_validity') ?? optional($ticket->special_validity)->type) === 'amount') selected @endif>
                                            Limited amount
                                        </option>
                                        <option value="date"
                                                @if((old('special_validity') ?? optional($ticket->special_validity)->type) === 'date') selected @endif>
                                            Purchasable till date
                                        </option>

                                        <option value="both"
                                                @if((old('special_validity') ?? optional($ticket->special_validity)->type) === 'both') selected @endif>
                                            Limited amount and purchasable till date
                                        </option>
                                    </select>
                                    @error('special_validity')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="amount">Maximum amount of tickets to be sold</label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror"
                                   name="amount" id="amount"
                                   value="{{ old('amount') ?? optional($ticket->special_validity)->amount }}"
                                   placeholder="Maximum amount of tickets to be sold">

                            @error('amount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="valid_until">Tickets can be sold until</label>
                            <input type="text" class="form-control @error('valid_until') is-invalid @enderror"
                                   name="valid_until" id="valid_until"
                                   data-inputmask="'alias': 'datetime','placeholder': 'dd/mm/yyyy hh:ii'"
                                   value="{{ old('valid_until') ?? optional($ticket->special_validity)->formatted }}"
                                   placeholder="Tickets can be sold until">
                            @error('valid_until')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Short Description</label>
                            <textarea name="description" id="description">{{ $ticket->description }}</textarea>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-primary">Save ticket</button>
                            <a href="{{ route('events.show', $event->id) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
    <script src="{{ asset('/admin/vendors/ckeditor/ckeditor.js') }}" type="application/javascript"></script>
    <script>
        $(() => {
            $('.dropify').dropify();
        });
        CKEDITOR.replace('description', {
            height: 200
        });
    </script>
@endpush
