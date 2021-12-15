<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;

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

Route::get('assets/js/translation.js', 'GlobalController@jsTrranslation');

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::as("web.")->group(function(){
    // Auth
    Route::get('login-and-register', ['as' => 'login-and-register', 'uses' => 'Web\AuthController@getLoginAndRegister']);
    Route::post('login', ['as' => 'login', 'uses' => 'Web\AuthController@postLogin']);
    Route::post('register', ['as' => 'register', 'uses' => 'Web\AuthController@postRegister']);

    Route::group(['middleware' => 'auth:web'], function () {

        // Logout
        Route::post('logout', ['as' => 'logout', 'uses' => 'Web\AuthController@postLogout']);

        // User
        Route::resource('user', 'Web\UserController');

    });

});



