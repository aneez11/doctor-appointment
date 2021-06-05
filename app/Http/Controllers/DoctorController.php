<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorLeave;
use App\Models\DoctorSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Notifications\AppointmentNotification;
use function PHPUnit\Framework\isEmpty;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors = Doctor::all();
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('doctors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
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
            'fees' => 'required|numeric',
            'qualification' => 'required',
            'specialist' => 'required'
        ]);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'dob' => $request->dob,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'fees' => $request->fees,
            'qualification' => $request->qualification,
            'specialist' => $request->specialist
        ];
        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->assignRole('doctor');
        $doctor = Doctor::create($data);
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('public/doctors', $image, $imageName);
            $doctor->update(['photo' => asset('storage/doctors/' . $imageName)]);
        }
        return redirect()->route('doctors.index')->with('success', 'Doctor added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Doctor $doctor
     * @return \Illuminate\Http\Response
     */
    public function show(Doctor $doctor)
    {
        $leaves = [];
        $myLeaves = $doctor->leaves;
        $now = Carbon::now();
        if ($myLeaves->count() > 0) {
            foreach ($myLeaves as $leave) {
                $newDate = Carbon::parse($leave->date);
                if (($newDate)->gt($now)) {
                    array_push($leaves, $leave->date);
                }
            }
        }
        return view('doctors.show', compact('doctor', 'leaves'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Doctor $doctor
     * @return \Illuminate\Http\Response
     */
    public function edit(Doctor $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Doctor $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('doctors')->ignore($doctor->id)],
            'dob' => ['required'],
            'gender' => ['required'],
            'phone' => 'required',
            'address' => 'required',
            'fees' => 'required|numeric',
            'qualification' => 'required',
            'specialist' => 'required'
        ]);
        //        || $request->email != $doctor->email
        if ($request->password != null) {
            $request->validate([
                'password' => ['string', 'min:8', 'confirmed'],
            ]);
            $doctor->user()->update(['email' => $request->email, 'password' => bcrypt($request->password)]);
        }
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'dob' => $request->dob,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'fees' => $request->fees,
            'qualification' => $request->qualification,
            'specialist' => $request->specialist,
            'isComplete' => true
        ];
        $doctor->update($data);
        $user =  User::findOrFail($doctor->user_id);
        $user->email = $request->email;
        $user->save();
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('public/doctors', $image, $imageName);
            $doctor->update(['photo' => asset('storage/doctors/' . $imageName)]);
        }
        return redirect()->route('doctors.show', $doctor->id)->with('success', 'Doctor Details Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Doctor $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->user()->delete();
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor Deleted Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addSchedule(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $schedule = DoctorSchedule::where('date',$request->date)->get();
        if($schedule->count() > 0){
            return back()->with('warning','Schedule for the date has already been created. Try next Date');
        }
        $request->validate([
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'max_patients' => 'required'
        ]);;
        $day = Carbon::createFromFormat('Y-m-d', $request->date)->format('l');
        $data = [
            'doctor_id' => $id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'day' => $day,
            'max_patients' => $request->max_patients,
            'status' => 1
        ];
        DoctorSchedule::create($data);
        return back()->with('success', 'Doctor Schedule Added Successfully');
    }
    public function editSchedule(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $schedule = DoctorSchedule::findOrFail($id);
        $request->validate([
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'max_patients' => 'required'
        ]);;
        $day = Carbon::createFromFormat('Y-m-d', $request->date)->format('l');
        $data = [
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'day' => $day,
            'max_patients' => $request->max_patients,
            'status' => 1
        ];
        $schedule->update($data);
        return back()->with('success', 'Doctor Schedule Updated Successfully');
    }
    public function changeStatus(Doctor $doctor)
    {
        // dd($patient);
        $status = $doctor->user->status;
        $newStatus = !$status;
        $doctor->user()->update(['status' => $newStatus]);
        if (Auth::user()->hasRole('doctor')){
            Auth::logout();
            return redirect('/login')->with('warning','Your Account has been disabled. Contact the System Administrator');
        }
        return back()->with('success', 'Doctor Status Changed');
    }
    public function addLeave(Doctor $doctor, Request $request)
    {

        $leaves = DoctorLeave::where('date', $request->date)->get();
        // dd($leaves->count() > 0);
        if ($leaves->count() == 0) {
            $schedule = $doctor->schedules()->where('date', $request->date)->first();
            if ($schedule != null) {
                $schedule->update(['status' => 1]);
                $appointments = Appointment::where('doctor_schedule_id', $schedule->id)->where('doctor_id', $doctor->id)->get();
                if ($appointments->count() != 0) {
                    foreach ($appointments as $appointment) {
                        $appointment->update(['status' => 3]);
                        $notification = [
                            'message' => 'Your appointment has been cancelled',
                            'date' => $appointment->schedule->date,
                            'time' => $appointment->time,
                            'patient' => $appointment->patient->name,
                            'doctor' => $appointment->doctor->name,
                        ];
                        $appointment->patient->user->notify(new AppointmentNotification($notification));
                    }
                }
            }
        } else {
            return back()->with('warning', 'Leave already created for the date');
        }

        DoctorLeave::create(['doctor_id' => $doctor->id, 'date' => $request->date]);
        // dd($doctor);
        $schedule = DoctorSchedule::where('date',$request->date)->first();
        if (isset($schedule)){
            $schedule->status = false;
            $schedule->save();
        }

        return back()->with('success', 'Doctor Leave Date added Successfully');
    }
}
