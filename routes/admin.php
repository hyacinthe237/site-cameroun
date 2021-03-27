<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('admin/login', 'views\admin\AuthController@login')->name('admin.login');
Route::post('admin/login', 'views\admin\AuthController@signin')->name('admin.signin');

Route::group(['prefix' => 'admin', 'middleware' => ['admin_auth', 'admin']], function() {
    Route::get('/', 'views\admin\AdminController@dashboard')->name('admin');
    Route::get('/dashboard', 'views\admin\AdminController@getDashboard');
    Route::get('logout', 'views\admin\AuthController@logout')->name('admin.logout');
    Route::post('password', 'views\admin\AuthController@password')->name('admin.password');
    // Route::get('{id}', 'views\admin\BilletController@valid')->name('billets.valid');

    Route::resource('users', 'views\admin\UserController');
    Route::resource('roles', 'views\admin\RoleController');
    Route::resource('permissions', 'views\admin\PermissionController');
    Route::resource('tables', 'views\admin\TableController');
    Route::resource('billets', 'views\admin\BilletController');
});
