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

        // redirect user to home instead of admin dashboard
        if (Auth::user()->role->name == 'client') {
            return view('home');
        }

        return view('dashboard');
    }
}
