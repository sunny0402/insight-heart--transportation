## Notes

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
