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


Route::group(['prefix' => 'admin'], function (){

    // Auth Group Routes...
    Route::group(['namespace'=>'Auth\\', 'as'=>'auth.'], function (){
        // Authentication Routes...
        Route::get('login',     'LoginController@showLoginForm')->name('login');
        Route::post('login',    'LoginController@login');
        Route::post('logout',   'LoginController@logout')->name('logout');

        // Forgot Password Routes...
        Route::get('password/reset',    'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email',   'ForgotPasswordController@sendResetLinkEmail')->name('password.email');


        // Password Reset Routes...
        Route::get('password/reset/{token}','ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset',       'ResetPasswordController@reset');
    });

    Route::group(['namespace'=>'Admin\\', 'as'=>'admin.', 'middleware'=>'auth'], function(){
        // Support Route...
        // Route::get('/sysinfo','SupportController@sysinfo')->name('login');
    });

});

Route::get('/home', 'HomeController@index')->name('home');
