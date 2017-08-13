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

    // Administration Group Users Settings Routes...
    Route::group(['prefix' => 'users', 'as' => 'admin.'], function (){
        Route::group(['namespace' => 'Admin\\', 'as' => 'users.'], function (){
           Route::get('settings',   'UserSettingsController@edit')->name('settings.edit');
           Route::put('settings',   'UserSettingsController@update')->name('settings.update');
        });
    });

    // Administration Group Routes...
    Route::group(['namespace'=>'Admin\\', 'as'=>'admin.', 'middleware'=>['auth', 'can:administration']], function(){
        // Support Route...
        Route::get('/sysinfo', function(){
            return view('admin.systeminfo');
        })->name('systeminfo');

        // Dashboard Route...
        Route::get('/dashboard', function(){
            return view('admin.dashboard');
        })->name('dashboard');

        // Users Route..
        Route::group(['prefix' => 'users', 'as' => 'users.'], function(){
            Route::get('show_details', 'UsersController@showDetails')->name('show_details');
            Route::group(['prefix' => '/{user}/profile'], function (){
                Route::get('', 'UserProfileController@edit')->name('profile.edit');
                Route::put('', 'UserProfileController@update')->name('profile.update');
            });
        });
        Route::resource('users', 'UsersController');
    });

});

Route::get('/home', 'HomeController@index')->name('home');
