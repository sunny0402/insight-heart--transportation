<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //TODO: make dashboard for drivers different from admin dashboard
    public function index()
    {
        // check who is logged in
        // dd(Auth::user()->role->name);

        // redirect user to not home instead of admin dashboard
        // TODO: redirect back to welcome page to view available drivers...
        // return redirect()->back()->with('message', 'Loggen In. Book Appointment');
        // or edit home view
        if (Auth::user()->role->name == 'client') {
            return view('home');
        }

        return view('dashboard');
    }
}
