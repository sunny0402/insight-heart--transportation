@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <!-- your appointments -->
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Driver</th>
                                <th scope="col">Appointment Time</th>
                                <th scope="col">Appointment Date</th>
                                <th scope="col">Created Date</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($all_user_appointments as $key=>$appointment)
                            <tr>
                                <th scope="row">{{$key+1}}</th>
                                <td>{{$appointment->fromBookingToUser->name}}</td>
                                <td>{{$appointment->time}}</td>
                                <td>{{$appointment->date}}</td>
                                <td>{{$appointment->created_at}}</td>
                                <td></td>
                            </tr>
                            @empty
                            <td>You have no appointments.</td>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection