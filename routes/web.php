<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TMDBController;

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


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
  
Route::controller(SearchController::class)->group(function(){
    Route::get('search', 'index');
    Route::get('autocomplete', 'autocomplete')->name('autocomplete');
});

Route::controller(TMDBController::class)->group(function(){
    Route::get('fetch', 'fetch');
});