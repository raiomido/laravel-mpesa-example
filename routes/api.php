<?php

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

Route::group(['prefix' => 'v1/m-trx', 'as' => 'api.mpesa.', 'namespace' => 'Api\V1\Payment\Mpesa'], function () {

    Route::group(['prefix' => 'c2b', 'as' => 'c2b.'], function () {
        Route::post('register', 'C2BController@register')->name('register');
        Route::post('simulate', 'C2BController@simulate')->name('simulate');
        Route::post('confirm/{confirmation_key}', 'C2BController@confirmTrx')->name('confirm');
        Route::post('validate/{validation_key}', 'C2BController@validateTrx')->name('validate');
    });

    Route::group(['prefix' => 'stk-push', 'as' => 'stk-push.'], function () {
        Route::post('simulate', 'STKPushController@simulate')->name('simulate');
        Route::post('confirm/{confirmation_key}', 'STKPushController@confirm')->name('confirm');
    });
});
