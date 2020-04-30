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

Route::namespace('Admin')->group(function () {
    Route::get('admin/login', 'LoginController@showLoginForm')->name('admin.login');
    Route::post('admin/login', 'LoginController@login')->name('admin.login');
    Route::get('admin/logout', 'LoginController@logout')->name('admin.logout');
});

Route::group(['prefix' => 'admin', 'middleware' => ['employee'], 'as' => 'admin.' ], function () {
    Route::namespace('Admin')->group(function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');
    
        Route::namespace('Accounts')->group(function () {
            Route::resource('/account/admin', 'AdminController', ['except' => ['show'] ] );
            Route::resource('/account/role', 'RoleController');
        });

        Route::namespace('Maps')->group(function () {
            Route::resource('/maps/view', 'MapController',['only' => ['index']]);
            Route::get('/maps/excel','MapController@reportExcel')->name('report.excel');
            Route::resource('/maps/api', 'MapApiController',['only' => ['index','show','destroy','store']]);
        });
    });
});

/**
 * Customer routes
 */
// Auth::routes();

Route::namespace('Front')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/maps', 'HomeController@maps')->name('maps');
    Route::get('/maps/api', 'HomeController@mapsApi')->name('maps.api');
    Route::get('/data', 'HomeController@data')->name('data');
    Route::get('/data/detail/{id}', 'HomeController@dataDetail')->name('data.detail');
    Route::get('/about', 'HomeController@about')->name('about');
});

