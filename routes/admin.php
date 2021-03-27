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
  Route::get('/', 'views\admin\AdminController@home')->name('admin');
  Route::get('files', 'views\admin\AdminController@files')->name('admin.files');
  Route::get('logout', 'views\admin\AuthController@logout')->name('admin.logout');
  Route::post('password', 'views\admin\AuthController@password')->name('admin.password');

  Route::resource('users', 'views\admin\UserController');
  Route::resource('pages', 'views\admin\PageController');
  Route::resource('posts', 'views\admin\PostController');
  Route::resource('roles', 'views\admin\RoleController');
  Route::resource('permissions', 'views\admin\PermissionController');
  Route::resource('posts', 'views\admin\PostController');
  Route::resource('categories', 'views\admin\CategoryController');
  Route::resource('regions', 'views\admin\RegionController');
  Route::resource('communes', 'views\admin\CommuneController');
  Route::resource('departements', 'views\admin\DepartementController');


  Route::group(['prefix' => 'uploads'], function () {
      Route::post('model/{id}', 'views\admin\UploadController@modelUpload')->name('uploads.model');
      Route::post('setting/{id}', 'views\admin\UploadController@sliderUpload')->name('uploads.slider');
      Route::post('booking/{id}', 'views\admin\UploadController@bookingUpload')->name('uploads.booking');
  });
});
