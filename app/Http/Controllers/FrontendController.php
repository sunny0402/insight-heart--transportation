<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Time;
use App\Models\User;

class FrontendController extends Controller
{
    public function index()
    {
        date_default_timezone_set('America/Toronto');

        //if have input. user seleceted a date different from today's date
        if (request('date')) {
            $available_drivers = $this->findDriversBasedOnDate(request('date'));
            return view('welcome', compact('available_drivers'));
        }

        // drivers based on today's date: date('Y-m-d')
        $available_drivers = Appointment::where('date', date('Y-m-d'))->get();
        return view('welcome', compact('available_drivers'));
    }

    public function show($doctorId, $date)
    {
        $appointment = Appointment::where('user_id', $doctorId)->where('date', $date)->first();
        $times = Time::where('appointment_id', $appointment->id)->where('status', 0)->get();
        $user = User::where('id', $doctorId)->first();
        //return $times;
        return view('appointment', compact('times', 'date', 'user'));
    }
    // date from welcome.blade.php: <input type="text" name="date" class="form-control" id="datepicker">
    // so drivers not just for today's date but any date selected in the calender
    public function findDriversBasedOnDate($date)
    {
        $available_drivers = Appointment::where('date', $date)->get();
        return $available_drivers;
    }
}
