@extends('admin.layouts.master')

@section('content')
<!-- form-component.html -->
<div class="page-header">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <i class="ik ik-edit bg-blue"></i>
                <div class="d-inline">
                    <h5>Driver Availability</h5>
                    <span>Select times you are available.</span>
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
                    <li class="breadcrumb-item active" aria-current="page">Appointment</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container">
    @if(Session::has('message'))
    <div class="alert bg-success alert-success text-white">
        {{Session::get('message')}}
    </div>
    @endif
    <form action="{{route('appointment.store')}}" method="post">@csrf
        <div class="card">
            <div class="card-header">
                Choose date
            </div>
            <div class="card-body">
                <input type="text" class="form-control datetimepicker-input" id="datepicker" data-toggle="datetimepicker" data-target="#datepicker" name="date">
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                Choose your AM times.
                <span style="margin-left: 700px">Select All
                    <!-- select all time slots -->
                    <input type="checkbox" onclick="for (c in document.getElementsByName('time[]'))
                        document.getElementsByName('time[]').item(c).checked=this.checked">
                </span>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tbody>

                        <tr>
                            <th scope="row">1</th>
                            <td><input type="checkbox" name="time[]" value="7.00am">7.00am</td>
                            <td><input type="checkbox" name="time[]" value="7.30am">7.30am</td>
                            <td><input type="checkbox" name="time[]" value="8.00am">8.00am</td>
                        </tr>

                        <tr>
                            <th scope="row">2</th>
                            <td><input type="checkbox" name="time[]" value="8.30am">8.30am</td>
                            <td><input type="checkbox" name="time[]" value="9.00am">9.00am</td>
                            <td><input type="checkbox" name="time[]" value="9.30am">9.30am</td>
                        </tr>

                        <tr>
                            <th scope="row">3</th>
                            <td><input type="checkbox" name="time[]" value="10.00am">10.00am</td>
                            <td><input type="checkbox" name="time[]" value="10.30am">10.30am</td>
                            <td><input type="checkbox" name="time[]" value="11.00am">11.00am</td>
                        </tr>

                        <tr>
                            <th scope="row">4</th>
                            <td><input type="checkbox" name="time[]" value="11.30am">11.30am</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="card">
            <div class="card-header">
                Choose your PM times.
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tbody>

                        <tr>
                            <th scope="row">5</th>
                            <td><input type="checkbox" name="time[]" value="12.00pm">12.00pm</td>
                            <td><input type="checkbox" name="time[]" value="12.30pm">12.30pm</td>
                            <td><input type="checkbox" name="time[]" value="1.00pm">1.00pm</td>
                        </tr>

                        <tr>
                            <th scope="row">6</th>
                            <td><input type="checkbox" name="time[]" value="1.30pm">1.30pm</td>
                            <td><input type="checkbox" name="time[]" value="2.00pm">2.00pm</td>
                            <td><input type="checkbox" name="time[]" value="2.30pm">2.30pm</td>
                        </tr>

                        <tr>
                            <th scope="row">7</th>
                            <td><input type="checkbox" name="time[]" value="3.00pm">3.00pm</td>
                            <td><input type="checkbox" name="time[]" value="3.30pm">3.30pm</td>
                            <td><input type="checkbox" name="time[]" value="4.00pm">4.00pm</td>
                        </tr>

                        <tr>
                            <th scope="row">8</th>
                            <td><input type="checkbox" name="time[]" value="4.30pm">4.30pm</td>
                            <td><input type="checkbox" name="time[]" value="5.00pm">5.00pm</td>
                            <td><input type="checkbox" name="time[]" value="5.30pm">5.30pm</td>
                        </tr>


                        <tr>
                            <th scope="row">9</th>
                            <td><input type="checkbox" name="time[]" value="6.00pm">6.00pm</td>
                            <td><input type="checkbox" name="time[]" value="6.30pm">6.30pm</td>
                            <td><input type="checkbox" name="time[]" value="7.00pm">7.00pm</td>
                        </tr>

                        <tr>
                            <th scope="row">10</th>
                            <td><input type="checkbox" name="time[]" value="7.30pm">7.30pm</td>
                            <td><input type="checkbox" name="time[]" value="8.00pm">8.00pm</td>
                        </tr>


                    </tbody>
                </table>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>

<style type="text/css">
    input[type="checkbox"] {
        zoom: 1.5;
    }

    body {
        font-size: 18px;
    }
</style>

@endsection