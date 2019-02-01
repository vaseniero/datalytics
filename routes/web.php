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

Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/home/{dashboard}', function($dashboard) {
    if ($dashboard == 1) {
        Route::get('/home', 'HomeController@index')->name('home');
    }
    elseif ($dashboard == 2) {
        Route::get('/dashboard2', 'HomeController@dashboard2')->name('dashboard2');
    }
    elseif ($dashboard == 3) {
        Route::get('/dashboard3', 'HomeController@dashboard3')->name('dashboard3');
    }
    elseif ($dashboard == 4) {
        Route::get('/dashboard4', 'HomeController@dashboard4')->name('dashboard4');
    }
})->name('dashboard');

Route::get('/admin', 'AdminController@index')->name('admin');

Route::get('/file','FileController@upload')->name('upload');
Route::post('/file','FileController@store')->name('store');

Route::get('/spreadsheet', 'SpreadsheetController@index')->name('spreadsheet');

Route::get('/spreadsheet/chartpercentage/{label}', 'SpreadsheetController@ajaxChartLabelPercentage')->name('spreadsheet.chartLabelPercentage');

Route::get('/spreadsheet/chartvalue/{label}', 'SpreadsheetController@ajaxChartLabelValue')->name('spreadsheet.chartLabelValue');

Route::get('/spreadsheet/{chartLabel}/{dteStart}/{dteEnd}', 'SpreadsheetController@ajaxChartLabelDateRange')->name('spreadsheet.chartLabelDateRange');
