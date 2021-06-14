@extends('admin.layouts.master')

@section('content')
<!-- form-component.html -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-edit bg-blue"></i>
                <div class="d-inline">
                    <h5>Drivers</h5>
                    <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <nav class="breadcrumb-container" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="../index.html"><i class="ik ik-home"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Driver</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header">
                <h3>Add Driver</h3>
            </div>
            <div class="card-body">
                <form class="forms-sample">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Full name</label>
                            <!-- name same as in db -->
                            <input type="text" name="name" class="form-control" placeholder="driver name">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="driver email">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Password</label>
                            <!-- name same as in db -->
                            <input type="password" name="password" class="form-control" placeholder="driver password">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Gender</label>
                            <select name="gender" class="form-control">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Decline to answer</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Education</label>
                            <!-- name same as in db -->
                            <input type="text" name="education" class="form-control" placeholder="driver skills">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Address</label>
                            <input type="text" name="address" class="form-control" placeholder="driver home address">
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Specialist</label>
                                <input type="text" name="department" class="form-control">

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Phone number</label>
                                <input type="text" name="phone_number" class="form-control">

                            </div>
                        </div>


                </form>
            </div>
        </div>
    </div>
</div>

@endsection