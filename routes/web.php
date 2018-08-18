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

/*Route::get('/{short_link}', function ($short_link) {
    dd($_SERVER);
    info('test', [__FILE__]);
    //redirect()->to('/');
    header('Location: https://twitter.com/M_Grishin_');
    //header('Location: https://www.vagrantup.com/docs/cli/reload.html');
});*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
