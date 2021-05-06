<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('admins',\App\Http\Controllers\AdminController::class);
Route::resource('patients',\App\Http\Controllers\PatientController::class);
//reports
Route::post('patient/{patient}/report/create',[\App\Http\Controllers\ReportController::class,'store'])->name('patient.report.create');
Route::resource('doctors',\App\Http\Controllers\DoctorController::class);
Route::post('doctor/{id}/createSchedule',[\App\Http\Controllers\DoctorController::class,'addSchedule'])->name('doctors.addSchedule');
Route::post('doctor/{id}/editSchedule',[\App\Http\Controllers\DoctorController::class,'editSchedule'])->name('doctors.editSchedule');
Route::resource('appointments',\App\Http\Controllers\AppointmentController::class);
Route::get('home',function (){
    return view('home');
})->name('dashboard');

Route::get('logout',[\App\Http\Controllers\UserController::class,'logout'])->name('logout');

//Route::get('patients',function (){
//    return view('patients.index');
//})->name('patients');
//Route::get('users',function (){
//    return view('users.index');
//})->name('users');
//Route::get('doctors',function (){
//    return view('doctors.index');
//})->name('doctors');
//Route::get('appointments',function (){
//    return view('appointments.index');
//})->name('appointments');
