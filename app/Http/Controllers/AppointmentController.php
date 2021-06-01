<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Notifications\AppointmentNotification;
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
        $doctors = Doctor::all();
        $patients = Patient::all();
        if ($user->hasRole('admin')) {
            $appointments = Appointment::all();
        } elseif ($user->hasRole('doctor')) {
            $appointments = Appointment::where('doctor_id', $user->doctor->id)->get();
        } elseif ($user->hasRole('patient')) {
            $appointments = Appointment::where('patient_id', $user->patient->id)->get();
        }
        return view('appointments.index', compact('appointments', 'doctors', 'patients'));
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
        // dd($request);
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
        // dd($data);
        $newApp = Appointment::create($data);
        $notification = [
            'message' => 'appointment Has Been Created',
            'date' => $request->date,
            'time' => $request->time,
            'patient' => $newApp->patient->name,
            'doctor' => $newApp->doctor->name,
        ];

        if (isset($request->referral)) {
            $newApp->update(['referred_from' => $request->referral]);
            Appointment::findOrFail($request->referral)->update(['status' => 2, 'referred_to' => $newApp->id]);
            $notification['message'] = 'Appointment Referred';
            $newApp->patient->user->notify(new AppointmentNotification($notification));
            $newApp->doctor->user->notify(new AppointmentNotification($notification));
            return back()->with('success', 'Referred to another doctor successfully');
        }
        $newApp->patient->user->notify(new AppointmentNotification($notification));
        $newApp->doctor->user->notify(new AppointmentNotification($notification));
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
        $doctors = Doctor::all();
        return view('appointments.show', compact('appointment', 'doctors'));
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
        // dd($request);
        $request->validate([
            'patient_id' => 'required',
            'doctor_id' => 'required',
            'doctor_schedule_id' => 'required',
            'time' => 'required',
            'description' => 'required'
        ]);
        $appointmentNumber = sprintf("%03u-%s-%s", $request->doctor_id, $request->date, $request->time);
        $data = [
            'doctor_id' => $request->doctor_id,
            'patient_id' => $request->patient_id,
            'doctor_schedule_id' => $request->doctor_schedule_id,
            'appointment_number' => $appointmentNumber,
            'reason' => $request->description,
            'time' => $request->time,
            'status' => 0
        ];
        $appointment->update($data);
        $notification = [
            'message' => 'Appointment Has Ben Updated',
            'date' => $appointment->schedule->date,
            'time' => $appointment->time,
            'patient' => $appointment->patient->name,
            'doctor' => $appointment->doctor->name,
        ];
        $appointment->patient->user->notify(new AppointmentNotification($notification));
        $appointment->doctor->user->notify(new AppointmentNotification($notification));
        return back()->with('success', 'Appointment Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function cancel(Appointment $appointment)
    {
        // dd($appointment);
        $appointment->update(['status' => 3]);
        $notification = [
            'message' => 'appointment Has beeb Cancelled',
            'date' => $appointment->schedule->date,
            'time' => $appointment->time,
            'patient' => $appointment->patient->name,
            'doctor' => $appointment->doctor->name,
        ];
        $appointment->patient->user->notify(new AppointmentNotification($notification));
        $appointment->doctor->user->notify(new AppointmentNotification($notification));
        return back()->with('success', 'Appointment Cancelled Successfully');
    }
    public function complete(Appointment $appointments)
    {
        // dd($appointments);
        $appointments->update(['status' => 1]);
        return back()->with('success', 'Appointment Completed Successfully');
    }
}
