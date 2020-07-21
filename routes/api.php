<?php

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

Route::apiResource('patient', 'PatientController');
Route::apiResource('patient/{patient_id}/treatment', 'TreatmentController');
Route::get('profile', 'PatientController@profile');
Route::get('findPatient', 'PatientController@search');
Route::post('notification','NotificationController@index');
Route::post('notification','NotificationController@index');
Route::post('markAsRead','NotificationController@markAsRead');
Route::post('markAllRead','NotificationController@markAllRead');
Route::post('booking','NotificationController@booking');
Route::post('/booking/{patient}','BookingController@booked');
Route::delete('/booking/{patient}','BookingController@destroy');
Route::post('/bookedpatient','BookingController@bookedPatient');
Route::get('/dailyincome','TreatmentController@dailyIncome');
Route::get('/monthlyincome','TreatmentController@getMonthlySum');
Route::get('/yearlyincome','TreatmentController@yearlyIncome');








