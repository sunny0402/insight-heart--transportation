<!-- Modal Bootstrap 4.6.0 -->
<div class="modal fade" id="exampleModal{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Driver Info</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><img src="{{asset('images')}}/{{$user->image}}" class="table-user-thumb" alt="" width="200">
                </p>
                <p class="badge badge-pill badge-dark">
                    <!-- from roles table grab the name of the role -->
                    <!-- have a foreign key in the users table pointing to the roles table -->
                    Role (Driver or Admin): {{$user->role->name}}
                </p>
                <p>Email: {{$user->email}}</p>
                <p>Address: {{$user->address}}</p>
                <p>Phone Number: {{$user->phone_number}}</p>
                <p>Region: {{$user->region}}</p>
                <p>Vehicle Info: {{$user->vehicle_info}}</p>
                <p>Description: {{$user->description}}</p>
                <p>License Plate: {{$user->license_plate}}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>