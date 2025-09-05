<?php

use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/doctors', function () {
    return view('doctors');
});

Route::get('/doctors', [DoctorController::class, 'getAlDoctors']);
Route::get('/doctors/{doctor}/appointments', [DoctorController::class, 'viewAppointments'])->name('doctors.appointments');