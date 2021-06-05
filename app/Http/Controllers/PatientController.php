<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Patient::all();
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('patients.create');
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'dob' => ['required'],
            'gender' => ['required'],
            'phone' => 'required',
            'address' => 'required',
            'photo' => 'required',
            'marital_status' => 'required',
        ]);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'dob' => $request->dob,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'marital_status' => $request->marital_status,
        ];
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->assignRole('patient');
        $patient = Patient::create($data);
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('public/patients', $image, $imageName);
            $patient->update(['photo' => asset('storage/patients/' . $imageName)]);
        }
        return redirect()->route('patients.index')->with('success', 'Patient Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        $appointments = Appointment::where('patient_id', $patient->id)->get();
        $reports = Report::where('patient_id', $patient->id)->get();
        $doctors = Doctor::all();
        return view('patients.show', compact('patient', 'reports', 'appointments', 'doctors'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        //        dd($request);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('patients')->ignore($patient->id)],
            'dob' => ['required'],
            'gender' => ['required'],
            'phone' => 'required',
            'address' => 'required',
            'marital_status' => 'required',
        ]);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'dob' => $request->dob,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'marital_status' => $request->marital_status,
            'isComplete' => true
        ];
        //        $user = User::create([
        //            'email' => $request->email,
        //            'password' => bcrypt($request->password)
        //        ]);
        $patient->update($data);
        $user =  User::findOrFail($patient->user_id);
        $user->email = $request->email;
        $user->save();
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('public/patients', $image, $imageName);
            $patient->update(['photo' => asset('storage/patients/' . $imageName)]);
        }
        return redirect()->route('patients.show', $patient->id)->with('success', 'Patient Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        $patient->user()->delete();
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient Deleted Successfully');
    }
    public function changeStatus(Patient $patient)
    {
        // dd($patient);
        $status = $patient->user->status;
        $newStatus = !$status;
        $patient->user()->update(['status' => $newStatus]);
        if (Auth::user()->hasRole('patient')){
            Auth::logout();
            return redirect('/login')->with('warning','Your Account has been disabled. Contact the System Administrator');
        }
        return back()->with('success', 'Patient Status Changed');
    }
    public function doctors()
    {
        $doctors = Doctor::all();
        return view('patients.doctors.index', compact('doctors'));
    }
}
