<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Api\EmailsController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\ForgetPasswordController;

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

//all routes / api here must be api authenticated
Route::group(['middleware' => ['api'/*,'checkPassword',*/,'changeLanguage'], 'namespace' => 'Api'], function () {
    Route::group(['prefix' => 'admin','namespace'=>'Admin'],function (){
        Route::post('login', 'AuthController@login');
        Route::post('logout','AuthController@logout') -> middleware(['auth.guard:admin-api']);

        Route::apiResource('trip', 'TripController');
        Route::apiResource('blog', 'blogController');
        Route::get('home','TripController@home');
        Route::get('homee','blogController@home');
    });

    Route::post('book', 'EmailsController@TripMail');
    Route::post('trip', 'BookController@BookMail');
    Route::post('sendPasswordResetLink' , 'ForgetPasswordController@sendEmail');
    Route::post('resetPassword' , 'ChangePasswordController@passwordResetProcess');
    Route::get('info', function(){
        return phpinfo();
    });

});
