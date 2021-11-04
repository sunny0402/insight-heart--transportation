## About

Transportation system.
Current routes:
/driver/create
/driver
/driver/id/edit (/driver/72/edit)

## TODO

search TODO to find incomplete tasks

reset password link
https://laravel.com/docs/8.x/passwords

Currently the styles use Bootstrap 4.6.0
Add driver form should have dropdown selection. This will also impact edit driver form.

After client log's in where are they redirected? Review where admin or doctor are redirected after log in.

Real time notifications to user. (Laravel Pusher, Laravel Echo)
https://pusher.com/laravel
https://laravel-livewire.com/docs/2.x/laravel-echo

Client rates drivers and drivers rate clients.

Automate app tasks suchs as marking trips complete. Custom commands and scheduling tasks.

Make mobile friendly or mobile version with Laravel.

prescriptions can be drivers saving notes

automate website manual tasks such as sending email or monthly updates with CRON jobs cloudways

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

## User Profiles

php artisan make:controller ProfileController

## Middleware to protect client routes

php artisan make:middleware Client

## Summary to Now

1. admin can create drivers.
2. drivers can create appointment times.
3. display appointment time of drivers on the frontend
4. create clients
5. client is able to book appointment
6. clients can create profile

Now client will take a ride with one of our drivers.

And so let's make a controller for the below:
Admin can see a list of clients that made booking for today's date.
Admin then can mark trips as complete.

php artisan make:controller ClientListController

## Errors

When route url same as folder name in public directory.

## How are we able to access datepicker in clientlist/index.blade.php

'''
views/admin/layouts/master.blade.php
@include('admin.layouts.header')
@include('admin.layouts.sidebar')

<div class="main-content">
    @yield('content')
</div>
@include('admin.layouts.footer')
'''

And footer.blade.php imports jquery and datepicker
And clientlist/index.blade.php extends master: @extends('admin.layouts.master')

## sidebar.blade.php

Only admin can see the create new drivers link.
Admin and drivers can view all appointments and toggle status.
Maybe should allow drivers to view only their scheduled trips.

## Add license plate column to users

php artisan make:migration add_license_plate_to_users_table --table=users

Production Tests
1 driver
2 admin
3 client

## Deploy

https://support.cloudways.com/en/articles/5128779-how-to-deploy-laravel-project-on-cloudways-server

View repo setting, then SSH keys. This is used for deployment.

Cloudways referral code: https://vrlps.co/w111Cun/cp

1.

RuntimeException
In order to use the Auth::routes() method, please install the laravel/ui package.

composer install

2. need to connect to server

SQLSTATE[HY000][1045] Access denied for user 'root'@'localhost' (using password: NO) (SQL: select \* from `appointments` where `date` = 2021-09-21)

vim .env

update

DB_DATABASE
DB_USERNAME
DB_PASSWORD

then to exit vim
escape key
shift+:
wq

3. need to run migrations and seed

SQLSTATE[42S02]: Base table or view not found: 1146 Table 'dcwgdezvez.appointments' doesn't exist (SQL: select \* from `appointments` where `date` = 2021-09-21)

fresh if first time

php artisan migrate:fresh
php artisan db:seed

4. public_html/storage/logs/laravel.log" could not be opened in append mode: faile
   d to open stream: Permission denied

    In Cloudways applicaion settings:

    RESET FILE / FOLDERS PERMISSIONS

5. SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long
   Make sure php version and sql version locally match the Cloudway versions

Check php mysql version locally
php artisan serve, then launch XAMPP

PHP version: 7.4.20
Server type: MariaDB
Server version: 10.4.19-MariaDB

Locally
laravel version: php artisan --version
Laravel Framework 8.46.0

And on Cloudways
[master_eucwayzrac]:public_html\$ php artisan--version Laravel Framework 8.61.0

Review Server setting and packages

timezone:
locally: date_default_timezone_set('America/Toronto');

cloudways:
MYSQL
TIMEZONE
(GMT-05:00) Eastern Time (US & Canada)

On Cloudways update packages:
PHP 7.4

update laravel locally

So after PHP updraged to version 7.4 and MariaDB to 10.4 on Cloudways migrations run succesfully.

php artisan migrate:fresh
php artisan db:seed

Error: 419 Page Expired
disabled varnish...

ErrorException
Trying to get property 'image' of non-object ...

https://stackoverflow.com/questions/51079896/trying-to-get-property-image-of-non-object-laravel

## SMTP

google
set up two factor authenticatio then create app password.
https://support.cloudways.com/en/articles/5131076-how-to-configure-gmail-smtp?utm_source=Platformkb&utm_medium=kbsearch

edit application default email address
https://support.cloudways.com/en/articles/5133526-set-from-address-from-the-cloudways-console

DEFAULT EMAIL SENDER temporarily change from:
dcwgdezvez@663449.cloudwaysapps.com
TO
alex.volsky@insightheart.ca

Email addons to consider later ...
https://support.cloudways.com/en/articles/5131071-which-email-add-on-should-i-use?utm_source=Platformkb&utm_medium=kbsearch

Laravel Mail
https://www.cloudways.com/blog/send-email-in-laravel/
Example from Article:
php artisan make:mail CloudHostingProduct

public function build()
{
return \$this->from('cloudways@cloudways.com')
->view('emails.CloudHosting.Product);
}

If you are using the same email address across the whole application, then you have to first configure it in the config/mail.php file.

'from' => ['address' => 'example@example.com', 'name' => 'App Name'],

public function build()
{
return \$this->view('emails.CloudHosting.Product);
}

Want to pass some data to the view function that you can utilize when rendering the email’s HTML? There are two ways to make data available to your view.

First, any public property defined in your mailable class will automatically be available to the view. For example, you may pass data into your mailable class’ constructor and set that data to public properties defined on the class:

<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
class SendMailable extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
   
    public function __construct($name)
    {
        $this->name = $name;
    }
    public function build()
    {
        return $this->view('emails.name');
    }
}

.... steps descriped in article

previous mailtrap settings in local .env file:

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=f2afaa3fcc5a67
MAIL_PASSWORD=0cf6d23b07d731
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=booking@insightheart.com
MAIL_FROM_NAME="${APP_NAME}"

These settings were updated to smtp.google.com on the Cloudways server.
The local .env file is not pushed to GitHub or Cloudways.
Can continue to test email notfiications locally with mailtrap.


## Migration

Add appointment column to Booking table
stop local host to run below
php artisan make:migration add_appointment_to_bookings_table --table=bookings
php artisan migrate



php artisan make:mail CancelAppointmentMail


## TODO

Client should be able to specify pickup location and drop off point.

SMS notification once driver is close.


## Debugging Notes

When images are uploaded when creating a profile they should be in /profile.

debug to screen
driverclients.blade.php
Is user photo saved to profile directory?
<p>{{ file_exists(public_path('/profile/'.$a_booking->user->image))}}</p>


## DB Queries
https://www.scratchcode.io/laravel-multiple-where-conditions-with-example/
https://www.scratchcode.io/how-to-print-or-debug-query-in-laravel/

https://laravel.com/docs/8.x/queries
The query builder also provides a convenient method to "union" two or more queries together. For example, you may create an initial query and use the union method to union it with more queries:

use Illuminate\Support\Facades\DB;

$first = DB::table('users')
            ->whereNull('first_name');

$users = DB::table('users')
            ->whereNull('last_name')
            ->union($first)
            ->get();

## Debug Null Object
https://medium.com/@maxalmonte14/working-with-null-objects-in-laravel-b24d7ccf03dc
Null objects 
error:
“Trying to get property ‘id’ of non-object”
php artisan make:model MissingUser


## Git Branches
git branch test_null_object
git checkout test_null_object
git add .
git commit -m "null object edits to test_null_objects branch"
git checkout main
git log to track changes
go into main branch where want to merge into
the git merge <branch name>
:wq to save commit message
git push only pushes current active branch
to push the test_null_objects branch
git checkout test_null_objects
git push --set-upstream origin test_null_objects
To delete a branch git bracnh -d <branch name>

## Query Builder
https://laravel.com/docs/8.x/queries

The get method returns an Illuminate\Support\Collection instance containing the results of the query where each result is an instance of the PHP stdClass object. Y

soget reutrns a collection. 

Collection methods.
https://laravel.com/docs/8.x/collections#available-methods


## TODO:
should images be stored in public folder?
https://biplabsinha345.medium.com/how-to-upload-image-to-storage-folder-in-laravel-8-b796f04ab964

## TODO

make sure deleting old images when profile updated with new image file_exists, unlink()
so server is not filled up
https://laravel.com/docs/8.x/filesystem#deleting-files
use Illuminate\Support\Facades\Storage;
Storage::delete($post->image);

        if ($request->hasFile('image')) {
            $imageName = (new User)->userAvatar($request);
            if (file_exists(public_path('images\\' . $user->image))) {
                //dd(public_path('images\\' . $user->image));
                //C:\xampp\htdocs\booking-system\public\images\5TX1d7Za9S4XAh8KHillekrDqafguUBV1NRDGnjg.jpg
                Storage::delete(public_path('images\\' . $user->image));
                //unlink(public_path('images\\' . $user->image));
            }

## SMS Notifications
https://laravel.com/docs/8.x/notifications#sms-notifications
https://www.tutsmake.com/laravel-8-send-sms-to-mobile-with-nexmo-example/
https://www.vonage.com/communications-apis/sms/pricing/


## Add Locations Table
Store pickup and dropoff information.
php artisan make:model Location --migration
Will correspond to locations table
php artisan migrate


Add column to existing table
for example appointmentNum column to users table
php artisan make:migration add_appointmentNum_to_locations_table --table=locations
php artisan migrate

TODO: need to add validation to location fields since they are directly from user input
TODO: specify foreign keys and laravel

## TODO
TODO: google maps currently runs in frontend javascript. API key revealed in sources tab. Run in backend?
Google Maps auto complete field: https://remotestack.io/laravel-google-autocomplete-address-integration-example/


https://developers.google.com/maps/documentation/javascript/places-autocomplete#javascript
https://developers.google.com/maps/documentation/places/web-service/autocomplete

<!--
    Copyright 2021 Google LLC

    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at

        https://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.
  -->
<!DOCTYPE html>
<html>
  <head>
    <title>Address Selection</title>
    <style>
      body {
        margin: 0;
      }

      .sb-title {
        position: relative;
        top: -12px;
        font-family: Roboto, sans-serif;
        font-weight: 500;
      }

      .sb-title-icon {
        position: relative;
        top: -5px;
      }

      .card-container {
        display: flex;
        height: 500px;
        width: 300px;
      }

      .panel {
        background: white;
        width: 300px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
      }

      .half-input-container {
        display: flex;
        justify-content: space-between;
      }

      .half-input {
        max-width: 120px;
      }

      h2 {
        margin: 0;
        font-family: Roboto, sans-serif;
      }

      input {
        height: 30px;
      }

      input {
        border: 0;
        border-bottom: 1px solid black;
        font-size: 14px;
        font-family: Roboto, sans-serif;
        font-style: normal;
        font-weight: normal;
      }

      input:focus::placeholder {
        color: white;
      }

      .button-cta {
        height: 40px;
        width: 40%;
        background: #3367d6;
        color: white;
        font-size: 15px;
        text-transform: uppercase;
        font-family: Roboto, sans-serif;
        border: 0;
        border-radius: 3px;
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.48);
        cursor: pointer;
      }
    </style>
    <script>
    "use strict";

    function initMap() {
      const componentForm = [
        'location',
        'locality',
        'administrative_area_level_1',
        'country',
        'postal_code',
      ];
      const autocompleteInput = document.getElementById('location');
      const autocomplete = new google.maps.places.Autocomplete(autocompleteInput, {
        fields: ["address_components", "geometry", "name"],
        types: ["address"],
      });
      autocomplete.addListener('place_changed', function () {
        const place = autocomplete.getPlace();
        if (!place.geometry) {
          // User entered the name of a Place that was not suggested and
          // pressed the Enter key, or the Place Details request failed.
          window.alert('No details available for input: \'' + place.name + '\'');
          return;
        }
        fillInAddress(place);
      });

      function fillInAddress(place) {  // optional parameter
        const addressNameFormat = {
          'street_number': 'short_name',
          'route': 'long_name',
          'locality': 'long_name',
          'administrative_area_level_1': 'short_name',
          'country': 'long_name',
          'postal_code': 'short_name',
        };
        const getAddressComp = function (type) {
          for (const component of place.address_components) {
            if (component.types[0] === type) {
              return component[addressNameFormat[type]];
            }
          }
          return '';
        };
        document.getElementById('location').value = getAddressComp('street_number') + ' '
                  + getAddressComp('route');
        for (const component of componentForm) {
          // Location field is handled separately above as it has different logic.
          if (component !== 'location') {
            document.getElementById(component).value = getAddressComp(component);
          }
        }
      }
    }
    </script>
  </head>
  <body>
    <div class="card-container">
      <div class="panel">
        <div>
          <img class="sb-title-icon" src="https://fonts.gstatic.com/s/i/googlematerialicons/location_pin/v5/24px.svg" alt="">
          <span class="sb-title">Address Selection</span>
        </div>
        <input type="text" placeholder="Address" id="location"/>
        <input type="text" placeholder="Apt, Suite, etc (optional)"/>
        <input type="text" placeholder="City" id="locality"/>
        <div class="half-input-container">
          <input type="text" class="half-input" placeholder="State/Province" id="administrative_area_level_1"/>
          <input type="text" class="half-input" placeholder="Zip/Postal code" id="postal_code"/>
        </div>
        <input type="text" placeholder="Country" id="country"/>
        <button class="button-cta">Submit</button>
      </div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaCCLLPQH7MjUuJzYanhbwT4BTwO--QT8&libraries=places&callback=initMap&channel=GMPSB_addressselection_v1_cAC" async defer></script>
  </body>
</html>

<!-- simple script for autocomplete -->
<!-- as described in the video on this page -->
  <script>
      let autocomplete;
      function initAutocomplete(){
          autocomplete = new google.maps.places.Autocomplete(
              document.getElementById('autocomplete'),
              {
                  types: ['address'],
                  componentRestrictions: {'country':['CA']},
                  fields: ['places_id','geometry','name']});
        // what to do when user selects one of the predictions
        autocomplete.addListener('place_changed', onPlaceChanged);
      }

      function onPlaceChanged(){
          var place = autocomplete.getPlace();
          if(! place.geometry){
              //user did not select prediction; reset the input field
              document.getElementById('autocomplete').placeholder = 'Enter an address';
          }
          else{
              //display details about the valid place
              document.getElementById('details').innerHTML = place.name;
          }
      }
  </script>



## TODO: Delete Old Profile Image When User/Driver updates profile
https://laravel.com/docs/8.x/filesystem#deleting-files
https://thecodebeast.com/how-to-delete-image-file-on-laravel-storage/
The delete method accepts a single filename or an array of files to delete:

use Illuminate\Support\Facades\Storage;

Storage::delete('file.jpg');

Storage::delete(['file.jpg', 'file2.jpg']);

## Protected vs Fillable
whats the difference between fillable and guard in laravel?
https://stackoverflow.com/questions/39616009/whats-the-difference-between-fillable-and-guard-in-laravel


## Soft Delets
https://blog.quickadminpanel.com/one-to-many-with-soft-deletes-deleting-parent-restrict-or-cascade/

Or handling 404
https://laravel-news.com/route-missing-method
