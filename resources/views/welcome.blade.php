@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- InsighHeart Logo -->
    <div class="card">
        <div class="card-body">
            <div class="row d-flex flex-row justify-content-center">
                <div class="col-md-6">
                    <img src="/banner/InsightHeartGo.jpg" class="img-fluid" 
                    style="border-radius:10px; object-fit: cover; ">
                </div>
            </div>
        </div>
    </div>
   <!-- InsighHeart Logo -->

<!-- About InsighHeartGO -->
        <div class="card text-white bg-primary mb-3" 
        style="border-radius:10px; margin: 10px 0 10px 0; ">
                <div class="card-header d-flex flex-row justify-content-center">
                    <h3 class="text-white"
                    >Community Transportation</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 d-flex flex-column justify-content-center">
                            <p>With our InsightHeart Foundation Transportation Program, we are driving Seniors and Cancer Patients to their local scheduled medical appointments for FREE.</p>

                            <p>Our drivers are provided by a combination of volunteers and partner agency drivers.  Our driver assistance includes support in and out of the vehicle, help handling groceries, and some mobility equipment. Escorts are recommended at no cost. 
                            </p>
                        </div>
                        <div class="col-md-6 d-flex flex-row justify-content-center">
                            <img src="/banner/backpacks_4_smiles_aug2021_6.jpg" class="img-fluid" 
                            style="
                            max-width:400px;
                            border-radius:10px; 
                            object-fit: cover; ">
                        </div>
                    </div>
                </div>
        </div>
<!-- end About InsighHeartGO -->


<!-- Login/Register -->
    <div class="card">
        <div class="card-body">
            <div class="row d-flex flex-row justify-content-center">
                            <a href="{{url('/register')}}">
                                <button type="button" 
                                class="btn btn-success btn-lg"
                                style="
                                        width: 12rem;
                                        height: 4rem;
                                        margin-right: 10px;
                                        border: none;
                                        border-radius: 0.7rem;
                                        font-size: 1.4rem;
                                        line-height: 1.5rem;
                                        color: #eee;
                                        box-shadow: 0 0.1rem 0.8rem rgba(0, 0, 0, 0.4);">
                                Register</button>
                            </a>
                            <a href="{{url('/login')}}">
                                <button type="button" 
                                class="btn btn-secondary btn-lg"
                                style="
                                width: 12rem;
                                height: 4rem;
                                margin-right: 10px;
                                border: none;
                                border-radius: 0.7rem;
                                font-size: 1.4rem;
                                line-height: 1.5rem;
                                color: #eee;
                                box-shadow: 0 0.1rem 0.8rem rgba(0, 0, 0, 0.4);">
                                Login</button>
                            </a>       
            </div>           
        </div>
    </div>
<!-- end Login/Register -->
    
    
    <!-- Find Driver/Schedule Ride -->
    <form action="{{url('/')}}" method="GET">@csrf
        <div class="card">
            <div class="card-body">
                    <div class="row d-flex flex-column justify-content-center align-items-center ">
                            <input type="text" name="date" 
                            class="form-control" id="datepicker"
                            style="
                                width: 12rem;
                                height: 4rem;
                                box-shadow: 0 0.1rem 0.8rem rgba(0, 0, 0, 0.4);">

                                <button class="btn btn-primary btn-lg"
                                type="submit"
                                style="
                                width: 12rem;
                                height: 4rem;
                                margin-top: 2rem;
                                border: none;
                                border-radius: 0.7rem;
                                font-size: 1.4rem;
                                line-height: 1.5rem;
                                color: #eee;
                                box-shadow: 0 0.1rem 0.8rem rgba(0, 0, 0, 0.4);"
                                >Find Drivers</button>
                    </div>
            </div>
        </div>
    </form>
<!-- END Find Driver/Schedule Ride -->

<!-- Display Available drivers -->
    <div class="card">
        <div class="card-body">
            <div class="row d-flex flex-row justify-content-center align-items-center">
                <div class="col-md-10">
                <table class="table table-striped table-hover">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Region</th>
                            <th>Book</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($available_drivers as $driver)
                        <tr>
                            <th scope="row">1</th>
                            <td>
                                <!-- images in public folder -->
                                <img src="{{asset('images')}}/{{$driver->userIdToId->image}}" width="150px" style="border-radius: 50%;">
                            </td>
                            <td>{{$driver->userIdToId->name}}</td>
                            <td>{{$driver->userIdToId->region}}</td>
                            <td>
                                <a href="
                                {{route('create.appointment', [$driver->user_id, $driver->date])}}
                                ">
                                    <button class="btn btn-success">Schedule a ride</button>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <td>No drivers available for this date.</td>
                        @endforelse
                    </tbody>

                </table>
            </div>
         </div>
        </div>
    </div>
<!-- END Display Available drivers -->


<!-- container-fluid closing div -->
</div>
@endsection