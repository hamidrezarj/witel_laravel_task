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

Route::get('/', 'StudentController@index')->name('home');
// Route::match(['get', 'post'], '/', 'StudentController@index')->name('home');
Route::get('/create', 'StudentController@create')->name('create');
Route::post('/create', 'StudentController@store')->name('store');
Route::get('/edit/{id}', 'StudentController@edit')->name('edit');
Route::put('/update/{id}', 'StudentController@update')->name('update');
Route::get('/delete/{id}', 'StudentController@destroy')->name('delete');

// Route::post('/create/order', 'StudentController@order')->name('order');



Route::get('/hello', function () {
    return "HELLO THERE!";
});

Route::get('/user_id/{id}', function ($id) {
    return "Your id is: " .$id;
});