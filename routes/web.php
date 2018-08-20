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


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::resource('/', 'Web\ShorterPanelController')->middleware('auth');

Route::get('/{short_link}', 'Web\RedirectController@index');

Route::group(['prefix' => 'auth'], function () {

    Auth::routes();

});



Route::get('/home', 'HomeController@index')->name('home');
Route::post('/ajax/short-link', 'Web\Ajax\ShorterController');
/*
 * статистика по ридеректу для конеретной сслылки
 */
Route::get('/statistic/{code}', 'Web\ShorterPanelController@show'); //todo это ресурс должен быть