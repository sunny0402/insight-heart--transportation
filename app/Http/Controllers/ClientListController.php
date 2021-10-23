<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class ClientListController extends Controller
{
    public function index(Request $request)
    {
        date_default_timezone_set('America/Toronto');
        // to get only trips booked for today ...
        //$bookings = Booking::latest()->where('date', date('Y-m-d'))->get();

        // if date from form return appoitnments for that date
        if ($request->date) {
            $bookings = Booking::latest()->where('date', $request->date)->get();
            // $filtered_bookings = $bookings->reject(function ($key,$value) {
            //     $key === 'driver_id' });
            foreach ($bookings as $a_booking) {
                echo ($a_booking);
            }
            //dd($bookings);
            return view('admin.clientlist.index', compact('bookings'));
        }
        // otherwise display all
        $bookings = Booking::latest()->paginate(30);
        foreach ($bookings as $a_booking) {
            echo (var_dump($a_booking->user));
        }
        die();
        //dd($bookings);
        return view('admin.clientlist.index', compact('bookings'));
    }

    public function toggleStatus($id)
    {
        $booking = Booking::find($id);
        // toggle if status was 0 change to 1
        $booking->status = !$booking->status;
        $booking->save();
        return redirect()->back();
    }

    public function viewDriverClients(Request $request)
    {
        date_default_timezone_set('America/Toronto');
        // to get only trips booked for today ...
        //$bookings = Booking::latest()->where('date', date('Y-m-d'))->get();

        // if date from form return appoitnments for that date
        if ($request->date) {
            $whereCondition = [
                ['date', '=', $request->date],
                ['driver_id', '=', auth()->user()->id]
            ];
            // $bookings = Booking::latest()->where('date', '=', $request->date)
            //     ->where('driver_id', '=', auth()->user()->id)->get();
            $bookings = Booking::latest()->where($whereCondition)->get();
            // dd($bookings);
            return view('admin.clientlist.index', compact('bookings'));
        }
        // otherwise display all
        $bookings = Booking::latest()->where('driver_id', auth()->user()->id)->paginate(30);
        // dd($bookings);
        return view('admin.clientlist.driverclients', compact('bookings'));
    }
}
