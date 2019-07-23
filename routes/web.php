<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/encrypt/request', 'HomeController@takeRequest')->name('tr');
Route::resource('students','TestController');
Route::get('studentsData','TestController@studentsData')->name('studentdata');
Route::get('/viewfile/{id}','TestController@viewfile')->name('viewfile');
