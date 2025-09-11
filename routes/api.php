<?php

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
 
Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
 
    return ['token' => $token->plainTextToken];
});

Route::get('/welcome-api', function () {
    return response()->json([
        'message' => 'Welcome to HMS API'
    ]);
});

Route::get('/doctors', function () {
    $doctors = Doctor::all();
    return response()->json($doctors);
});

Route::get('/doctors/{id}', function ($id) {
    $doctor = Doctor::findOrFail($id);
    return response()->json($doctor);
});