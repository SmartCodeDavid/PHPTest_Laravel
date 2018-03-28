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

Route::get('/tour', 'TourController@index')->name('tour');
Route::get('/tour/create/{id?}', 'TourController@create')->name('create_tour');
Route::post('/tour/create/{id?}', 'TourController@create')->name('create_tour');
Route::get('/tour/edit/{id}', 'TourController@edit')->name("editUrl");
Route::post('/tour/edit/{id}', 'TourController@saveEdit')->name("saveEdit");
Route::get('/tour/book/{id}', 'TourController@book')->name('book');
Route::post('/tour/book/{id}', 'TourController@bookSave')->name('book');
Route::get('/tour/viewbooking', 'TourController@viewBooking')->name('viewbooking');
Route::get('/tour/bookingedit/{id}', 'TourController@bookingEdit')->name('bookingedit');
Route::post('/tour/bookingedit/{id}', 'TourController@saveBookingEdit')->name('bookingedit');
