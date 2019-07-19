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
Route::group([
    'prefix' => 'account',
    'middleware' => ['api.json']
], function () {
    Route::post('register', 'Api\UserController@store')->name('account.register');
    Route::post('login', 'Api\UserController@login')->name('account.login');
});

Route::group([
    'prefix' => 'account',
    'middleware' => ['api.json', 'auth:api']
], function () {
    Route::get('logout', 'Api\UserController@logout')->name('account.logout');
    Route::get('user', 'Api\UserController@show')->name('user.show');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
