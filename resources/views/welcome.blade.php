@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="/banner/login-page.jpg" class="img-fluid" style="border:1px solid #ccc;">
        </div>
        <div class="col-md-6">
            <h2>Create an account & book your drive</h2>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Autem, dolor dolores. Corrupti eos incidunt earum quidem explicabo quam sed ut totam. Itaque ut aliquam, ea porro iusto ducimus commodi ad!</p>
            <div class="mt-5">
                <button class="btn btn-success">Register as Client</button>
                <button class="btn btn-secondary">Login</button>
            </div>
        </div>
    </div>
    <hr>
    <!-- search drivers -->
    <div class="card">
        <div class="card-body">
            <div class="card-header">
                Find a driver
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <input type="date" name="date" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary" type="submit">Find Drivers</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- display drivers -->
    <div class="card">
        <div class="card-body">
            <div class="card-header">
                Available Drivers
            </div>
            <div class="card-body">
                <table class="table table-striped">
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
                        <tr>
                            <th scope="row">1</th>
                            <td>
                                <img src="/driver/sample-driver-image.jpg" width="150px" style="border-radius: 50%;">
                            </td>
                            <td>Name of driver</td>
                            <td>Mississauga</td>
                            <td><button class="btn btn-success">Schedule a ride</button></td>
                        </tr>
                    </tbody>

                </table>
                <div class="col-md-4">
                    <button class="btn btn-primary" type="submit">Find Drivers</button>
                </div>

            </div>
        </div>

    </div>


</div>
@endsection