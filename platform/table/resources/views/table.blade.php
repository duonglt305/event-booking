@extends('table::layouts.master')

@section('content')
    @isset($event)
        {!! $event !!}
    @endisset
    <div class="row justify-content-center">
        <div class="col-lg-12 col-12">
            <div class="card">
                <div class="card-header d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">
                    @if($hasCheckbox)
                        @include('table::action-multi',[
                            'multiTemplate' => $multiTemplate
                        ])
                    @endif
                    <h5 class="card-title text-center text-lg-left mb-2 mb-lg-0">
                        @isset($cardTitle)
                            {{ $cardTitle }}
                        @endisset
                    </h5>
                </div>
                <div class="card-body">
                    {!! $dataTable->table() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@if($hasCheckbox)
@section('model')
    {!! $model !!}
@stop
@endif

@push('js')
    {!! $dataTable->scripts() !!}
    @isset($script)
        {!! $script !!}
    @endisset
@endpush
