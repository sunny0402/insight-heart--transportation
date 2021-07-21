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
    @if(Session::has('errmessage'))
    <div class="alert bg-danger alert-success text-white">
        {{Session::get('errmessage')}}
    </div>
    @endif
    @foreach($errors->all() as $error)
    <div class="alert alert-danger">
        {{$error}}
    </div>

    @endforeach
    <form action="{{route('appointment.check')}}" method="post">@csrf
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
    </form>
    @if(Route::is('appointment.check'))
    <form action="{{route('update')}}" method="post">@csrf
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
                        <input type="hidden" name="appointmentId" value="{{$appointmentId}}">

                        <tr>
                            <th scope="row">1</th>
                            <td><input type="checkbox" name="time[]" value="7.00am" @if(isset($times)) {{$times->contains('time','7.00am')?'checked':''}}@endif>
                                7.00am</td>
                            <td><input type="checkbox" name="time[]" value="7.30am" @if(isset($times)) {{$times->contains('time','7.30am')?'checked':''}}@endif>7.30am</td>
                            <td><input type="checkbox" name="time[]" value="8.00am" @if(isset($times)) {{$times->contains('time','8.00am')?'checked':''}}@endif>8.00am</td>
                        </tr>

                        <tr>
                            <th scope="row">2</th>
                            <td><input type="checkbox" name="time[]" value="8.30am" @if(isset($times)) {{$times->contains('time','8.30am')?'checked':''}}@endif>8.30am</td>
                            <td><input type="checkbox" name="time[]" value="9.00am" @if(isset($times)) {{$times->contains('time','9.00am')?'checked':''}}@endif>9.00am</td>
                            <td><input type="checkbox" name="time[]" value="9.30am" @if(isset($times)) {{$times->contains('time','9.30am')?'checked':''}}@endif>9.30am</td>
                        </tr>

                        <tr>
                            <th scope="row">3</th>
                            <td><input type="checkbox" name="time[]" value="10.00am" @if(isset($times)) {{$times->contains('time','10.00am')?'checked':''}}@endif>10.00am</td>
                            <td><input type="checkbox" name="time[]" value="10.30am" @if(isset($times)) {{$times->contains('time','10.30am')?'checked':''}}@endif>10.30am</td>
                            <td><input type="checkbox" name="time[]" value="11.00am" @if(isset($times)) {{$times->contains('time','11.00am')?'checked':''}}@endif>11.00am</td>
                        </tr>

                        <tr>
                            <th scope="row">4</th>
                            <td><input type="checkbox" name="time[]" value="11.30am" @if(isset($times)) {{$times->contains('time','11.30am')?'checked':''}}@endif>11.30am</td>
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
                            <td><input type="checkbox" name="time[]" value="12.00pm" @if(isset($times)) {{$times->contains('time','12.00pm')?'checked':''}}@endif>12.00pm</td>
                            <td><input type="checkbox" name="time[]" value="12.30pm" @if(isset($times)) {{$times->contains('time','12.30pm')?'checked':''}}@endif>12.30pm</td>
                            <td><input type="checkbox" name="time[]" value="1.00pm" @if(isset($times)) {{$times->contains('time','1.00pm')?'checked':''}}@endif>1.00pm</td>
                        </tr>

                        <tr>
                            <th scope="row">6</th>
                            <td><input type="checkbox" name="time[]" value="1.30pm" @if(isset($times)) {{$times->contains('time','1.30pm')?'checked':''}}@endif>1.30pm</td>
                            <td><input type="checkbox" name="time[]" value="2.00pm" @if(isset($times)) {{$times->contains('time','2.00pm')?'checked':''}}@endif>2.00pm</td>
                            <td><input type="checkbox" name="time[]" value="2.30pm" @if(isset($times)) {{$times->contains('time','2.30pm')?'checked':''}}@endif>2.30pm</td>
                        </tr>

                        <tr>
                            <th scope="row">7</th>
                            <td><input type="checkbox" name="time[]" value="3.00pm" @if(isset($times)) {{$times->contains('time','3.00pm')?'checked':''}}@endif>3.00pm</td>
                            <td><input type="checkbox" name="time[]" value="3.30pm" @if(isset($times)) {{$times->contains('time','3.30pm')?'checked':''}}@endif>3.30pm</td>
                            <td><input type="checkbox" name="time[]" value="4.00pm" @if(isset($times)) {{$times->contains('time','4.00pm')?'checked':''}}@endif>4.00pm</td>
                        </tr>

                        <tr>
                            <th scope="row">8</th>
                            <td><input type="checkbox" name="time[]" value="4.30pm" @if(isset($times)) {{$times->contains('time','4.30pm')?'checked':''}}@endif>4.30pm</td>
                            <td><input type="checkbox" name="time[]" value="5.00pm" @if(isset($times)) {{$times->contains('time','5.00pm')?'checked':''}}@endif>5.00pm</td>
                            <td><input type="checkbox" name="time[]" value="5.30pm" @if(isset($times)) {{$times->contains('time','5.30pm')?'checked':''}}@endif>5.30pm</td>
                        </tr>


                        <tr>
                            <th scope="row">9</th>
                            <td><input type="checkbox" name="time[]" value="6.00pm" @if(isset($times)) {{$times->contains('time','6.00pm')?'checked':''}}@endif>6.00pm</td>
                            <td><input type="checkbox" name="time[]" value="6.30pm" @if(isset($times)) {{$times->contains('time','6.30pm')?'checked':''}}@endif>6.30pm</td>
                            <td><input type="checkbox" name="time[]" value="7.00pm" @if(isset($times)) {{$times->contains('time','7.00pm')?'checked':''}}@endif>7.00pm</td>
                        </tr>

                        <tr>
                            <th scope="row">10</th>
                            <td><input type="checkbox" name="time[]" value="7.30pm" @if(isset($times)) {{$times->contains('time','7.30pm')?'checked':''}}@endif>7.30pm</td>
                            <td><input type="checkbox" name="time[]" value="8.00pm" @if(isset($times)) {{$times->contains('time','8.00pm')?'checked':''}}@endif>8.00pm</td>
                        </tr>


                    </tbody>
                </table>
            </div>
        </div>


        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </div>
</div>
</form>
@endif

<style type="text/css">
    input[type="checkbox"] {
        zoom: 1.5;
    }

    body {
        font-size: 18px;
    }
</style>

@endsection