<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Time;
//use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.appointment.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.appointment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required|unique:appointments,date,NULL,id,user_id,' . \Auth::id(),
            'time' => 'required'
        ]);
        // dd($request->all());
        $appointment = Appointment::create([
            // currently logged in id of user
            // user is a driver since only they can create appointments
            'user_id' => auth()->user()->id,
            'date' => $request->date
        ]);

        //display id of last inserted appointment
        //dd($appointment->id);

        foreach ($request->time as $time) {
            Time::create([
                // forein key which points to appointment table
                'appointment_id' => $appointment->id,
                'time' => $time,
                // default set to 0 ... view migration file
                // 'status' => 0
            ]);
        }
        return redirect()->back()->with('message', 'Appointment created for' . $request->date);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // based on date should get appointment id
    // then get all time from Times table
    public function check(Request $request)
    {
        $date = $request->date;
        // user_id is that of the currently logged in user
        // first() is to get first such record
        $appointment = Appointment::where('date', $date)->where('user_id', auth()->user()->id)->first();

        if (!$appointment) {
            return redirect()->to('/appointment')->with('errmessage', 'Appointment has not been created for this date.');
        }
        $appointmentId = $appointment->id;
        // times table has column appointment_id
        $times = Time::where('appointment_id', $appointmentId)->get();
        return view('admin.appointment.index', compact('times', 'appointmentId', 'date'));
    }
}
