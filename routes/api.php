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

Route::post('register','Api\AuthController@register');
Route::post('login','Api\AuthController@login');

Route::group(['middleware'=>'auth:api'], function(){
    Route::get('makanan','Api\MakananController@index');
    Route::get('makanan/{id}','Api\MakananController@show');
    Route::post('makanan','Api\MakananController@store');
    Route::put('makanan/{id}','Api\MakananController@update');
    Route::delete('makanan/{id}','Api\MakananController@destroy');
});

Route::post('register','Api\AuthController@register');
Route::post('login','Api\AuthController@login');

Route::group(['middleware'=>'auth:api'], function(){
    Route::get('minuman','Api\MinumanController@index');
    Route::get('minuman/{id}','Api\MinumanController@show');
    Route::post('minuman','Api\MinumanController@store');
    Route::put('minuman/{id}','Api\MinumanController@update');
    Route::delete('minuman/{id}','Api\MinumanController@destroy');
});

Route::post('register','Api\AuthController@register');
Route::post('login','Api\AuthController@login');

Route::group(['middleware'=>'auth:api'], function(){
    Route::get('transaction','Api\TransactionController@index');
    Route::get('transaction/{id}','Api\TransactionController@show');
    Route::post('transaction','Api\TransactionController@store');
    Route::put('transaction/{id}','Api\TransactionController@update');
    Route::delete('transaction/{id}','Api\TransactionController@destroy');
});