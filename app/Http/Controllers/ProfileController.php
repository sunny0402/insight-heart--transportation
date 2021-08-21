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
        // dd($request->all());
        // below update code can be reduced to
        // ->update($request->except('_token'));
        User::where('id', auth()->user()->id)
            ->update([
                'name' => $request->name,
                'address' => $request->address,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'description' => $request->description
            ]);

        return redirect()->back()->with('message', 'Profile Updated');
    }

    public function profilePicture(Request $request)
    {
        $this->validate($request, ['file' => 'required|image|mimes:jpeg,jpg,png']);
        if ($request->hasFile('file')) {
            $image = $request->file('file');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destination = public_path('/profile');
            $image->move($destination, $name);
            $newUserImage = User::where('id', auth()->user()->id)->update(['image' => $name]);
            return redirect()->back()->with('message', 'Profile Photo Updated.');
        }
    }
}
