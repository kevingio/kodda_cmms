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

// set timezone
date_default_timezone_set('Asia/Jakarta');

// auth
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('login',  'Auth\LoginController@showLoginForm');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::patch('profile','HomeController@updateProfile')->name('update-profile');
    Route::patch('change-password/{id}','AccountController@changePassword')->name('change-password');
    Route::resource('inventory','InventoryController')->middleware('role:1,2,6');
    Route::resource('equipment','EquipmentController')->middleware('role:1,2');
    Route::resource('account','AccountController')->middleware('role:1,2');
    Route::resource('work-report','WorkReportController');
    Route::resource('work-order','WorkOrderController')->middleware('role:1,2,3,4');
    Route::resource('maintenance','MaintenanceReportController')->middleware('role:1,2,4');
    Route::resource('pool-management','PoolLogController')->middleware('role:1,2,4');
    Route::resource('energy-report', 'EnergyController')->middleware('role:1,2,4');
    Route::resource('electricity', 'ElectricityReportController')->middleware('role:1,2');
    Route::resource('gas', 'GasReportController')->middleware('role:1,2');
    Route::resource('water', 'WaterReportController')->middleware('role:1,2');
    Route::get('export', 'HomeController@export');
});

Route::prefix('master-data')->name('master.')->middleware(['auth', 'role:1,2'])->group(function () {
    Route::resource('department','DepartmentController');
    Route::resource('job','JobController');
    Route::resource('inventory-model','InventoryModelController');
    Route::resource('equipment-model','EquipmentModelController');
    Route::resource('maintenance-task','MaintenanceTaskController');
    Route::resource('floor','FloorController');
    Route::resource('location','LocationController');
});

/* Ajax from Admin Dashboard */
Route::any('ajax/{page}', function ($page) {
    return app()->call('\App\Http\Controllers\\'.studly_case($page).'Controller@ajax');
});
