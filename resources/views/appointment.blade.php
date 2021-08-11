@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center">Driver Info</h4>
                    <img src="{{asset('images')}}/{{$user->image}}" width="150px" style="border-radius: 50%;">
                    <br>
                    <br>
                    <p class="lead">Name:{{ucfirst($user->name)}}</p>
                    <p class="lead">Region:{{ucfirst($user->region)}}</p>
                    <p class="lead">Vehicle: {{ucfirst($user->vehicle_info)}}</p>
                    <p class="lead">Description:{{ucfirst($user->description)}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-9">

            @foreach($errors->all() as $error)
            <div class="alert alert-danger">{{$error}}</div>
            @endforeach

            @if(Session::has('message'))
            <div class="alert alert-success">
                {{Session::get('message')}}
            </div>
            @endif


            <form action="{{route('booking.appointment')}}" method="post">@csrf
                <div class="card">
                    <div class="card-header">{{$date}}</div>

                    <div class="card-body">
                        <div class="row">
                            @foreach($times as $time)
                            <div class="col-md-3">
                                <label class="btn btn-outline-primary">
                                    <input type="radio" name="time" value="{{$time->time}}">
                                    <!-- $time variable and time from times table -->
                                    <span>{{$time->time}}</span>
                                </label>
                            </div>
                            <input type="hidden" name="driverId" value="{{$driver_id}}">
                            <input type="hidden" name="appointmentId" value="{{$time->appointment_id}}">
                            <input type="hidden" name="date" value="{{$date}}">
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    @if(Auth::check())
                    <button type="submit" class="btn btn-success" style="width:100%;">Book driver</button>
                    @else
                    <p>Please login to make appointment</p>
                    <a href="/register">Register</a>
                    <a href="/login">Login</a>
                    @endif
                </div>

            </form>
        </div>
    </div>
</div>
@endsection