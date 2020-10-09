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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home','App\Http\Controllers\MyCocktailController@soft')->middleware('auth');
Route::get('/nonAlc','App\Http\Controllers\MyCocktailController@nonAlc')->middleware('auth');
Route::get('/cocktail','App\Http\Controllers\MyCocktailController@nonAlc')->middleware('auth');
Route::get('/shot','App\Http\Controllers\MyCocktailController@shot')->middleware('auth');
Route::get('/single','App\Http\Controllers\SingleCocktailController@single')->middleware('auth');
Route::post('search','App\Http\Controllers\MyCocktailController@search')->middleware('auth');
Route::get('search','App\Http\Controllers\MyCocktailController@search')->middleware('auth');
Route::get('ingredient','App\Http\Controllers\MyCocktailController@ingredient')->middleware('auth');

