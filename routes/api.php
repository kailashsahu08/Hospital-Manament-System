<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorApiController;
use App\Http\Controllers\PaymentController;
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

Route::get('/doctors',DoctorApiController::class.'@index');
Route::post('/doctors',DoctorApiController::class.'@store');
Route::put('/doctors/{id}',DoctorApiController::class.'@update');
Route::delete('/doctors/{id}',DoctorApiController::class.'@destroy');
Route::get('/doctors/{id}',DoctorApiController::class.'@show');
Route::post('/create-payment-intent', [PaymentController::class, 'createPaymentIntent']);

Route::apiResource('appointments', AppointmentController::class);