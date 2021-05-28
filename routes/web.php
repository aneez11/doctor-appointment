<?php

use App\Http\Controllers\PatientController;
use App\Http\Controllers\CheckupController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('admins', \App\Http\Controllers\AdminController::class)->middleware('auth', 'verified');
//patient
Route::resource('patients', \App\Http\Controllers\PatientController::class)->middleware('auth', 'verified');
Route::post('patient/{patient}/changeStatus', [\App\Http\Controllers\PatientController::class, 'changeStatus'])->middleware('auth', 'verified')->name('patient.changeStatus');
//reports
Route::post('patient/{patient}/report/create', [\App\Http\Controllers\ReportController::class, 'store'])->middleware('auth', 'verified')->name('patient.report.create');
Route::post('patient/report/{report}/update', [\App\Http\Controllers\ReportController::class, 'update'])->middleware('auth', 'verified')->name('patient.report.update');
Route::get('patient/doctors', [PatientController::class, 'doctors'])->name('patients.doctors');
//doctors
Route::resource('doctors', \App\Http\Controllers\DoctorController::class)->middleware('auth', 'verified');
Route::post('doctor/{doctor}/changeStatus', [\App\Http\Controllers\DoctorController::class, 'changeStatus'])->middleware('auth', 'verified')->name('doctor.changeStatus');
Route::post('doctor/{id}/createSchedule', [\App\Http\Controllers\DoctorController::class, 'addSchedule'])->middleware('auth', 'verified')->name('doctors.addSchedule');
Route::post('doctor/{id}/editSchedule', [\App\Http\Controllers\DoctorController::class, 'editSchedule'])->middleware('auth', 'verified')->name('doctors.editSchedule');
Route::post('doctor/{doctor}/addLeave', [\App\Http\Controllers\DoctorController::class, 'addLeave'])->middleware('auth', 'verified')->name('doctors.addLeave');
//appointments
Route::resource('appointments', \App\Http\Controllers\AppointmentController::class)->middleware('auth', 'verified');
Route::put('appointments/{appointments}/complete', [\App\Http\Controllers\AppointmentController::class, 'complete'])->middleware('auth', 'verified')->name('appointments.complete');
Route::put('appointments/{appointment}/cancel', [\App\Http\Controllers\AppointmentController::class, 'cancel'])->middleware('auth', 'verified')->name('appointments.cancel');

Route::resource('checkups', CheckupController::class)->middleware('auth', 'verified');
Route::get('home', function () {
    return view('home');
})->middleware('auth', 'verified')->name('dashboard');

Route::get('logout', [\App\Http\Controllers\UserController::class, 'logout'])->name('logout');

Route::get('profile', function () {
    $user = Auth::user();
    if ($user->hasRole('patient')) {
        return view('patients.profile.profile', compact('user'));
    } elseif ($user->hasRole('admin')) {
        return view('admins.profile.profile', compact('user'));
    } elseif ($user->hasRole('doctor')) {
        $leaves = [];
        $user = Auth::user();
        $myLeaves = $user->doctor->leaves;
        $now = Carbon\Carbon::now();
        if ($myLeaves->count() > 0) {
            foreach ($myLeaves as $leave) {
                $newDate = Carbon\Carbon::parse($leave->date);
                if (($newDate)->gt($now)) {
                    array_push($leaves, $leave->date);
                }
            }
        }
        return view('doctors.profile.profile', compact('user', 'leaves'));
    }
})->middleware('auth', 'verified')->name('profile');
