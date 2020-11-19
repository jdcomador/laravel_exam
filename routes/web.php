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
//note: '$namespace' in App\Providers\RouteServiceProvider is null in default. edit it first to access controller.

Route::get('/', 'EmployeeController@show');
Route::post('/employee', 'EmployeeController@create');
Route::put('/employee/{id}', 'EmployeeController@edit');
Route::post('/employee/update', 'EmployeeController@update');
Route::post('/employee/delete', 'EmployeeController@delete');
