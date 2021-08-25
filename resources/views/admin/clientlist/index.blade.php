@extends('admin.layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <!-- your appointments -->
                <div class="card-header">Booked Appointments: {{$bookings->count()}} </div>
                <form action="{{route('client')}}" method="GET">
                    <div class="card-header">

                        Filter:
                        <div class="row">
                            <div class="col-md-10">
                                <input type="text" class="form-control datetimepicker-input" id="datepicker" data-toggle="datetimepicker" data-target="#datepicker" name="date">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>

                    </div>
                </form>

                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Client Photo</th>
                                <th scope="col">Date</th>
                                <th scope="col">Client</th>
                                <th scope="col">Client Email</th>
                                <th scope="col">Client Phone</th>
                                <th scope="col">Time</th>
                                <th scope="col">Driver</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($bookings as $key=>$a_booking)
                            <tr>
                                <!-- fromBookingToUserTable and user relationships defined in Booking model, Booking.php  -->
                                <th scope="row">{{$key+1}}</th>
                                <td><img src="/profile/{{$a_booking->user->image}}" width="80" style="border-radius:50%;"></td>
                                <td>{{$a_booking->date}}</td>
                                <td>{{$a_booking->user->name}}</td>
                                <td>{{$a_booking->user->email}}</td>
                                <td>{{$a_booking->user->phone_number}}</td>
                                <td>{{$a_booking->time}}</td>
                                <td>{{$a_booking->fromBookingToUserTable->name}}</td>
                                <td>
                                    @if($a_booking->status==0)
                                    <a href="{{route('update.status',[$a_booking->id])}}"> <button class="btn btn-primary">Trip Not Complete</button></a>
                                    @else
                                    <a href="{{route('update.status',[$a_booking->id])}}"> <button class="btn btn-success">Complete</button></a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <td>There are no rides scheduled.</td>
                            @endforelse
                        </tbody>
                    </table>

                </div>
                {{$bookings->links()}}
            </div>
        </div>
    </div>
</div>
@endsection