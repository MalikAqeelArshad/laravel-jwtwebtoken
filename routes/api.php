<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;

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

Route::group(
    [
        'middleware' => 'api',
        'prefix'     => 'auth',
        'namespace'  => 'App\Http\Controllers',
    ],
    function ($router) {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::get('profile', 'AuthController@profile');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('register', 'AuthController@register');
    }
);

Route::group(
    [
        'middleware' => ['api', 'auth.jwt'],
        'namespace'  => 'App\Http\Controllers',
    ],
    function ($router) {
        Route::get('users', 'UsersController@index');
        Route::resource('questions', 'QuestionsController');
        Route::post('questions/{question}/comment', 'QuestionsController@comment');
    }
);

Route::middleware(['api', 'auth.jwt'])->get('/user', function () {
    return auth()->user();
});
