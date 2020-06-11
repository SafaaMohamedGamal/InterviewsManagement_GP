<?php

use App\User;
use App\Http\Resources\User as UserResource;
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
/////////////////////////////////////////////////
// use this middleware for unauthenticated users
// middleware('auth:unAthenticated')
/////////////////////////////////////////////////

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/LoggedInUser', 'UserController@loggedInUser');
    Route::get('/LogoutUser', 'UserController@logoutUser');
    Route::put('resetpassword/{user}', 'Auth\ResetPasswordController@update');

    Route::apiResource('/users', 'UserController');
    Route::apiResource('employees', 'EmployeeController');
    Route::apiResource('seekers', 'SeekerController');
    Route::post('/seekers/uploadcv/{seeker}', 'SeekerController@uploadCV');

    Route::apiResource('/contacttype', 'Contact\ContactTypeController');
    Route::apiResource('/contact', 'Contact\ContactController');

    Route::get('email/resend', 'Auth\VerificationController@resend')->name('verificationapi.resend');

    Route::apiResource('/levels', 'LevelController');
});
#   Authentication  #
Route::post('/login', 'Auth\LoginController@login');
Route::post('/register', 'Auth\RegisterController@register');

#   Verification    #
Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');

#   Cv Downloading  #
Route::get('/seekers/downloadcv/{seeker}/{cvName}', 'SeekerController@downloadCV');

# upload profile photo #
Route::post('/uploadprofielephoto', 'UserController@uploadPhoto')->middleware('auth:sanctum');

# render profile photo #
Route::get('/renderprofileimage/{photo}', 'UserController@renderPhoto');


#  application process and jobs #
Route::middleware('auth:sanctum')->group(function () {
    // jobs controller
    Route::apiResource('/jobs', 'JobController')->except(['index','show']);

    //jobs Requirements  admin only
    Route::apiResource('/jobrequirements', 'JobRequirementController');

    // appStatuses
    Route::apiResource('/appstatuses', 'AppStatusController');

    // applications
    Route::apiResource('/applications', 'ApplicationController')->except(['post']);
});
    #any user or visitors can see jobs#
    Route::get('jobs/', 'JobController@index');
    Route::get('jobs/{job}', 'JobController@show');

    # only verified users mail and should add phone apply for jobs#
    Route::post('applications/', 'ApplicationController@store')->middleware(['auth:sanctum','APIverified','verifiedPhone']);
    // Route::post('applications/', 'ApplicationController@store')->middleware(['auth:sanctum']);

    # check phone verification #
    Route::post('/checkphone', 'Auth\RegisterController@checkPhoneVerification')->middleware('auth:sanctum');

    

//#################interviews###########################
Route::group([
    'middleware'=>'auth:sanctum'
], function () {
    Route::get('interviews', 'InterviewController@index');
    Route::get('interview/{id}', 'InterviewController@show');
    Route::post('interview', 'InterviewController@store');
    Route::put('interview/{id}', 'InterviewController@update');
    Route::delete('interview/{id}', 'InterviewController@destroy');
});
