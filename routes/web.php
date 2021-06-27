<?php

use Illuminate\Support\Facades\Route;

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

Route::resource('appoitment', 'AppointmentController');
