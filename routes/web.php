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

Auth::routes();

//Route::get('/admin/home', function() {
//    return view('home');
//})->name('admin-home')->middleware('auth');

Route::group([
    'prefix' => 'admin',
    'as' => 'admin_',
    'middleware' => 'auth'
], function () {
    Route::get('home', function() {
        return view('home');
    });

    Route::resource('companies', 'Admin\CompanyController');
    Route::post('companies/update/{id}', 'Admin\CompanyController@update');
    Route::resource('employees', 'Admin\EmployeeController');
});
