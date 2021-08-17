<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Time;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentMail;

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

    public function show($driverId, $date)
    {
        $appointment = Appointment::where('user_id', $driverId)->where('date', $date)->first();
        $times = Time::where('appointment_id', $appointment->id)->where('status', 0)->get();
        $user = User::where('id', $driverId)->first();
        $driver_id = $driverId;
        //return $times;
        return view('appointment', compact('times', 'date', 'user', 'driver_id'));
    }
    // date from welcome.blade.php: <input type="text" name="date" class="form-control" id="datepicker">
    // so drivers not just for today's date but any date selected in the calender
    public function findDriversBasedOnDate($date)
    {
        $available_drivers = Appointment::where('date', $date)->get();
        return $available_drivers;
    }

    public function store(Request $request)
    {
        date_default_timezone_set('America/Toronto');

        $request->validate(['time' => 'required']);

        // check if user already booked appointment for today
        $check = $this->checkBookingTimeInterval();

        // if already booked appointment redirect back
        if ($check) {
            return redirect()->back()->with(
                'errmessage',
                'You already made an appointment.Please wait 24hrs to make another appointment.'
            );
        }

        // status 0 here signifies booked but not yet attented
        Booking::create([
            'user_id' => auth()->user()->id,
            'driver_id' => $request->driverId,
            'time' => $request->time,
            'date' => $request->date,
            'status' => 0
        ]);

        // update the times table to reflect that that time is now booked
        // update the status from 0 to 1 in time table
        Time::where(
            'appointment_id',
            $request->appointmentId
        )->where('time', $request->time)->update(['status' => 1]);

        // send email notification to currently logged in user
        $driver_info = User::where('id', $request->driverId)->first();
        $mailData = [
            'name' => auth()->user()->name,
            'time' => $request->time,
            'date' => $request->date,
            'driverName' => $driver_info->name,
            'driverPhone' => $driver_info->phone_number

        ];
        try {
            Mail::to(auth()->user()->email)->send(new AppointmentMail($mailData));
        } catch (\Exception $e) {
            //
        }


        return redirect()->back()->with('message', 'Appointment booked!');
    }

    // do NOT allow user to make more than 1 booking in a 24 hour period
    // by checking created_at column
    public function checkBookingTimeInterval()
    {
        //where: check if currently logged in user in the bookings table
        //where: check if date in created_at column same as today's date
        //exists returns true or false if both above where are true
        return Booking::orderby('id', 'desc')
            ->where('user_id', auth()->user()->id)
            ->whereDate('created_at', date('Y-m-d'))
            ->exists();
    }

    public function myBookings()
    {
        $all_user_appointments = Booking::latest()->where('user_id', auth()->user()->id)->get();
        return view('booking.index', compact('all_user_appointments'));
    }
}
