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
            // dd($bookings);
            return view('admin.clientlist.index', compact('bookings'));
        }
        // otherwise display all
        $bookings = Booking::latest()->paginate(30);
        // dd($bookings);
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
}
