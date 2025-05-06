@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-4 offset-md-4">
                <div class="card bg-light">
                    <div class="card-header">{{ __('Profile') }}</div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th scope="row" style="width: 30%;"><strong>Name</strong></th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row"><strong>Email</strong></th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row"><strong>Phone</strong></th>
                                    <td>{{ $user->phone }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
