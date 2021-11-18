@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            {{-- style="border:1px solid #ccc; --}}
            <img src="/banner/logo-mark-version3.jpg" class="img-fluid" style="border-radius:10px; object-fit: cover; ">
        </div>
        <div class="col-md-6 d-flex flex-column justify-content-center">
            <h2>Create an account & book your drive</h2>
            <p>With our InsightHeart Foundation Transportation Program, we are driving Seniors and Cancer Patients to their local scheduled medical appointments for FREE.</p>
            <div class="mt-5">
                <a href="{{url('/register')}}"><button type="button" class="btn btn-success btn-lg">Register as Client</button></a>
                <a href="{{url('/login')}}"><button type="button" class="btn btn-secondary btn-lg">Login</button></a>
            </div>
        </div>
    </div>
    <hr>

    <!-- image slider -->
    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h3>We are the InsighHeart Foundation</h3>
            </div>
            <div class="card-body">
                <div class="row d-flex flex-row justify-content-center">
                    <div class="col-md-6">
                        <div id="welcome-page-slider" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img class="img-fluid" src="/banner/logo-mark-version3.jpg" alt="First slide" style="border-radius:15px;">
                                </div>
                                <div class="carousel-item">
                                    <img class="img-fluid" src="/banner/logo-mark-version2.jpg" alt="Second slide" style="border-radius:15px; ">
                                </div>
                                <div class="carousel-item">
                                    <img class="img-fluid" src="/banner/logo-mark-version1.jpg" alt="Third slide" style="border-radius:15px;">
                                </div>
                                <div class="carousel-item">
                                    <img class="img-fluid" src="/banner/backpacks_4_smiles_aug2021_6.jpg" alt="Third slide" style="border-radius:15px;">
                                </div>
                                <div class="carousel-item">
                                    <img class="img-fluid" src="/banner/hope_food_drive_aug2021.jpg" alt="Third slide" style="border-radius:15px;">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#welcome-page-slider" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#welcome-page-slider" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end image slider -->


    <!-- search drivers -->
    <!-- added csrf -->
    <form action="{{url('/')}}" method="GET">@csrf
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                    <h3>Find a driver</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p>Our drivers are provided by a combination of volunteers and partner agency drivers. Our driver assistance includes support in and out of the vehicle, help handling groceries, and some mobility equipment. Escorts are recommended at no cost.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" name="date" class="form-control" id="datepicker">
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary btn-lg" type="submit">Find Drivers</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- display drivers -->
    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h3>Available Drivers</h3>
            </div>
            <div class="card-body">
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
                {{-- <div class="col-md-4">
                    <button  class="btn btn-primary btn-lg" type="submit">Find Drivers</button>
                </div> --}}

            </div>
        </div>

    </div>


</div>
@endsection