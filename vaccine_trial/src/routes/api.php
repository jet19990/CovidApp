<?php

use Illuminate\Http\Request;

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


Route::group([
  'prefix' => 'auth'
], function () {
  Route::post('token', 'AuthController@getToken');
});

Route::group([
    'middleware' => 'auth:api'
  ], function() {
    Route::post('submit/vaccination','VaccinationController@store');
    Route::get('/volunteers','VaccinationController@index');
    Route::get('/checkuservaccine','VaccinationController@checkUserVaccine');
    Route::post('/reportpositive', 'VaccinationController@reportPositive');

    Route::get('/userlist','HomeController@volunteers');
    Route::get('/vaccine/taken','VaccinationController@vaccinesTaken');
    Route::get('/vaccine/dose/taken','VaccinationController@vaccinesDoseTaken');
    Route::get('/vaccine/reported/result','VaccinationController@reportedResults');
    Route::get('/vaccine/positivecases','VaccinationController@positiveCasesPerDosage');
    Route::get('/vaccine/agepositivecases','VaccinationController@agePositiveCases');
    Route::get('/dashboardReport','VaccinationController@dashboardReport');

    Route::post('/requesttoken/store','ApiKeyController@store');
    Route::put('/requesttoken/reset','ApiKeyController@update');
    Route::get('/requesttoken/show','ApiKeyController@show');
    Route::get('/apikeys/requests','ApiKeyController@index');
    Route::post('/apikeys/requests/aprove/{id}','ApiKeyController@approveApiKey');
    Route::delete('/apikeys/requests/delete/{id}','ApiKeyController@destroy');

    Route::post('/update/threshold', 'ThresholdController@store');
    Route::get('/get/threshold', 'ThresholdController@index');
    
    Route::post('/update/profile', 'HomeController@updateProfile');




    Route::get('/vaccine/all_result','VaccinationController@allVaccines');
    Route::get('/vaccine/result','VaccinationController@search');
    
  });

  
  

  

  
