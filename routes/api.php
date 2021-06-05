<?php

use App\Http\Controllers\DoctorScheduleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('doctor/{id}/schedules', [DoctorScheduleController::class, 'doctorSchedule'])->name('api.doctor.schedule');
Route::get('achedule/{date}/more', [DoctorScheduleController::class, 'more'])->name('api.doctor.schedule.more');
Route::get('check/{date}',[\App\Http\Controllers\AppointmentController::class,'check']);
