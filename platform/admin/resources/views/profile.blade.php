@extends('admin::layouts.master')
@section('content')
    <div class="col-8 offset-2">
        <div class="card">
            <div class="card-body">
                <div class="profile-body">
                    <h4>Organizer info</h4>
                    <div class="tab-pane fade pr-3 active show" id="user-profile-info" role="tabpanel" aria-labelledby="user-profile-info-tab">
                        <table class="table table-borderless w-100 mt-4">
                            <tbody>
                            <tr>
                                <td>
                                    <strong>Full Name :</strong> {{ auth()->user()->name }}
                                </td>
                                <td>
                                    <strong>Phone :</strong> {{ auth()->user()->phone }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Address :</strong> {{ auth()->user()->address }}
                                </td>
                                <td>
                                    <strong>Email :</strong> {{ auth()->user()->email }}
                                </td>
                            </tr>
                            <tr>
                                <td style="text-wrap: normal">
                                    <strong>Description :</strong> {{ auth()->user()->description }}
                                </td>
                                <td>
                                    <strong>Website :</strong> <a href="{{ auth()->user()->website }}">{{ auth()->user()->website }}</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
@endpush
