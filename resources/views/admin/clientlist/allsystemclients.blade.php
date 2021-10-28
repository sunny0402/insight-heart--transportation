@extends('admin.layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <!-- your appointments -->
                <div class="card-header">
                    <h3>Transportation System Clients</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10"> 
                            @if(isset($all_users))
                            <ul>
                                <li> Number of clients:  {{$all_users->count()}}</li>
                            </ul>
                            @else
                                @foreach ($the_user as $key => $a_user)
                                <ul>
                                    <li>User {{$key}}: {{$a_user->name}}</li>
                                </ul>
                                @endforeach 
                            @endif
                        </div>
                    </div>
                </div>
                <form action="{{route('all.clients')}}" method="GET">
                    <div class="card-header">
                        Filter:
                        <div class="row">
                            <div class="col-md-8">
                                <input type="text" placeholder="enter first name" class="form-control" id="clientsearch" name="searchTerm">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">View All</button>
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
                                <th scope="col">Client Name</th>
                                <th scope="col">Client Email</th>
                                <th scope="col">Client Phone</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse( ($all_users ?? $the_user) as $key=>$a_client)
                            {{-- <p>{{public_path('/profile/'.$a_booking->user->image) }}</p> --}}
                            <tr>
                                <!-- fromBookingToUserTable and user relationships defined in Booking model, Booking.php  -->
                                <th scope="row">{{$key+1}}</th>
                                <td>
                                    <!-- images uploaded when creating profile go to /profile review ProfileController  -->
                                    <!-- if no image saved in users table -->
                                    @if(! isset($a_client->image) )
                                        <img src="images/pPmrx54SH8qqrdQJYALpOuswkuwimLpY2sZaRtlH.png" width="80">
                                    @elseif(public_path("/profile/{{$a_client->image}}") )
                                    {{-- example, if image at: public/images/myimage.jpg --}}
                                    {{-- <img src="{{url('/images/myimage.jpg')}}" alt="Image"/> --}}
                                        <img src="{{url('/profile/'.$a_client->image)}}" width="80" style="border-radius:50%;">
                                    @else
                                        <img src="images/pPmrx54SH8qqrdQJYALpOuswkuwimLpY2sZaRtlH.png" width="80">
                                    @endif 
                                </td>
                                <td>{{$a_client->name}}</td>
                                <td>{{$a_client->email}}</td>
                                <td>{{$a_client->phone_number}}</td>
                            </tr>
                            @empty
                            <td>There are registed clients with this name.</td>
                            @endforelse
                        </tbody>
                    </table>

                </div>
                  {{-- TODO: pagination --}}
                  @if(isset($all_users))
                    {{$all_users->links()}}
                  @elseif(isset($the_user))
                    {{$the_user->links()}}
                  @endif                
            </div>
        </div>
    </div>
</div>
@endsection