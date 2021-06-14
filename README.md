## Notes

php artisan serve

https://github.com/ThemeKit/BootstrapAdmin

Add column to existing table
for example gender column to users table
php artisan make:migration add_gender_to_users_table --table=users
php artisan migrate

```
//DatabaseSeeder.php
Role::create(['name' => 'driver']);
//php artisan db:seed
```

```
//web.php
Route::resource('doctor', 'DoctorController');
php artisan make:controller DriverController -r
```
