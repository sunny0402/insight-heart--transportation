@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <!-- your appointments -->
                <div class="card-header">Number of Trips: {{$all_user_appointments->count()}} </div>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Driver</th>
                                <th scope="col">Appointment Time</th>
                                <th scope="col">Appointment Date</th>
                                <th scope="col">Created Date</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($all_user_appointments as $key=>$appointment)
                            <tr>
                                <th scope="row">{{$key+1}}</th>
                                <td>{{$appointment->fromBookingToUserTable->name}}</td>
                                <td>{{$appointment->time}}</td>
                                <td>{{$appointment->date}}</td>
                                <td>{{$appointment->created_at}}</td>
                                <td>
                                    @if($appointment->status==0)
                                    <button class="btn btn-primary">Trip Not Complete</button>
                                    @else
                                    <button class="btn btn-success">Complete</button>
                                    @endif
                                </td>
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