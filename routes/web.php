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
    return redirect('/home');
});

Route::get('/login', function () {
    if(auth()->check()){
        return redirect('/home');
    }else{
        return view('login');
    }
})->name('login');
Route::post('/login', 'LoginController@enter')->name('login.enter');
Route::get('/logout', 'LoginController@logout')->name('logout');


Route::get('/home', function () {
    return view('base');
})->middleware('auth');


Route::resource('/users', 'UsersController')
        ->middleware(['auth', 'role:ADMIN']);
Route::resource('/settings', 'SettingsController')
        ->middleware(['auth', 'role:ADMIN']);
Route::resource('/meals', 'MealsController')
        ->middleware(['auth', 'role:USER']);
Route::get('/meals/search/{dates}', 'MealsController@search')
        ->name('meals.search')
        ->middleware(['auth', 'role:USER']);