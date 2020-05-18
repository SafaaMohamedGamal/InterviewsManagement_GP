<?php

use App\User;
use Illuminate\Http\Request;
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
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
Route::apiResource('/users', 'UserController');
Route::apiResource('/contact', 'Contact\ContactController');
Route::apiResource('/contact_type', 'Contact\ContactTypeController');

Route::post('/login', 'Auth\LoginController@login');

Route::post('/register', 'Auth\RegisterController@register');