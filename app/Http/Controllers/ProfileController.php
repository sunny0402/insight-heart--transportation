<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    // only name,email required when updating current user profile
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required'
        ]);
        User::where('id', auth()->user()->id)
            ->update([
                'name' => $request->name,
                'address' => $request->address,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'description' => $request->description
            ]);
    }
}
