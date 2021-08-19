@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">My Profile</div>

                <div class="card-body">
                    <p>Name: {{auth()->user()->name}}</p>
                    <p>Email: {{auth()->user()->email}}</p>
                    <p>Address: {{auth()->user()->address}}</p>
                    <p>Phone: {{auth()->user()->phone_number}}</p>
                    <p>My bio: {{auth()->user()->description}}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Update Profile</div>

                <div class="card-body">
                    <form action="{{route('profile.store')}}" method="post">@csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{auth()->user()->name}}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <input type="text" name="address" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{auth()->user()->email}}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone_number" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Bio</label>
                            <textarea name="description" class="form-control" cols="15" rows="5"></textarea>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">
                                Update Profile
                            </button>
                        </div>


                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">Update Photo</div>

                <div class="card-body">
                    <img src="images/pPmrx54SH8qqrdQJYALpOuswkuwimLpY2sZaRtlH.png" width="120">
                    <br><br>
                    <input type="file" name="image" class="form-control">
                    <br>
                    <button type="submit" class="btn btn-primary">Update Photo</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection