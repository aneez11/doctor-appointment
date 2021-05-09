<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            $appointments = Appointment::all();
        } elseif ($user->hasRole('doctor')) {
            $appointments = Appointment::where('doctor_id', $user->doctor->id)->get();
        }
        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'doctor_schedule_id' => 'required',
            'time' => 'required',
            'description' => 'required'
        ]);
        $appointmentNumber = sprintf("%03u-%s-%s", $request->doctor_id, $request->date, $request->time);
        // dd($appointmentNumber);
        $data = [
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'doctor_schedule_id' => $request->doctor_schedule_id,
            'appointment_number' => $appointmentNumber,
            'reason' => $request->description,
            'time' => $request->time,
        ];
        Appointment::create($data);
        return back()->with('success', 'Appointment Created Successfully');
        // dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        // dd($appointment);
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
