@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <!-- your appointments -->
                <div class="card-header"><h4>Number of Trips: {{$all_user_appointments->count()}} </h4></div>

                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Driver</th>
                                <th scope="col">Appointment Time</th>
                                <th scope="col">Appointment Date</th>
                                <th scope="col">Created Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Cancel Appointment</th>
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
                                <td>
                                    <form action="{{route('cancel.my.booking')}}" method="post">@csrf
                                        <input type="hidden" name="appointment" value="{{$appointment->appointment}}">
                                        <input type="hidden" name="date" value="{{$appointment->date}}">
                                        <input type="hidden" name="time" value="{{$appointment->time}}">
                                    <button class="btn btn-primary">Cancel</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <div class="card">
                                <div class="card-header"><h4>You have no appointments scheduled.</h4> </div>
                                    <div class="card-body">
                                        <div class="row">
                                                <div class="col-md-10">
                                                    <a href="/">
                                                        <button type="button" class="btn btn-success btn-lg">Book another appointment.</button>
                                                    </a>
                                                </div>
                                        </div>
                                    </div>
                            </div>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection



{{-- <form action="{{route('appointment.check')}}" method="post">@csrf
    <div class="card">
        <div class="card-header">
            Choose date
            <br>

            @if(isset($date))
            Your time table for:
            {{$date}}
            @endif
        </div>
        <div class="card-body">
            <input type="text" class="form-control datetimepicker-input" id="datepicker" data-toggle="datetimepicker" data-target="#datepicker" name="date">
            <br>
            <button type="submit" class="btn btn-primary">Check Availability </button>
        </div>
    </div>
</form> --}}