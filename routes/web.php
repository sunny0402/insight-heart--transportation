<?php

use App\Http\Controllers\FrontendController;
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

Route::get('/', 'FrontendController@index');
// anyone can view homepage or view drivers availability. don't have to be loggen in
Route::get('/new-appointment/{driverId}/{date}', 'FrontendController@show')->name('create.appointment');

Route::group(['middleware' => ['auth', 'client']], function () {
    // store users appointment into bookings table
    Route::post('/book/appointment', 'FrontendController@store')->name('booking.appointment');
    Route::get('/my-booking', 'FrontendController@myBookings')->name('my.booking');
    //update booked appointment
    Route::post('/my-booking/cancel', 'FrontendController@cancelMyBooking')->name('cancel.my.booking');


    // view/update client profile
    Route::get('/user-profile', 'ProfileController@index');
    Route::post('/user-profile', 'ProfileController@store')->name('profile.store');
    Route::post('/profile-picture', 'ProfileController@profilePicture')->name('profile.picture');
});

Route::get('/dashboard', 'DashboardController@index');

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// protect driver route
// can only access if logged in user is admin
//protected routes: driver, driver/create, driver/edit, driver/delete
Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::resource('driver', 'DriverController');
    Route::get('/clients', 'ClientListController@index')->name('client');
    Route::get('/status/update/{id}', 'ClientListController@toggleStatus')->name('update.status');
    // TODO: allClients
    Route::get('/allclients', 'ClientListController@allClients')->name('all.clients');
});

// only driver can create check or update appointments
Route::group(['middleware' => ['auth', 'driver']], function () {
    Route::resource('appointment', 'AppointmentController');
    // this route will run the check method
    Route::post('/appointment/check', 'AppointmentController@check')->name('appointment.check');
    Route::post('/appointment/update', 'AppointmentController@updateTime')->name('update');
    // my edit
    Route::get('/myclients', 'ClientListController@viewDriverClients')->name('driverclients');
});
