<?php

namespace App\Http\Controllers;

namespace App\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $admins = Admin::all();
        $doctors = Doctor::all();
        $appointment = Appointment::all();
        $patient = Patient::all();
        if (Auth::user()->role('patient')){
            $appointments = Appointment::where('patient_id',Auth::user()->patient->id)->get();
            return view('dashboard');
        }
//        return view('home', compact('admins', 'doctors', 'appointment', 'patient'));
    }
}
