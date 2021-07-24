<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Auth::routes();




// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// protect driver route
// can only access if loggen in user is admin
//protected routes: driver, driver/create, driver/edit, driver/delete
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::resource('driver', 'DriverController');
});

// only driver can create check or update appointments
Route::group(['middleware' => ['auth', 'driver']], function () {
    Route::resource('appointment', 'AppointmentController');
    // this route will run the check method
    Route::post('/appointment/check', 'AppointmentController@check')->name('appointment.check');
    Route::post('/appointment/update', 'AppointmentController@updateTime')->name('update');
});
