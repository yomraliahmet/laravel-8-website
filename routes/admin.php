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

// Auth
Route::get('login', ['as' => 'login', 'uses' => 'AuthController@getLogin']);
Route::post('login', ['as' => 'login', 'uses' => 'AuthController@postLogin']);

Route::group(['middleware' => 'auth:admin'], function () {

    // Logout
    Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);

    // Admin Profile
    Route::get('profile/{admin}/edit', ['as' => 'profile.edit', 'uses' => 'AuthController@getProfile']);
    Route::put('profile/{admin}', ['as' => 'profile.update', 'uses' => 'AuthController@updateProfile']);

    // Admin
    Route::get('admin/datatable',['as' => 'admin.datatable', 'uses' => 'AdminController@datatable']);
    Route::delete('admin/selected/destroy', ['as' => 'admin.selected.destroy', 'uses' => 'AdminController@selectedDestroy']);
    Route::resource('admin','AdminController');

    // Menu
    Route::post('menu/nestable', ['as' => 'menu.nestable', 'uses' => 'MenuController@updateNestable']);
    Route::post('menu/datatable/order', ['as' => 'menu.datatable.order', 'uses' => 'MenuController@order']);
    Route::get('menu/datatable',['as' => 'menu.datatable', 'uses' => 'MenuController@datatable']);
    Route::delete('menu/selected/destroy', ['as' => 'menu.selected.destroy', 'uses' => 'MenuController@selectedDestroy']);
    Route::resource('menu','MenuController');

    // Permission Group
    Route::get('permission-group/datatable',['as' => 'permission-group.datatable', 'uses' => 'PermissionGroupController@datatable']);
    Route::delete('permission-group/selected/destroy', ['as' => 'permission-group.selected.destroy', 'uses' => 'PermissionGroupController@selectedDestroy']);
    Route::resource('permission-group','PermissionGroupController');

    // Role
    Route::get('role/{role}/permission',['as' => 'role.permission', 'uses' => 'RoleController@getPermission']);
    Route::post('role/{role}/permission',['as' => 'role.permission', 'uses' => 'RoleController@setPermission']);
    Route::get('role/datatable',['as' => 'role.datatable', 'uses' => 'RoleController@datatable']);
    Route::delete('role/selected/destroy', ['as' => 'role.selected.destroy', 'uses' => 'RoleController@selectedDestroy']);
    Route::resource('role','RoleController');

    // Contact
    Route::get('/contact', ['as' => 'contact.edit', 'uses' => 'ContactController@edit']);
    Route::put('/contact', ['as' => 'contact.update', 'uses' => 'ContactController@update']);

    // Contact
    Route::get('/setting', ['as' => 'setting.edit', 'uses' => 'SettingController@edit']);
    Route::put('/setting', ['as' => 'setting.update', 'uses' => 'SettingController@update']);

    // Dashboard
    Route::get('/', ['as' => 'home.index', 'uses' => 'HomeController@index']);

});
