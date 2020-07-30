<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes(['verify' => true]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', 'HomeController@index')->name('dashboard');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/test', 'TestController@index')->name('test');

    Route::group(['prefix' => 'mpesa', 'as' => 'mpesa.'], function () {
        Route::get('c2b', 'C2BController@index')->name('c2b.index');
        Route::get('stk-push', 'STKPushController@index')->name('stk-push.index');
    });
});

