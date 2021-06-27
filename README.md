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

## Notes

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
