<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->status == false) {
            Auth::logout();
            return redirect('/login')->with('warning','Your Account has been disabled. Contact the System Administrator');
        }
        if ($user->hasRole('patient')) {
            if ($user->patient->isComplete == false) {
                return redirect()->route('patients.edit', $user->patient->id)->with('success', 'Please Complete Your Profile first');
            }
            $appointments = Appointment::where('patient_id', Auth::user()->patient->id)->where('status', 0)->get();
            return view('home', compact('appointments'));
        } elseif (Auth::user()->hasRole('admin')) {
            $admins = Admin::all();
            $doctors = Doctor::all();
            $appointments = Appointment::where('status', 0)->get();
            $patients = Patient::all();
            return view('home', compact('admins', 'doctors', 'appointments', 'patients'));
        } elseif (Auth::user()->hasRole('doctor')) {
            if ($user->doctor->isComplete == false) {
                return redirect()->route('doctors.edit', $user->doctor->id)->with('success', 'Please Complete Your Profile first');
            }
            $appointments = Appointment::where('doctor_id', Auth::user()->doctor->id)->where('status', 0)->get();
            return view('home', compact('appointments'));
        }
        return view('home');
    }
}
