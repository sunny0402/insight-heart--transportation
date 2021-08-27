<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  route example: driver/
    public function index()
    {
        // view currently logged in user
        // dd(\Auth::user()->role->name);

        // view drivers and admin but not clients
        $users = User::where('role_id', '!=', 3)->get();
        return view('admin.driver.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  route example: driver/create
    public function create()
    {
        return view('admin.driver.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // get everything from the form and display
        // dd($request->all());
        $this->validateStore($request);
        $data = $request->all();
        $name = (new User)->userAvatar($request);


        // append to image to data then store
        $data['image'] = $name;
        $data['password'] = bcrypt($request->password);
        // store in database
        User::create($data);

        //return redirect()->back()->with('message', 'Driver added successfully');
        return redirect()->route('driver.index')->with('message', 'Driver added
         successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //  route example: driver/1
    public function show($id)
    {
        // dd($id);
        $user = User::find($id);
        return view('admin.driver.delete', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //  route example: driver/1/edit
    public function edit($id)
    {
        // find which driver to edit
        $user = User::find($id);
        // dd($user);
        // compact creates array from variable and values
        return view('admin.driver.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateUpdate($request, $id);

        $data = $request->all();
        $user = User::find($id);

        //here $imageName is the image currently in the database
        $imageName = $user->image;
        $userPassword = $user->password;
        // see if image has been uploaded (see if it is in the request)
        if ($request->hasFile('image')) {
            $imageName = (new User)->userAvatar($request);
            unlink(public_path('images/' . $user->image));
        }
        // if new image has NOT been uploaded
        $data['image'] = $imageName;
        // if user supplied password
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        //if user has not provided new password
        else {
            $data['password'] = $userPassword;
        }

        // insert updated data into db
        $user->update($data);

        return redirect()->route('driver.index')->with('message', 'Driver updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // cannot delete yourself
        if (
            auth()->user()->id == $id
        ) {
            abort(401);
        }
        $user = User::find($id);
        $userDelete = $user->delete();
        // if deletion succesful remove picture
        if ($userDelete) {
            unlink(public_path('images/' . $user->image));
        }
        return redirect()->route('driver.index')->with('message', 'Driver deleted successfully');
    }
    public function validateStore($request)
    {
        return $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6|max:25',
            'license_plate' => 'required',
            'vehicle_info' => 'required',
            'address' => 'required',
            'region' => 'required',
            'phone_number' => 'required|numeric',
            'image' => 'required|mimes:jpeg,jpg,png',
            'role_id' => 'required',
            'description' => 'required|min:25'
        ]);
    }

    // password field left blank, password can remain or new typed in; email needs to be unique
    // if update same email pass id of user
    // 'email' => 'required|unique:users,email,' . $id
    public function validateUpdate($request, $id)
    {
        return $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'license_plate' => 'required',
            'vehicle_info' => 'required',
            'address' => 'required',
            'region' => 'required',
            'phone_number' => 'required|numeric',
            'image' => 'mimes:jpeg,jpg,png',
            'role_id' => 'required',
            'description' => 'required|min:25'
        ]);
    }
}
