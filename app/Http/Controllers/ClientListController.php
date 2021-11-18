<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;

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
            // foreach ($bookings as $a_booking) {
            //     echo ($a_booking);
            // }
            //dd($bookings);
            return view('admin.clientlist.index', compact('bookings'));
        }
        // otherwise display all
        $bookings = Booking::latest()->paginate(30);

        // foreach ($bookings as $a_booking) {
        //     echo (var_dump($a_booking->user));
        // }
        //die();
        // array(16) { ["id"]
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
        $bookings = Booking::latest()->where('driver_id', auth()->user()->id)->paginate(15);
        // dd($bookings);
        return view('admin.clientlist.driverclients', compact('bookings'));
    }

    // allow admin to view all clients who are registered in the system
    public function allClients(Request $request)
    {
        date_default_timezone_set('America/Toronto');

        // $res = Product::select("name")
        // ->where("name","LIKE","%{$request->term}%")
        // ->get();

        // if serach term provided by form return user which matches that name
        // where usually AND orwhere
        if ($request->searchTerm) {
            $the_user = User::where('role_id', 3)->where("name", "LIKE", "%{$request->searchTerm}%")
                ->paginate(15);
            // foreach ($the_user as $a_user) {
            //     var_dump($a_user);
            // }
            // die();
            //dd($bookings);
            return view('admin.clientlist.allsystemclients', compact('the_user'));
        }
        // otherwise display all
        $all_users = User::where('role_id', 3)->paginate(15);

        return view('admin.clientlist.allsystemclients', compact('all_users'));
    }
}
