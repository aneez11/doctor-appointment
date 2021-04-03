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
Route::get('patients',function (){
    return view('patients.index');
})->name('patients');
Route::get('users',function (){
    return view('users.index');
})->name('users');
Route::get('doctors',function (){
    return view('doctors.index');
})->name('doctors');
Route::get('appointments',function (){
    return view('appointments.index');
})->name('appointments');