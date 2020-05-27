<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;

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
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/LoggedInUser', function () {
        return Auth::user();
    });
    Route::get('/LogoutUser', function () {
        $user = Auth::user();
        return $user->tokens()->delete();
    });
    Route::put('resetpassword/{user}', 'Auth\ResetPasswordController@update');

    Route::apiResource('/users', 'UserController');
    Route::apiResource('/contacttype', 'Contact\ContactTypeController');
    Route::apiResource('/contact', 'Contact\ContactController');
});

Route::get('/register', 'Auth\RegisterController@register');

# Jobs #
Route::group([
    'name' => 'jobs',
    'prefix' => 'jobs',
], function () {
    Route::get('/', 'JobController@index');
    Route::get('/{job}', 'JobController@show');
    Route::post('/', 'JobController@store');
    Route::Put('/{job}', 'JobController@update');
    Route::delete('/{job}', 'JobController@destroy');
});

# job requirement admin only need to be rename #
Route::group([
    'name' => 'job_requirements',
    'prefix' => 'job_requirements',
], function () {
    Route::get('/', 'JobRequirementController@index');
    Route::get('/{job_requirement}', 'JobRequirementController@show');
    Route::post('/', 'JobRequirementController@store');
    Route::Put('/{job_requirement}', 'JobRequirementController@update');
    Route::delete('/{job_requirement}', 'JobRequirementController@destroy');
});

# app status admin only #
Route::group([
    'name' => 'appstatuses',
    'prefix' => 'appstatuses',
], function () {
    Route::get('/', 'AppStatusController@index');
    Route::get('/{appStatus}', 'AppStatusController@show');
    Route::post('/', 'AppStatusController@store');
    Route::Put('/{appStatus}', 'AppStatusController@update');
    Route::delete('/{appStatus}', 'AppStatusController@destroy');
});

# application #
Route::group([
    'name' => 'applications',
    'prefix' => 'applications',
], function () {
    Route::get('/', 'ApplicationController@index');
    Route::get('/{application}', 'ApplicationController@show');
    Route::post('/', 'ApplicationController@store');
    Route::Put('/{application}', 'ApplicationController@update');
    Route::delete('/{application}', 'ApplicationController@destroy');
});




Route::post('/login', 'Auth\LoginController@login');
Route::post('/register', 'Auth\RegisterController@register');

Route::apiResource('seekers', 'SeekerController');
Route::apiResource('employees', 'EmployeeController');

//#################interviews###########################
Route::get('interviews', 'InterviewController@index');
Route::get('interview/{id}', 'InterviewController@show')->middleware('auth:sanctum');
Route::post('interview', 'InterviewController@store')->middleware('auth:sanctum');
Route::put('interview/{id}', 'InterviewController@update')->middleware('auth:sanctum');
Route::delete('interview/{id}', 'InterviewController@destroy')->middleware('auth:sanctum');
//#######################################################
