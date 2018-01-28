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

Route::get('/test', function () {
    echo 'Connected to database: ' . DB::connection()->getDatabaseName() . '<br>';
    echo \App\User::all()->count();
    echo 'Visitors count: ' . Redis::incr('visitorsCount');
});
