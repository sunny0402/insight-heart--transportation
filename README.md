## About

Transportation system.
Current routes:
/driver/create
/driver
/driver/id/edit (/driver/72/edit)

## TODO

search TODO to find incomplete tasks
Currently the styles use Bootstrap 4.6.0
Add driver form should have dropdown selection. This will also impact edit driver form.

search TODO in project to review other TODOs

## Notes

Accounts For Testing

Admin Accounts
admin@mail.com
12344321

Driver Accounts
driver1@mail.com
driver1@mail.com

driver2@mail.com
driver2@mail.com

Development server
php artisan serve

https://github.com/ThemeKit/BootstrapAdmin

Add column to existing table
for example gender column to users table
php artisan make:migration add_gender_to_users_table --table=users
php artisan migrate

Add entry to existing table

```
//DatabaseSeeder.php
Role::create(['name' => 'driver']);
//php artisan db:seed
```

Add route

```
//web.php
Route::resource('driver', 'DriverController');
php artisan make:controller DriverController -r

//DriverController.php
public function create()
{
    return view('admin.driver.create');
}

//resources\views\admin\driver\create.blade.php
```

php artisan route:list
resource routing: Route::resource('driver', 'DriverController');

## Database Notes

Migration updates the database: https://laravel.com/docs/8.x/migrations

//create Model file and migration
php artisan make:model Role -m

My edits:

Department table changed to driver_region table

Users table:
department column changed to region column
education column changed to vehicle_info (make, model, color)
gender changed to license_plate

asset('images') targets the public directory: "app/public/images"

Bootstrap Modal
https://getbootstrap.com/docs/5.0/components/modal/

Give the User model access to the role information in the roles table.

```
//App\Models\User.php
    public function role()
    {
        // id from the roles table is a foreign key, role_id, in users table
        return $this->hasOne('App\Models\Role', 'id', 'role_id');
    }

//then can grab the role name

//App\Http\Controllers\DriverController.php

public function index()
{
    $users = User::get();
    return view('admin.driver.index', compact('users'));
}



//resources\views\admin\driver\index.blade.php
 @foreach($users as $user)
    {{$user->role->name}}
@endforeach
```

Middleware
php artisan make:middleware Admin
middleware so that driver and driver/create only accessed by middleware
register middleware in Kernel.php

php artisan make:middleware Driver

Appoitments
maintained by drivers ...
No longer than 20 minutes
6am to 10pm
php artisan make:controller AppoitmentController -r
php artisan make:model Appointment -m

Appointments Table:
appoitments can only be created by the driver
so the user_id refers to a driver
appointments: id/user_id/date

make another table for the time of appointment
status: 0 means appointment is still available
times: id/appointment_id/status:0

php artisan make:model Time -m
after creating migration migrate
php artisan migrate

// forein key which points to appointment table
\$table->integer('appointment_id');

Appointment validation
the same user_id should be able to create an appoitment for the same date/time
different user_id is able to

https://laravel.com/docs/8.x/validation#custom-validation-rules
Adding Additional Where Clauses:
For example, let's add a query condition that scopes the query to only search records that have an account_id column value of 1:

"""
'email' => Rule::unique('users')->where(function ($query) {
    return $query->where('account_id', 1);
})
"""

## Laravel Notes

How to pass data to views
https://www.geeksforgeeks.org/different-ways-for-passing-data-to-view-in-laravel/

## Frontend

Uses jquery datepicker: https://jqueryui.com/datepicker/
php artisan make:controller FrontendController

Appointment.php
'''
public function userIdToId()
{
// appointments table has user_id
// users table has id
// this function will take us from appointments table to users table
return \$this->belongsTo(User::class, 'user_id', 'id');
}

'''

## protect dashboard

php artisan make:controller DashboardController

TODO: limit privelleges of drivers. Make sure only admin can add drivers.
Not all drivers will be good need to be able to remove from system.

Right now drivers have access to dashboard
HomeController.php
'''
public function index()
{
if (Auth::user()->role->name == "admin" || Auth::user()->role->name = "driver") {
return redirect()->to('/dashboard');
}
return view('home');
}
''''

## Booking

php artisan make:model Booking -m

'''
Schema::create('bookings', function (Blueprint $table) {
            $table->id();
$table->integer('user_id');
            $table->integer('driver_id');
$table->string('time');
            // 0 means ride booked, but ride not taken/complete
            $table->integer('status')->default(0);
});
'''
php artisan migrate

Store information in bookings table and update times table
Get appointment_id to toggle status in times table

show appointments from times table with status 0
and once booked change the status to 1

add date column to bookings table

php artisan make:migration add_date_to_bookings_table --table=bookings

'''
public function up()
{
Schema::table('bookings', function (Blueprint $table) {
            $table->string('date');
});
}

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('date');
        });
    }

}
'''

php artisan migrate

## Booking Logic

welcome.blade.php
'''

    <a href="
    {{route('create.appointment', [$driver->user_id, $driver->date])}}
    ">

'''
After user selects an available driver and clicks the above link.

Get redirected to appointment.blade.php.

Which gets passed driverId = $driver->user_id and date = $driver->date

Route::get('/new-appointment/{driverId}/{date}', 'FrontendController@show')->name('create.appointment');

add timestamps to booking table

php artisan make:migration add_timestamps_to_bookings_table --table=bookings

limit users to one appointment every 24 hrs

php artisan make:mail AppointmentMail

## Display all booked appointments

-   make route
    web.php
    Route::get('/my-booking', 'FrontendController@myBookings')->name('my.booking')->middleware('auth');

-   update app view
    views/layouts/app.blade.php
    '''
    @if(auth()->user()->role->name === 'client')

    <li class="nav-item">
        <a class="nav-link" href="{{ route('my.booking') }}">{{ __('My Booking') }}</a>
    </li>
    @endif
    '''

-   controller logic
    FrontendController.php
    '''
    public function myBookings()
    {
    \$all_user_appointments = Booking::latest()->where('user_id', auth()->user()->id)->get();
    return view('booking.index', compact('appointments'));
    }

    '''
    update booking view

-   views/booking/index.blade.php
    Loop through all data ( \$all_user_appointments)
