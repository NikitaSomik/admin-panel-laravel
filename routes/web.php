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

Route::group(['prefix' => 'admin',  'middleware' => 'auth'], function () {
    Route::get('home', function() {
        return view('home');
    })->name('admin_home');

    Route::resource('companies', 'Admin\CompanyController');
    Route::post('companies/get-all', 'Admin\CompanyController@getAllCompanies')->name('companies.get_all');
    Route::resource('employees', 'Admin\EmployeeController');
});
